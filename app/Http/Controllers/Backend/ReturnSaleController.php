<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Customer;
use App\Models\ReturnTbl;
use App\Models\ReturnItem;
use App\Models\BankAccount;
use App\Models\InvoiceItem;
use App\Models\Transaction;
use App\Models\PurchaseItem;
use Illuminate\Http\Request;
use App\Models\ActualPayment;
use App\Models\BankTransaction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReturnSaleController extends Controller
{
    public function index(Request $request)
    {
        $data['returns'] = ReturnTbl::orderBy('created_at', 'desc')->paginate(20);
        $data['customers'] = Customer::orderBy('name', 'DESC')->get();
        $data['customer_id'] = $request->customer_id;
        $data['startDate'] = $request->startDate;
        $data['endDate'] = $request->endDate;
        $sdate = Carbon::createFromDate($request->startDate)->toDateString();
        $edate = Carbon::createFromDate($request->endDate)->toDateString();
        // dd($sdate,$edate);
        if ($request->customer_id != NULL) {
            $returnItem = ReturnTbl::where('customer_id', $request->customer_id)
                ->orderBy('created_at', 'DESC');
            $data['returns'] = $returnItem->get();
        }

        if ($request->startDate != NULL && $request->endDate != NULL) {
            $returnItem = ReturnTbl::whereBetween('date', [$sdate, $edate])->orderBy('created_at', 'DESC');
            $data['returns'] = $returnItem->get();
        }
        return view('backend.pages.return.sale.index', $data);
    }

    public function create($id)
    {

        if (Invoice::where('status', 2)->where('id', $id)->first()) {
            notify()->warning('Product already returned');
            return redirect()->back();
        } else {

            $data['invoice'] = Invoice::where('id', $id)->first();
            $data['bank_accounts'] = BankAccount::where('status', 1)->get();
            return view('backend.pages.return.sale.create', $data);
        }
    }


    public function insert(Request $request)
    {
        // dd($request->all());
        $return = new ReturnTbl();
        $return->date = $request->date;
        $return->invoice_id = $request->invoice_id;
        $return->customer_id = $request->customer_id;
        $return->estimated_amount = $request->estimated_amount;
        $return->discount_amount = $request->discount_amount;
        $return->total_return = $request->payable_amount;
        $return->created_by = auth()->user()->id;

        DB::transaction(function () use ($request, $return) {
            if ($return->save()) {

                // dd(count($request->invoiceItem_id));
                //save product_id and category_id in purchase_items table where $request->product_id is array of product_id
                foreach ($request->item_id as $key => $item_id) {
                    $returnItem = new ReturnItem();
                    $returnItem->date = $request->date;
                    $returnItem->return_id = $return->id;
                    $returnItem->invoice_id = $request->invoice_id;
                    $returnItem->product_id = $request->product_id[$key];
                    $returnItem->rate = $request->new_rate[$key];
                    $returnItem->product_variation_id = $request->product_variation_id[$key];
                    $returnItem->purchase_price = $request->purchase_price[$key];
                    $find_unit_id = Product::where('id', $request->product_id)->first();
                    if ($find_unit_id->unit->related_unit == null) {
                        $returnItem->main_qty = $request->main_qty[$key];
                        $qty =  $request->main_qty[$key];
                    } else {
                        $returnItem->main_qty = $request->main_qty[$key];
                        $returnItem->sub_qty = $request->sub_qty[$key];
                        $main = $request->main_qty[$key] * $find_unit_id->unit->related_value;
                        $sub = $request->sub_qty[$key];
                        $qty =  $main + $sub;
                    }
                    $pur_sub = $request->purchase_price[$key] * $qty;
                    productStockUpdate($request->product_id, $qty);
                    $returnItem->subtotal = $request->sub_total[$key];
                    $returnItem->pur_subtotal = $pur_sub;
                    // $returnItem->product_variation_id = $request->variation[$key] ?? null;
                    $returnItem->save();

                    $pur_pro_id = InvoiceItem::where('invoice_id', $request->invoice_id)
                        ->where('product_id', $request->product_id[$key])
                        ->first();
                    $rtn_pur_pro_id = ReturnItem::where('invoice_id', $request->invoice_id)
                        ->where('product_id', $request->product_id[$key])
                        ->first();
                    $pur_pro_id->update([
                        'rtn_main' => $pur_pro_id->rtn_main + $request->main_qty[$key],
                        'rtn_sub' => $pur_pro_id->rtn_sub + $request->sub_qty[$key],
                        'rtn_total' => $pur_pro_id->rtn_total + $request->sub_total[$key],
                    ]);
                    $pur_pro_ids = InvoiceItem::where('invoice_id', $request->invoice_id)
                        ->where('product_id', $request->product_id[$key])
                        ->first();
                    $main_product_qty = $request->rtn_main;
                    if ($pur_pro_ids->main_qty == $pur_pro_ids->rtn_main) {
                        $pur = InvoiceItem::where('id', $request->item_id[$key])
                            ->update([
                                'is_return' => 1,
                            ]);
                    }

                    $purItem = PurchaseItem::where('product_id', $request->product_id[$key])
                        ->where('product_id', $request->product_id[$key])
                        ->when($request->product_variation_id[$key], function ($q) use ($request, $key) {
                            $q->where('product_variation_id', $request->product_variation_id[$key]);
                        })
                        ->first();

                    if ($purItem) {
                        $purItem->update([
                            'stock_qty' => $purItem->stock_qty + $request->main_qty[$key],
                        ]);
                    }
                }
                //create purchase log call createPurchaseLog function
                $id = $return->id;
                $type = 'Invoice Return';
                // dd($id);

                $transaction = new Transaction();
                $transaction->transaction_type = $type;
                $transaction->date = date('Y-m-d');
                $transaction->bank_id = $request->bank_id;
                $transaction->return_id = $id;
                $transaction->customer_id = $request->customer_id;
                $transaction->credit = $request->payable_amount;
                $transaction->debit = NULL;
                $transaction->created_by = auth()->user()->id;
                $transaction->save();

                $this->createReturnLog($request, $id, $type);
            }
        });
        notify()->success('Sale Product Return Successfully');
        return redirect()->route('return.sale');
    }

    public function delete($id)
    {
        $return = ReturnTbl::find($id);
        $transactions = Transaction::where('return_id', $return->id)->get();
        $bank_transaction = BankTransaction::where('return_id', $return->id)->get();
        foreach ($transactions as $transaction) {
            if ($transaction->actual_pay_id != NULL) {
                $actualpay = ActualPayment::where('id', $transaction->actual_pay_id)->first();
                $actualpay->amount -= $transaction->debit;
                if ($actualpay->amount <= 0) {
                    $actualpay->delete();
                } else {
                    $actualpay->save();
                }
            }
            $transaction->delete();
        }
        foreach ($bank_transaction as $bank) {
            $bank->delete();
        }
        $return->delete();
        notify()->success('Return deleted successfully');
        return back();
    }

    function createReturnLog(Request $request, $id, $type)
    {
        $invoice_item = InvoiceItem::where('invoice_id', $request->invoice_id)->count();
        $return_item_count = ReturnItem::where('invoice_id', $request->invoice_id)->count();
        $invoice = Invoice::where('id', $request->invoice_id)->first();
        $invoice_items = InvoiceItem::where('invoice_id', $request->invoice_id)->get();


        $allReturned = $invoice_items->every(function ($item) {
            return $item->is_return == 1;
        });

        if ($allReturned) {
            Invoice::where('id', $request->invoice_id)
                ->update([
                    'status' => 2,
                ]);
        }
        Invoice::where('id', $request->invoice_id)->update([

            'return_amount' => $invoice->return_amount + $request->payable_amount,
        ]);

        if ($invoice->total_amount == $invoice->total_paid) {
            Invoice::where('id', $request->invoice_id)->update([
                'return_amount' => $invoice->return_amount + $request->payable_amount,
            ]);

            //create bank transaction
            $bank_transaction = new BankTransaction();
            $bank_transaction->trans_type = 'withdraw';
            $bank_transaction->date = date('Y-m-d');
            $bank_transaction->bank_id = $request->bank_id;
            $bank_transaction->return_id = $id;
            $bank_transaction->pay_type = 'rtn_pay';
            $bank_transaction->amount = $request->payable_amount;
            $bank_transaction->created_by = auth()->user()->id;
            $bank_transaction->save();

            // Transaction
            $transaction = new Transaction();
            $transaction->transaction_type = 'Return Money to customer';
            $transaction->date = date('Y-m-d');
            $transaction->bank_id = $request->bank_id;
            $transaction->return_id = $id;
            $transaction->customer_id = $request->customer_id;
            $transaction->debit = $request->payable_amount;
            $transaction->credit = NULL;
            $transaction->created_by = auth()->user()->id;
            $transaction->save();
        } elseif ($invoice->total_amount == $invoice->total_due) {
            Invoice::where('id', $request->invoice_id)->update([
                'return_amount' => $invoice->return_amount,
            ]);
        } else {
            if ($request->payable_amount < $invoice->total_due) {
                Invoice::where('id', $request->invoice_id)->update([
                    'return_amount' => $invoice->return_amount,
                ]);
            } else {
                $amount = $request->payable_amount - $invoice->total_due;
                Invoice::where('id', $request->invoice_id)->update([
                    'return_amount' => $invoice->return_amount + $amount,
                    'total_due' => 0,
                    'status' => 1,
                ]);

                $bank_transaction = new BankTransaction();
                $bank_transaction->trans_type = 'withdraw';
                $bank_transaction->date = date('Y-m-d');
                $bank_transaction->bank_id = $request->bank_id;
                $bank_transaction->pay_type = 'rtn_pay';
                $bank_transaction->return_pur_id = $id;
                $bank_transaction->amount = $invoice->return_amount + $amount;
                $bank_transaction->created_by = auth()->user()->id;
                $bank_transaction->save();

                // Transaction
                $transaction = new Transaction();
                $transaction->transaction_type = 'Return Money to customer';
                $transaction->date = date('Y-m-d');
                $transaction->bank_id = $request->bank_id;
                $transaction->return_pur_id = $id;
                $transaction->customer_id = $request->customer_id;
                $transaction->credit = NULL;
                $transaction->debit = $invoice->return_amount + $amount;
                $transaction->created_by = auth()->user()->id;
                $transaction->save();
            }
        }


        // }

    }
}
