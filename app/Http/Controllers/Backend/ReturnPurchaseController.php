<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\BankTransaction;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\ReturnPurchase;
use App\Models\ReturnPurchaseItem;
use App\Models\Supplier;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReturnPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['returns'] = ReturnPurchase::orderBy('created_at', 'desc')->paginate(10);
        $data['suppliers'] = Supplier::orderBy('created_at', 'desc')->get();
        $sdate = Carbon::createFromDate($request->startDate)->toDateString();
        $edate = Carbon::createFromDate($request->endDate)->toDateString();

        if ($request->supplier_id != NULL) {
            $returnItem = ReturnPurchase::where('supplier_id', $request->supplier_id)
                ->orderBy('id', 'DESC');
            $data['returns'] = $returnItem->get();
        }

        if ($request->startDate != NULL && $request->endDate != NULL) {
            $returnItem = ReturnPurchase::whereBetween('date', [$sdate, $edate])->orderBy('created_at', 'DESC');
            $data['returns'] = $returnItem->get();
        }


        // dd($returns);
        return view('backend.pages.return.purchase.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (Purchase::where('status', 2)->where('id', $id)->first()) {
            notify()->warning('Product already returned');
            return redirect()->back();
        } else {
            $data['purchase'] = Purchase::where('id', $id)->first();
            // $data['categories'] = Category::orderBy('name', 'ASC')->get();
            $data['suppliers'] = Supplier::get();
            $data['bank_accounts'] = BankAccount::where('status', 1)->get();

            return view('backend.pages.return.purchase.create', $data);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $return = new ReturnPurchase();
        $return->date = date('Y-m-d');
        $return->purchase_id = $request->purchase_id;
        $return->supplier_id = $request->supplier_id;
        $return->estimated_amount = $request->estimated_amount;
        $return->discount = $request->discount_amount;
        $return->discount_amount = $request->discount;
        $return->total_return = $request->payable_amount;

        $return->created_by = auth()->user()->id;

        // DB::transaction(function () use ($request, $return) {
        //     if ($return->save()) {
        //         // dd(count($request->invoiceItem_id));
        //         //save product_id and category_id in purchase_items table where $request->product_id is array of product_id
        //         for ($i = 0; $i < count($request->item_id); $i++) {
        //             $returnItem = new ReturnPurchaseItem();
        //             $returnItem->date = date('Y-m-d');
        //             $returnItem->purchase_id = $request->purchase_id;
        //             $returnItem->rtnPurchase_id = $return->id;
        //             $returnItem->product_id = $request->product_id;
        //             $returnItem->product_variation_id = $request->product_variation_id;
        //             $returnItem->rate = $request->new_rate;
        //             $returnItem->main_qty = $request->main_qty;
        //             $returnItem->sub_qty = $request->sub_qty;
        //             $returnItem->subtotal = $request->sub_total;
        //             $returnItem->save();

        //             $pur_pro_id = PurchaseItem::where('purchase_id', $request->purchase_id)
        //                 ->where('product_id', $request->product_id)
        //                 ->first();
        //             $rtn_pur_pro_id = ReturnPurchaseItem::where('purchase_id', $request->purchase_id)
        //                 ->where('product_id', $request->product_id)
        //                 ->first();
        //             $pur_pro_id->update([
        //                 'rtn_main'=> $pur_pro_id->rtn_main + $request->main_qty,
        //                 'rtn_sub'=> $pur_pro_id->rtn_sub + $request->sub_qty,
        //                 'rtn_total'=> $pur_pro_id->rtn_total + $request->sub_total,
        //                 'stock_qty' => $pur_pro_id->stock_qty - $request->main_qty,
        //             ]);
        //             $pur_pro_ids = PurchaseItem::where('purchase_id', $request->purchase_id)
        //                 ->where('product_id', $request->product_id)
        //                 ->first();
        //             $main_product_qty = $request->rtn_main;
        //             if($pur_pro_ids->main_qty == $pur_pro_ids->rtn_main){
        //                 $pur = PurchaseItem::where('id', $request->item_id)
        //                     ->update([
        //                         'is_return' => 1,
        //                     ]);
        //             }
        //         }
        //         //create purchase log call createPurchaseLog function
        //         $id = $return->id;
        //         $type = 'Purchase Return';
        //         // dd($id);


        //         // Transaction
        //         $transaction = new Transaction();
        //         $transaction->transaction_type = $type;
        //         $transaction->date = date('Y-m-d');
        //         $transaction->return_pur_id = $id;
        //         $transaction->supplier_id = $request->supplier_id;
        //         $transaction->debit = $request->payable_amount;
        //         $transaction->credit = NULL;
        //         $transaction->created_by = auth()->user()->id;
        //         $transaction->save();
        //         $this->createReturnLog($request, $id, $type);
        //     }
        // });

        DB::transaction(function () use ($request, $return) {
            if ($return->save()) {
                for ($i = 0; $i < count($request->item_id); $i++) {
                    $returnItem = new ReturnPurchaseItem();
                    $returnItem->date = date('Y-m-d');
                    $returnItem->purchase_id = $request->purchase_id;
                    $returnItem->rtnPurchase_id = $return->id;
                    $returnItem->product_id = $request->product_id[$i];
                    $returnItem->product_variation_id = $request->product_variation_id[$i];
                    $returnItem->rate = $request->new_rate[$i];
                    $returnItem->main_qty = $request->main_qty[$i];
                    $returnItem->sub_qty = $request->sub_qty[$i];
                    $returnItem->subtotal = $request->sub_total[$i];
                    $returnItem->save();

                    // Update PurchaseItem
                    $purItem = PurchaseItem::where('id', $request->item_id[$i])
                        ->where('product_id', $request->product_id[$i])
                        ->when($request->product_variation_id[$i], function ($q) use ($request, $i) {
                            $q->where('product_variation_id', $request->product_variation_id[$i]);
                        })
                        ->first();

                    if ($purItem) {
                        $purItem->update([
                            'rtn_main'  => $purItem->rtn_main + $request->main_qty[$i],
                            'rtn_sub'   => $purItem->rtn_sub + $request->sub_qty[$i],
                            'rtn_total' => $purItem->rtn_total + $request->sub_total[$i],
                            'stock_qty' => $purItem->stock_qty - $request->main_qty[$i],
                        ]);

                        if ($purItem->main_qty == $purItem->rtn_main) {
                            $purItem->is_return = 1;
                            $purItem->save();
                        }
                    }
                }

                // Transaction log
                $id = $return->id;
                $type = 'Purchase Return';

                $transaction = new Transaction();
                $transaction->transaction_type = $type;
                $transaction->date = date('Y-m-d');
                $transaction->return_pur_id = $id;
                $transaction->supplier_id = $request->supplier_id;
                $transaction->debit = $request->payable_amount;
                $transaction->credit = null;
                $transaction->created_by = auth()->user()->id;
                $transaction->save();

                $this->createReturnLog($request, $id, $type);
            }
        });

        notify()->success('Purchase Return Created Successfully');
        return redirect()->route('rtnPurchase.index');
    }

    function createReturnLog(Request $request, $id, $type)
    {
        $purchase_list = Purchase::where('id', $request->purchase_id)->first();
        $invoice_items = PurchaseItem::where('purchase_id', $request->purchase_id)->get();

        $allReturned = $invoice_items->every(function ($item) {
            return $item->is_return == 1;
        });

        if ($allReturned) {
            Purchase::where('id', $request->purchase_id)
                ->update([
                    'status' => 2,
                ]);
        }

        if ($purchase_list->total_amount == $purchase_list->total_paid) {
            Purchase::where('id', $request->purchase_id)->update([
                'return_amount' => $purchase_list->return_amount + $request->payable_amount,
            ]);

            $bank_transaction = new BankTransaction();
            $bank_transaction->trans_type = 'deposit';
            $bank_transaction->date = date('Y-m-d');
            $bank_transaction->bank_id = $request->bank_id;
            $bank_transaction->return_pur_id = $id;
            $bank_transaction->amount = $request->payable_amount;
            $bank_transaction->created_by = auth()->user()->id;
            $bank_transaction->save();

            // Transaction
            $transaction = new Transaction();
            $transaction->transaction_type = 'Receive money from supplier';
            $transaction->date = date('Y-m-d');
            $transaction->bank_id = $request->bank_id;
            $transaction->return_pur_id = $id;
            $transaction->supplier_id = $request->supplier_id;
            $transaction->debit = NULL;
            $transaction->credit = $request->payable_amount;
            $transaction->created_by = auth()->user()->id;
            $transaction->save();
        } elseif ($purchase_list->total_amount == $purchase_list->total_due) {
            Purchase::where('id', $request->purchase_id)->update([
                'return_amount' => $purchase_list->return_amount,
            ]);
        } else {
            if ($request->payable_amount < $purchase_list->total_due) {
                Purchase::where('id', $request->purchase_id)->update([
                    'return_amount' => $purchase_list->return_amount,
                ]);
            } else {
                $amount = $request->payable_amount - $purchase_list->total_due;
                Purchase::where('id', $request->purchase_id)->update([
                    'return_amount' => $purchase_list->return_amount + $amount,
                ]);

                $bank_transaction = new BankTransaction();
                $bank_transaction->trans_type = 'deposit';
                $bank_transaction->date = date('Y-m-d');
                $bank_transaction->bank_id = $request->bank_id;
                $bank_transaction->return_pur_id = $id;
                $bank_transaction->amount = $purchase_list->return_amount + $amount;
                $bank_transaction->created_by = auth()->user()->id;
                $bank_transaction->save();

                // Transaction
                $transaction = new Transaction();
                $transaction->transaction_type = 'Receive money from supplier';
                $transaction->date = date('Y-m-d');
                $transaction->bank_id = $request->bank_id;
                $transaction->return_pur_id = $id;
                $transaction->supplier_id = $request->supplier_id;
                $transaction->debit = NULL;
                $transaction->credit = $purchase_list->return_amount + $amount;
                $transaction->created_by = auth()->user()->id;
                $transaction->save();
            }
        }

        $return_item_count = ReturnPurchaseItem::where('purchase_id', $request->purchase_id)->count();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $return = ReturnPurchase::find($id);
        // $return = ReturnPurchase::where('id',$return)->first();
        $return->delete();
        notify()->success('Purchase Return deleted successfully');
        return back();
    }
}
