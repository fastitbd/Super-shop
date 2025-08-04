<?php

namespace App\Http\Controllers\Backend;

use App\Models\Invoice;
use App\Models\Customer;
use App\Models\BankAccount;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\ActualPayment;
use App\Models\BankTransaction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Support\Carbon;

class PaymentController extends Controller
{
    public function payCustomer(Request $request)
    {
        $data['payment'] = ActualPayment::with('transaction')
            ->where('account_type', 'Customer')
            ->orderBy('created_at', 'DESC')
            ->paginate(10);
        $data['customers'] = Customer::orderBy('name', 'DESC')->get();
        $data['customer_id'] = $request->customer_id;

        $paymentQuery = ActualPayment::with('transaction')
            ->where('account_type', 'Customer')
            ->orderBy('created_at', 'DESC');

        $pay_id=Transaction::orderBy('id','asc')->get();
        if ($request->has('customer_id') && !empty($request->customer_id)) {
                $customer_id = $request->customer_id;
                $paymentQuery->whereHas('transaction', function($query) use ($customer_id) {
                    $query->where('customer_id', $customer_id);
            });
        }
        // dd($paymentQuery);
        if ($request->has('start_date') && $request->has('end_date')) {
            $sdate = Carbon::createFromDate($request->start_date)->toDateString();
            $edate = Carbon::createFromDate($request->end_date)->toDateString();
            $paymentQuery->whereBetween('date', [$sdate, $edate]);
        }

        $data['payment'] = $paymentQuery->get();

        $data['customers'] = Customer::orderBy('name', 'DESC')->get();
        $data['customer_id'] = $request->customer_id;
        $data['bank_accounts'] = BankAccount::where('status', 1)->get();

        return view('backend.pages.payment.customer_index', $data);
    }

    public function payCustomerStore(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'customer_id' => 'required',
            'account_type' => 'required',
            'wallet_type' => 'required',
            'pay_type' => 'required',
            'amount' => 'required|numeric',
            'bank_id' => 'required',
        ]);

        if ($request->wallet_type == 'Due Adjust') {
            if ($request->amount > $request->invoice_due ) {
                notify()->error('Sorry ! You approve maximum due adjust amount.');
                return back();
            }
        }

        $payment = new ActualPayment();
        $payment->date = $request->date;
        $payment->account_type = $request->account_type;
        $payment->wallet_type = $request->wallet_type;
        $payment->pay_type = $request->pay_type;
        $payment->amount = $request->amount;
        $payment->discount_amount = $request->discount_amount;
        $payment->note = $request->note;

        DB::transaction(function() use($request, $payment) {
            if ($payment->save()) {
                if ($request->wallet_type == 'Due Adjust') {
                    $invoices = Invoice::where('customer_id', $request->customer_id)->where('status', 0)->latest()->get();
                    if ($invoices->isNotEmpty()) {
                        $amount = $payment->amount + $payment->discount_amount;
                        foreach ($invoices as $invoice) {
                            $duePay = $invoice->total_due;
                            if ($duePay <= $amount) {
                                $invoice->total_paid += $duePay;
                                $invoice->total_due -= $duePay;
                                if ($invoice->total_due == 0.00) {
                                    $invoice->status = 1;
                                }
                            } elseif ($duePay >= $amount) {
                                $invoice->total_paid += $amount;
                                $invoice->total_due -= $amount;
                            }
                            if ($invoice->save()) {
                                $transaction = new Transaction();
                                $bank_transaction = new BankTransaction();
                                $transaction->transaction_type = 'Received from Customer';
                                $transaction->date = $request->date;
                                $transaction->bank_id = $request->bank_id;
                                $transaction->invoice_id = $invoice->id;
                                $transaction->actual_pay_id = $payment->id;
                                $transaction->customer_id = $request->customer_id;
                                $transaction->debit = NULL;
                                if ($duePay <= $amount) {
                                    $transaction->credit = $duePay;
                                } elseif ($duePay >= $amount) {
                                    $transaction->credit = $amount;
                                }
                                // Bank Transaction
                                $bank_transaction->trans_type = 'deposit';
                                $bank_transaction->date = $request->date;
                                $bank_transaction->bank_id = $request->bank_id;
                                $bank_transaction->invoice_id = $invoice->id;
                                $bank_transaction->actual_pay_id = $payment->id;

                                if ($duePay <= $amount) {
                                    $bank_transaction->amount = $duePay;
                                } elseif ($duePay >= $amount) {
                                    $bank_transaction->amount = $amount;
                                }
                                $bank_transaction->created_by = auth()->user()->id;
                                $bank_transaction->save();
                                $transaction->created_by = auth()->user()->id;
                                $transaction->save();
                            }
                            $amount -= $duePay;
                            if ($amount <= 0) {
                                break;
                            }
                        }
                    }
                }
                if ($request->wallet_type == 'Balance Adjust') {
                    $transaction = new Transaction();
                    $bank_transaction = new BankTransaction();
                    if ($request->pay_type == 'Money Received') {
                        $transaction->transaction_type = 'Money Received from Customer';
                        $transaction->date = $request->date;
                        $transaction->bank_id = $request->bank_id;
                        $transaction->actual_pay_id = $payment->id;
                        $transaction->customer_id = $request->customer_id;
                        $transaction->debit = $request->amount;
                        $transaction->credit = NULL;
                        // Bank Transaction
                        $bank_transaction->trans_type = 'deposit';
                        $bank_transaction->date = $request->date;
                        $bank_transaction->bank_id = $request->bank_id;
                        $bank_transaction->actual_pay_id = $payment->id;
                        $bank_transaction->amount = $request->amount;
                    }
                    if ($request->pay_type == 'Money Payment') {
                        $transaction->transaction_type = 'Money Payment to Customer';
                        $transaction->date = $request->date;
                        $transaction->bank_id = $request->bank_id;
                        $transaction->actual_pay_id = $payment->id;
                        $transaction->customer_id = $request->customer_id;
                        $transaction->debit = NULL;
                        $transaction->credit = $request->amount;

                        // Bank Transaction
                        $bank_transaction->trans_type = 'withdraw';
                        $bank_transaction->date = $request->date;
                        $bank_transaction->bank_id = $request->bank_id;
                        $bank_transaction->actual_pay_id = $payment->id;
                        $bank_transaction->amount = $request->amount;
                    }
                    $bank_transaction->created_by = auth()->user()->id;
                    $bank_transaction->save();
                    $transaction->created_by = auth()->user()->id;
                    $transaction->save();
                }
            }
        });
        notify()->success('Customer payment created successfully');
        return back();
    }

    public function paySupplier(Request $request)
    {
        $data['payment'] = ActualPayment::with('transaction')
                    ->where('account_type', 'Supplier')
                    ->orderBy('created_at', 'DESC')
                    ->paginate(10);
        $data['suppliers'] = Supplier::orderBy('name', 'DESC')->get();
        $data['supplier_id'] = $request->supplier_id;

        $paymentQuery = ActualPayment::with('transaction')
        ->where('account_type', 'Supplier')
        ->orderBy('created_at', 'DESC');

        $pay_id=Transaction::orderBy('id','asc')->get();
        if ($request->supplier_id != null) {
            $supplier_id = $request->supplier_id;
            $acctual_pay_id=ActualPayment::with('transaction')->where('account_type', 'Supplier')->orderBy('id','asc')->first();
            // dd($acctual_pay_id);
            $transaction = Transaction::where('actual_pay_id',$acctual_pay_id)->orderBy('id','asc')->get();
            // dd($transaction->id);
            $paymentQuery = ActualPayment::with('transaction')
            ->where('account_type', 'Supplier')
            // ->where('id',$transaction->actualPayment()->id)
            ->orderBy('created_at', 'DESC');
        }
        // dd($paymentQuery);
            if ($request->has('start_date') && $request->has('end_date')) {
            $sdate = Carbon::createFromDate($request->start_date)->toDateString();
            $edate = Carbon::createFromDate($request->end_date)->toDateString();
            $paymentQuery->whereBetween('date', [$sdate, $edate]);
        }

        $data['payment'] = $paymentQuery->get();

        $data['suppliers'] = Supplier::orderBy('name', 'DESC')->get();
        $data['supplier_id'] = $request->supplier_id;
        $data['bank_accounts'] = BankAccount::where('status', 1)->get();

        return view('backend.pages.payment.supplier_index', $data);
    }

    public function paySupplierStore(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'supplier_id' => 'required',
            'account_type' => 'required',
            'wallet_type' => 'required',
            'pay_type' => 'required',
            'amount' => 'required|numeric',
            'bank_id' => 'required',
        ]);

        if ($request->wallet_type == 'Due Adjust') {
            if ($request->amount > $request->purchase_due ) {
                notify()->error('Sorry ! You approve maximum due adjust amount.');
                return back();
            }
        }

        $payment = new ActualPayment();
        $payment->date = $request->date;
        $payment->account_type = $request->account_type;
        $payment->wallet_type = $request->wallet_type;
        $payment->pay_type = $request->pay_type;
        $payment->amount = $request->amount;
        $payment->discount_amount = $request->discount_amount;
        $payment->supplier_id = $request->supplier_id;
        $payment->note = $request->note;

        DB::transaction(function() use($request, $payment) {
            if ($payment->save()) {
                if ($request->wallet_type == 'Due Adjust') {
                    $purchases = Purchase::where('supplier_id', $request->supplier_id)->where('status', 0)->latest()->get();
                    if ($purchases->isNotEmpty()) {
                        $amount = $payment->amount + $request->discount_amount;
                        foreach ($purchases as $purchase) {
                            $duePay = $purchase->total_due;
                            if ($duePay <= $amount) {
                                $purchase->total_paid += $duePay;
                                $purchase->total_due -= $duePay;
                                if ($purchase->total_due == 0.00) {
                                    $purchase->status = 1;
                                }
                            } elseif ($duePay >= $amount) {
                                $purchase->total_paid += $amount;
                                $purchase->total_due -= $amount;
                            }
                            if ($purchase->save()) {
                                $transaction = new Transaction();
                                $bank_transaction = new BankTransaction();
                                $transaction->transaction_type = 'Money Payment to Supplier';
                                $transaction->date = $request->date;
                                $transaction->bank_id = $request->bank_id;
                                $transaction->purchase_id = $purchase->id;
                                $transaction->actual_pay_id = $payment->id;
                                $transaction->supplier_id = $request->supplier_id;
                                if ($duePay <= $amount) {
                                    $transaction->debit = $duePay;
                                } elseif ($duePay >= $amount) {
                                    $transaction->debit = $amount;
                                }
                                $transaction->credit = NULL;
                                // Bank Transaction
                                $bank_transaction->trans_type = 'withdraw';
                                $bank_transaction->date = $request->date;
                                $bank_transaction->bank_id = $request->bank_id;
                                $bank_transaction->purchase_id = $purchase->id;
                                $bank_transaction->actual_pay_id = $payment->id;

                                if ($duePay <= $amount) {
                                    $bank_transaction->amount = $duePay;
                                } elseif ($duePay >= $amount) {
                                    $bank_transaction->amount = $amount;
                                }
                                $bank_transaction->created_by = auth()->user()->id;
                                $bank_transaction->save();
                                $transaction->created_by = auth()->user()->id;
                                $transaction->save();
                            }
                            $amount -= $duePay;
                            if ($amount <= 0) {
                                break;
                            }
                        }
                    }
                }
                if ($request->wallet_type == 'Balance Adjust') {
                    $transaction = new Transaction();
                    $bank_transaction = new BankTransaction();
                    if ($request->pay_type == 'Money Received') {
                        $transaction->transaction_type = 'Money Received from Supplier';
                        $transaction->date = $request->date;
                        $transaction->bank_id = $request->bank_id;
                        $transaction->actual_pay_id = $payment->id;
                        $transaction->supplier_id = $request->supplier_id;
                        $transaction->debit = $request->amount;
                        $transaction->credit = NULL;
                        // Bank Transaction
                        $bank_transaction->trans_type = 'deposit';
                        $bank_transaction->date = $request->date;
                        $bank_transaction->bank_id = $request->bank_id;
                        $bank_transaction->actual_pay_id = $payment->id;
                        $bank_transaction->amount = $request->amount;
                    }
                    if ($request->pay_type == 'Money Payment') {
                        $transaction->transaction_type = 'Money Payment to Supplier';
                        $transaction->date = $request->date;
                        $transaction->bank_id = $request->bank_id;
                        $transaction->actual_pay_id = $payment->id;
                        $transaction->supplier_id = $request->supplier_id;
                        $transaction->debit = NULL;
                        $transaction->credit = $request->amount;

                        // Bank Transaction
                        $bank_transaction->trans_type = 'withdraw';
                        $bank_transaction->date = $request->date;
                        $bank_transaction->bank_id = $request->bank_id;
                        $bank_transaction->actual_pay_id = $payment->id;
                        $bank_transaction->amount = $request->amount;
                    }
                    $bank_transaction->created_by = auth()->user()->id;
                    $bank_transaction->save();
                    $transaction->created_by = auth()->user()->id;
                    $transaction->save();
                }
            }
        });
        notify()->success('Supplier payment created successfully');
        return back();
    }

    public function customerDestroy(string $id)
    {
        $pay = ActualPayment::find($id);
        if ($pay->wallet_type == 'Due Adjust') {
            $transactions = Transaction::where('actual_pay_id', $pay->id)->get();
            foreach ($transactions as $transaction) {
                $invoice = Invoice::where('id', $transaction->invoice_id)->first();
                $invoice->total_paid -= $transaction->credit;
                $invoice->total_due += $transaction->credit;
                if ($invoice->total_paid == 0.00) {
                    $invoice->status = 0;
                }
                $invoice->save();
                $transaction->delete();
            }
        }
        $pay->delete();
        notify()->success('Payment deleted successfully');
        return back();
    }

    public function supplierDestroy(string $id)
    {
        $pay = ActualPayment::find($id);
        if ($pay->wallet_type == 'Due Adjust') {
            $transactions = Transaction::where('actual_pay_id', $pay->id)->get();
            foreach ($transactions as $transaction) {
                $purchase = Purchase::where('id', $transaction->purchase_id)->first();
                $purchase->total_paid -= $transaction->debit;
                $purchase->total_due += $transaction->debit;
                if ($purchase->total_paid == 0.00) {
                    $purchase->status = 0;
                }
                $purchase->save();
                $transaction->delete();
            }
        }
        $pay->delete();
        notify()->success('Payment deleted successfully');
        return back();
    }
}
