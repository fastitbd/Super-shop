<?php

namespace App\Http\Controllers\Backend;

use AdnSms\AdnSms;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\BankAccount;
use App\Models\InvoiceItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\ActualPayment;
use App\Models\SerialNumber;
use App\Models\SaleSerialNumber;
use Illuminate\Support\Carbon;
use App\Models\BankTransaction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon as CarbonCarbon;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $data['invoice_no'] = $request->invoice_no;
        $data['customer_id'] = $request->customer_id;
        $data['startDate'] = $request->startDate;
        $data['endDate'] = $request->endDate;
        $data['product_id'] = $request->product_id;
        $sdate = Carbon::createFromDate($request->startDate)->toDateString();
        $edate = Carbon::createFromDate($request->endDate)->toDateString();

        $data['invoices'] = Invoice::with('customer', 'user')
            ->orderBy('created_at', 'DESC')
            ->paginate(20);

        if ($request->startDate != null && $request->endDate != null && $request->customer_id != null) {
            $data['invoices'] = Invoice::with('customer', 'user')->whereBetween('date', [$sdate, $edate])->where('customer_id', $request->customer_id)
                ->orderBy('created_at', 'DESC')
                ->paginate(20)->appends([
                    'customer_id' => $request->customer_id,
                    'startDate' => $sdate,
                    'endDate' => $edate,
                ]);
        }
        if ($request->startDate != null && $request->endDate != null) {
            $data['invoices'] = Invoice::with('customer', 'user')->whereBetween('date', [$sdate, $edate])
                ->orderBy('created_at', 'DESC')
                ->paginate(20)->appends([
                    'startDate' => $sdate,
                    'endDate' => $edate,
                ]);
        }
        if ($request->invoice_no != null) {
            $data['invoices'] = Invoice::with('customer', 'user')->where('invoice_no', $request->invoice_no)
                ->orderBy('created_at', 'DESC')
                ->paginate(20)->appends([
                    'invoice_no' => $request->invoice_no,
                ]);
        }
        if ($request->customer_id != null) {
            $data['invoices'] = Invoice::with('customer', 'user')->where('customer_id', $request->customer_id)
                ->orderBy('created_at', 'DESC')
                ->paginate(20)->appends([
                    'customer_id' => $request->customer_id,
                ]);
        }
        if ($request->product_id != null) {
            $keyword = $request->product_id;
            $data['invoices'] = Invoice::whereHas('invoiceItems.product', function ($query) use ($keyword) {
                $query->where('id', $keyword);
            })->orderBy('created_at', 'DESC')->paginate(20)
                ->appends([
                    'keyword' => $request->keyword,
                ]);
        }


        $invoices = Invoice::orderBy('created_at', 'desc')->get();  // Get all invoices
        $latestInvoice = $invoices->first();


        return view('backend.pages.invoice.index', $data, compact('invoices', 'latestInvoice'));
    }

    public function create()
    {
        if (env('APP_SC') == 'yes') {
            $data['products'] = Product::with('unit.related_unit')->orderBy('name', 'ASC')->paginate(8);

            // dd(ProductVariation::where('product_id',$data['products']->id)->get());
            $data['categories'] = Category::orderBy('name', 'ASC')->get();
            $data['customers'] = Customer::get();
            $data['bank_accounts'] = BankAccount::where('status', 1)->get();

            return view('backend.pages.invoice.sc-create', $data);
        } else if (env('APP_IMEI') == 'yes') {

            $data['products'] = Product::with('unit.related_unit')->orderBy('name', 'ASC')->paginate(8);
            $data['categories'] = Category::orderBy('name', 'ASC')->get();
            $data['customers'] = Customer::get();
            $data['bank_accounts'] = BankAccount::where('status', 1)->get();
            return view('backend.pages.invoice.imei-create', $data);
        } else {

            $data['products'] = Product::with('unit.related_unit')->orderBy('name', 'ASC')->paginate(8);
            $data['categories'] = Category::orderBy('name', 'ASC')->get();
            $data['customers'] = Customer::get();
            $data['bank_accounts'] = BankAccount::where('status', 1)->get();
            return view('backend.pages.invoice.create', $data);
        }
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $last_invoice_id = Invoice::orderBy('id', 'DESC')->select('invoice_no')->first();
        if ($last_invoice_id == null) {
            $invoice_no = "INV-0000001";
        } else {
            $invoice_no = $last_invoice_id->invoice_no;
            $invoice_no++;
        }
        $invoice = new Invoice();
        $invoice->date = $request->date;
        $invoice->invoice_no = $invoice_no;
        $invoice->customer_id = $request->customer_id;
        $invoice->estimated_amount = $request->estimated_amount;
        $invoice->discount = ($request->discount_amount == null) ? '0.00' : $request->discount_amount;
        $invoice->discount_amount = $request->discount;
        $invoice->total_amount = $request->payable_amount;
        $invoice->previous_due = $request->previous_due;
        $invoice->note = $request->note;
        $invoice->change_amount = $request->balance;
        $invoice->created_by = auth()->user()->id;

        if ($request->customer_id != 1) {
            $point = $request->payable_amount / 100;
            $invoice->inv_point = $point;
            $customer = Customer::where('id', $request->customer_id)->first();
            $invoice->total_point = $customer->total_point + $point;
            Customer::where("id", $request->customer_id)->update([
                'total_point' => $customer->total_point + $point,
            ]);
        }
        if ($request->pay_point != null) {
            $invoice->pay_point = $request->pay_point;
            $customer = Customer::where('id', $request->customer_id)->first();
            Customer::where("id", $request->customer_id)->update([
                'total_point' => $customer->total_point - $request->pay_point,
            ]);
            $invoice->total_point = $customer->total_point - $request->pay_point;
        }

        DB::transaction(function () use ($request, $invoice) {
            if ($invoice->save()) {

                //save product_id and category_id in invoice_items table where $request->product_id is array of product_id
                foreach ($request->product_id as $key => $product_id) {
                    $invoice_item = new InvoiceItem();
                    $find_unit_id = Product::where('id', $product_id)->first();
                    $invoice_item->invoice_id = $invoice->id;
                    $invoice_item->product_id = $product_id;
                    $invoice_item->rate = $request->rate[$key];
                    if ($find_unit_id->is_service == 0) {
                        if ($find_unit_id->unit->related_unit == null) {
                            $invoice_item->main_qty = $request->main_qty[$key];
                            $saleQty =  $request->main_qty[$key];
                        } else {
                            $invoice_item->main_qty = $request->main_qty[$key];
                            $invoice_item->sub_qty = $request->sub_qty[$key];
                            $main = $request->main_qty[$key] * $find_unit_id->unit->related_value;
                            $sub = $request->sub_qty[$key];
                            $saleQty =  $main + $sub;
                        }
                        $invoice_item->subtotal = $request->sub_total[$key];
                        $invoice_item->inv_subtotal = $request->sub_total[$key];
                        $invoice_item->pur_subtotal = calculateUnitPriceUsingFIFO($product_id, $saleQty);
                    } else {
                        $invoice_item->main_qty = $request->main_qty[$key];
                        $invoice_item->subtotal = $request->sub_total[$key];
                        $invoice_item->inv_subtotal = $request->sub_total[$key];
                        $invoice_item->pur_subtotal = 0.00;
                    }

                    if (!empty($request->variation[$key])) {
                        $invoice_item->product_variation_id = $request->variation[$key];
                    } else {
                        $invoice_item->product_variation_id = null;
                    }
                    $invoice_item->date = $request->date;
                    $invoice_item->save();
                }

                $id = $invoice->id;
                $type = 'Invoice';

                $transaction = new Transaction();
                $transaction->transaction_type = $type;
                $transaction->date = $request->date;
                $transaction->invoice_id = $id;
                $transaction->customer_id = $request->customer_id;
                $transaction->debit = $request->payable_amount;
                $transaction->credit = NULL;
                $transaction->created_by = auth()->user()->id;
                $transaction->save();
                $this->createInvoiceInv($request, $id);
            }
        });
        notify()->success('Invoice Created Successfully');
        return redirect()->route('invoice.print', $invoice->id);
    }

    public function invoiceEdit($id)
    {
        $invoice = Invoice::where('id', $id)->first();
        $invoiceItem = InvoiceItem::where('invoice_id', $id)->get();

        return view('backend.pages.invoice.edit', compact('invoice', 'invoiceItem'));
    }
    public function invoiceUpdate($id, Request $request)
    {
        // dd($request->all());
        $invoice = Invoice::find($id);
        $invoice->date = $request->date;
        $invoice->estimated_amount = $request->estimated_amount;
        $invoice->discount = ($request->discount_amount == null) ? '0.00' : $request->discount_amount;
        $invoice->discount_amount = $request->discount;
        $invoice->total_amount = $request->total_amount;
        $invoice->total_paid = $request->total_paid;
        $invoice->created_by = auth()->user()->id;

        $due = $request->total_amount - $request->total_paid;
        $invoice->total_due = $due;

        if ($invoice->total_due > 0) {
            $invoice->status = 0;
        }

        DB::transaction(function () use ($request, $invoice) {
            if ($invoice->save()) {
                foreach ($request->itemId as $key => $item) {
                    // dd($item);
                    InvoiceItem::where('id', $item)->delete();
                }

                //save product_id and category_id in invoice_items table where $request->product_id is array of product_id
                foreach ($request->product_id as $key => $product_id) {
                    $invoice_item = new InvoiceItem();
                    $find_unit_id = Product::where('id', $product_id)->first();
                    $invoice_item->invoice_id = $invoice->id;
                    $invoice_item->product_id = $product_id;
                    $invoice_item->rate = $request->rate[$key];
                    if ($find_unit_id->unit->related_unit == null) {
                        $invoice_item->main_qty = $request->main_qty[$key];
                    } else {
                        $invoice_item->main_qty = $request->main_qty[$key];
                        $invoice_item->sub_qty = $request->sub_qty[$key];
                    }
                    $invoice_item->subtotal = $request->sub_total[$key];
                    $invoice_item->save();
                }

                $id = $invoice->id;
                $type = 'Invoice';

                // Transaction
                $transaction = new Transaction();
                $transaction->transaction_type = $type;
                $transaction->date = $request->date;
                $transaction->invoice_id = $id;
                $transaction->customer_id = $request->customer_id;
                $transaction->debit = $request->total_amount - $request->total_paid;
                $transaction->credit = NULL;
                $transaction->created_by = auth()->user()->id;
                $transaction->save();
            }
        });

        notify()->success('Invoice Updated Successfully');
        return redirect()->route('invoice.print', $id);
    }

    public function invoiceExchange($id)
    {
        if (env('APP_SC') == 'yes') {
            $data['invoice'] = Invoice::where('id', $id)->first();
            $data['categories'] = Category::orderBy('name', 'ASC')->get();
            $data['customers'] = Customer::get();
            $data['bank_accounts'] = BankAccount::where('status', 1)->get();
            return view('backend.pages.invoice.sc-exchange', $data);
        } else {
            $data['invoice'] = Invoice::where('id', $id)->first();
            $data['categories'] = Category::orderBy('name', 'ASC')->get();
            $data['customers'] = Customer::get();
            $data['bank_accounts'] = BankAccount::where('status', 1)->get();
            return view('backend.pages.invoice.exchange', $data);
        }
    }

    public function returnInvoice($id, Request $request)
    {
        $item = InvoiceItem::where('id', $id)->first();

        DB::transaction(function () use ($request, $item) {
            $item->delete();

            $main_qty = $request->rtn_main;
            $rate = $request->rate;
            $total = $request->totalAmount;
            $esti_amount = $request->estimateAmount;
            $due = $request->dueAmount;
            $paid = $request->paidAmount;

            if ($due == 0.00) {
                $esti_amount = $esti_amount - ($rate * $main_qty);
                $due = $esti_amount - $paid;
            }

            Invoice::where('id', $request->invoice)->update([
                'estimated_amount' => $esti_amount,
                'total_amount' => $esti_amount,
                'total_due' => $due,
                'return_amount' => $request->return_amount,
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
        });
        notify()->success('Successfully return Product');
        return redirect()->back();
    }

    public function updateExchangeInvoice(Request $request)
    {
        // dd($request->all());
        $invoice = Invoice::where('id', $request->id)->first();
        $invoice->date = $invoice->date;
        $invoice->estimated_amount = $request->estimated_amount;
        $invoice->discount = ($request->discount_amount == null) ? '0.00' : $request->discount_amount;
        $invoice->discount_amount = $request->discount;
        $invoice->total_amount = $request->payable_amount;
        $due = $request->payable_amount - $request->total_paid;

        if ($due > 0) {
            $invoice->total_due = $due;
            $invoice->status = 0;
        } else {
            $invoice->change_amount = abs($due);
            $invoice->total_due = 0.00;
            $invoice->status = 1;
        }

        DB::transaction(function () use ($request, $invoice) {
            if ($invoice->save()) {
                $inv_items = InvoiceItem::where('invoice_id', $request->id)->get();
                foreach ($inv_items as $item) {
                    $product = Product::where('id', $item->product_id)->first();
                    if ($product->unit->related_unit == null) {
                        $qty = $item->main_qty;
                    } else {
                        $m_qty = $item->main_qty;;
                        $s_qty = $item->sub_qty;
                        $main = $m_qty * $product->unit->related_value;
                        $qty =  $main + $s_qty;
                    }
                    productStockUpdate($product->id, $qty);
                    $item->delete();
                }
                foreach ($request->product_id as $key => $product_id) {
                    $invoice_item = new InvoiceItem();
                    $find_unit_id = Product::where('id', $product_id)->first();
                    $invoice_item->date = $request->date;
                    $invoice_item->invoice_id = $invoice->id;
                    $invoice_item->product_id = $product_id;
                    $invoice_item->rate = $request->rate[$key];
                    if ($find_unit_id->unit->related_unit == null) {
                        $invoice_item->main_qty = $request->main_qty[$key];
                        $saleQty =  $request->main_qty[$key];
                    } else {
                        $invoice_item->main_qty = $request->main_qty[$key];
                        $invoice_item->sub_qty = $request->sub_qty[$key];
                        $main = $request->main_qty[$key] * $find_unit_id->unit->related_value;
                        $sub = $request->sub_qty[$key];
                        $saleQty =  $main + $sub;
                    }
                    $invoice_item->subtotal = $request->sub_total[$key];
                    $invoice_item->inv_subtotal = $request->sub_total[$key];
                    $invoice_item->product_variation_id = $request->variation[$key] ?? null;
                    $invoice_item->pur_subtotal = calculateUnitPriceUsingFIFO($product_id, $saleQty);
                    $invoice_item->save();
                }

                $id = $invoice->id;
                $type = 'Invoice';

                // Transaction
                $transaction = Transaction::where('invoice_id', $id)->first();
                $transaction->transaction_type = $type;
                $transaction->date = $request->date;
                $transaction->invoice_id = $id;
                $transaction->customer_id = $request->customer_id;
                $transaction->debit = ($request->payable_amount);
                $transaction->credit = NULL;
                $transaction->created_by = auth()->user()->id;
                $transaction->save();
            }
        });

        notify()->success('Successfully exchanged product.');
        return redirect()->route('invoice.index');
    }

    public function destroy(string $id)
    {
        $invoice = Invoice::find($id);

        $invoiceItem = InvoiceItem::where('invoice_id', $id)->get();
        if ($invoice->status != 2) {
            foreach ($invoiceItem as $item) {
                $product = Product::where('id', $item->product_id)->first();
                if ($product->unit->related_unit == null) {
                    $qty = $item->main_qty;
                } else {
                    $m_qty = $item->main_qty;;
                    $s_qty = $item->sub_qty;
                    $main = $m_qty * $product->unit->related_value;
                    $qty =  $main + $s_qty;
                }
                productStockUpdate($product->id, $qty);
                $item->delete();
            }
        } else {
            foreach ($invoiceItem as $item) {
                $item->delete();
            }
        }
        $transactions = Transaction::where('invoice_id', $invoice->id)->get();
        foreach ($transactions as $transaction) {
            if ($transaction->actual_pay_id != NULL) {
                $actualpay = ActualPayment::where('id', $transaction->actual_pay_id)->first();
                $actualpay->amount -= $transaction->credit;
                if ($actualpay->amount <= 0) {
                    $actualpay->delete();
                } else {
                    $actualpay->save();
                }
            }
            $transaction->delete();
        }
        $invoice->delete();
        notify()->success('Invoice deleted successfully');
        return back();
    }

    public function invoicePay($id)
    {
        //get invoice with supplier and user by id
        $invoice = Invoice::with('customer', 'user', 'invoiceItems')
            ->where('id', $id)->first();

        if ($invoice->total_due <= 0) {
            return redirect()->back();
        }
        // return response()->json($invoice);
        //get all payment methods
        $bank_accounts = BankAccount::where('status', 1)->get();
        // return response()->json($bank_accounts);

        return view('backend.pages.invoice.pay', compact('invoice', 'bank_accounts'));
    }

    public function storeInvoiceLog(Request $request)
    {
        $id = $request->invoice_id;
        $this->createInvoiceDue($request, $id);

        notify()->success('Due Paid successfully');
        return redirect()->route('due.invoice.print', $id);
    }
    public function printInvoice($id)
    {

        if (env('APP_IMEI') == 'yes') {
            //get invoice with supplier and user by id
            $invoice = Invoice::with('customer', 'user', 'invoiceItems')
                ->where('id', $id)->first();

            if (get_setting('inv_design') == 'pos') {
                return view('backend.pages.invoice.p-print-imei', compact('invoice'));
            } else {
                return view('backend.pages.invoice.print-imei', compact('invoice'));
            }
        } else {
            //get invoice with supplier and user by id
            $invoice = Invoice::with('customer', 'user', 'invoiceItems')
                ->where('id', $id)->first();

            if (get_setting('inv_design') == 'pos') {
                return view('backend.pages.invoice.p-print', compact('invoice'));
            } elseif (get_setting('inv_design') == 'a5') {
                return view('backend.pages.invoice.afive-print', compact('invoice'));
            } else {
                return view('backend.pages.invoice.print', compact('invoice'));
            }
        }
    }

    public function dueInvoicePrint($id)
    {
        //get invoice with supplier and user by id
        $invoice = Invoice::with('customer', 'user', 'invoiceItems')
            ->where('id', $id)->first();

        return view('backend.pages.invoice.due-print', compact('invoice'));
    }

    function createInvoiceLog($request, $id)
    {
        //added total_paid and total_due in invoice table
        $invoice = Invoice::find($id);
        if ($request->type == 'Due Paid') {
            $invoice->total_paid = $invoice->total_paid + $request->paid_amount;
            $invoice->total_due = $invoice->total_due - $request->paid_amount;
            $invoice->due_pay = $invoice->due_pay + $request->paid_amount;
        } else {
            $invoice->total_paid = $request->paid_amount;
            $invoice->total_due = $request->due_amount;
            $invoice->due_pay = $request->paid_amount;
        }
        //change invoice status to 1 if paid amount is equal to total amount
        if ($request->due_amount == 0) {
            $invoice->status = 1;
        }

        DB::transaction(function () use ($request, $invoice, $id) {
            if ($invoice->save()) {
                //create bank transaction
                if ($request->paid_amount > 0) {
                    //create bank transaction
                    $bank_transaction = new BankTransaction();
                    $bank_transaction->trans_type = 'deposit';
                    if ($request->type == 'Due Paid') {
                        $bank_transaction->date = Carbon::now()->format('Y-m-d');
                    } else {
                        $bank_transaction->date = $request->date;
                    }
                    $bank_transaction->bank_id = $request->bank_id;
                    $bank_transaction->invoice_id = $id;
                    $bank_transaction->amount = $request->paid_amount - $request->balance;
                    $bank_transaction->created_by = auth()->user()->id;
                    $bank_transaction->save();

                    // Transaction
                    $transaction = new Transaction();
                    $transaction->transaction_type = 'Received from Customer';
                    if ($request->type == 'Due Paid') {
                        $transaction->date = Carbon::now()->format('Y-m-d');
                    } else {
                        $transaction->date = $request->date;
                    }
                    $transaction->bank_id = $request->bank_id;
                    $transaction->invoice_id = $id;
                    $transaction->customer_id = $request->customer_id;
                    $transaction->debit = NULL;
                    $transaction->credit = $request->paid_amount  - $request->balance;
                    $transaction->created_by = auth()->user()->id;
                    $transaction->save();
                }
            }
        });
    }

    function createInvoiceInv($request, $id)
    {
        //added total_paid and total_due in invoice table
        $invoice = Invoice::find($id);
        if ($request->type == 'Due Paid') {
            $invoice->total_paid = $invoice->total_paid + $request->paid_amount;
            $invoice->total_due = $invoice->total_due - $request->paid_amount;
            $invoice->due_pay = $invoice->due_pay + $request->due_amount;
        } else {
            $invoice->total_paid = $request->paid_amount;
            $invoice->total_due = $request->due_amount;
        }
        //change invoice status to 1 if paid amount is equal to total amount
        if ($request->due_amount == 0) {
            $invoice->status = 1;
        }

        DB::transaction(function () use ($request, $invoice, $id) {
            if ($invoice->save()) {
                $paymentType = $request->input('payment_type');
                if ($paymentType === 'pos') {
                    if ($request->paid_amount > 0) {
                        //create bank transaction
                        $bank_transaction = new BankTransaction();
                        $bank_transaction->trans_type = 'deposit';
                        $bank_transaction->pay_type = 'invpay';
                        if ($request->type == 'Due Paid') {
                            $bank_transaction->date = Carbon::now()->format('Y-m-d');
                        } else {
                            $bank_transaction->date = $request->date;
                        }
                        $bank_transaction->bank_id = $request->bank_id;
                        $bank_transaction->invoice_id = $id;
                        $bank_transaction->amount = $request->paid_amount - $request->balance;
                        $bank_transaction->created_by = auth()->user()->id;
                        $bank_transaction->save();

                        // Transaction
                        $transaction = new Transaction();
                        $transaction->transaction_type = 'Received from Customer';
                        if ($request->type == 'Due Paid') {
                            $transaction->date = Carbon::now()->format('Y-m-d');
                        } else {
                            $transaction->date = $request->date;
                        }
                        $transaction->bank_id = $request->bank_id;
                        $transaction->invoice_id = $id;
                        $transaction->customer_id = $request->customer_id;
                        $transaction->debit = NULL;
                        $transaction->credit = $request->paid_amount  - $request->balance;
                        $transaction->created_by = auth()->user()->id;
                        $transaction->save();
                    }
                } elseif ($paymentType === 'checking') {
                    $amounts = $request->input('amounts');
                    // Create bank transaction
                    foreach ($amounts as $bankId => $amount) {
                        // Check if the amount is greater than 0 before creating a transaction
                        if ($amount > 0) {
                            // Create bank transaction
                            $bank_transaction = new BankTransaction();
                            $bank_transaction->trans_type = 'deposit';
                            $bank_transaction->pay_type = 'invpay';

                            if ($request->type == 'Due Paid') {
                                $bank_transaction->date = Carbon::now()->format('Y-m-d');
                            } else {
                                $bank_transaction->date = $request->date;
                            }
                            $bank_transaction->bank_id = $bankId;
                            $bank_transaction->invoice_id = $id;
                            $bank_transaction->amount = $amount - $request->balance; // Adjusted amount
                            $bank_transaction->created_by = auth()->user()->id;
                            // Save the transaction
                            $bank_transaction->save();
                        }
                    }
                    // Transaction
                    foreach ($amounts as $bankId => $amount) {
                        // Check if the amount is greater than 0 before creating a transaction
                        if ($amount > 0) {
                            $transaction = new Transaction();
                            $transaction->transaction_type = 'Received from Customer';
                            if ($request->type == 'Due Paid') {
                                $transaction->date = Carbon::now()->format('Y-m-d');
                            } else {
                                $transaction->date = $request->date;
                            }
                            $transaction->bank_id = $bankId;
                            $transaction->invoice_id = $id;
                            $transaction->customer_id = $request->customer_id;
                            $transaction->debit = NULL;
                            $transaction->credit = $amount  - $request->balance;
                            $transaction->created_by = auth()->user()->id;
                            $transaction->save();
                        }
                    }
                }
            }
        });
    }

    function createInvoiceDue($request, $id)
    {
        //added total_paid and total_due in invoice table
        $invoice = Invoice::find($id);
        if ($request->type == 'Due Paid') {
            $invoice->total_paid = $invoice->total_paid + $request->paid_amount;
            $invoice->total_due = $invoice->total_due - $request->paid_amount;
            $invoice->due_pay = $invoice->due_pay + $request->paid_amount;
        } else {
            $invoice->total_paid = $request->paid_amount;
            $invoice->total_due = $request->due_amount;
            $invoice->due_pay = $request->paid_amount;
        }
        //change invoice status to 1 if paid amount is equal to total amount
        if ($request->due_amount == 0) {
            $invoice->status = 1;
        }

        DB::transaction(function () use ($request, $invoice, $id) {
            if ($invoice->save()) {
                //create bank transaction
                if ($request->paid_amount > 0) {
                    //create bank transaction
                    $bank_transaction = new BankTransaction();
                    $bank_transaction->trans_type = 'deposit';
                    $bank_transaction->pay_type = 'duepay';
                    if ($request->type == 'Due Paid') {
                        $bank_transaction->date = Carbon::now()->format('Y-m-d');
                    } else {
                        $bank_transaction->date = $request->date;
                    }
                    $bank_transaction->bank_id = $request->bank_id;
                    $bank_transaction->invoice_id = $id;
                    $bank_transaction->amount = $request->paid_amount - $request->balance;
                    $bank_transaction->created_by = auth()->user()->id;
                    $bank_transaction->save();

                    // Transaction
                    $transaction = new Transaction();
                    $transaction->transaction_type = 'Received from Customer';
                    if ($request->type == 'Due Paid') {
                        $transaction->date = Carbon::now()->format('Y-m-d');
                    } else {
                        $transaction->date = $request->date;
                    }
                    $transaction->bank_id = $request->bank_id;
                    $transaction->invoice_id = $id;
                    $transaction->customer_id = $request->customer_id;
                    $transaction->debit = NULL;
                    $transaction->credit = $request->paid_amount  - $request->balance;
                    $transaction->created_by = auth()->user()->id;
                    $transaction->save();
                }
            }
        });
    }
}
