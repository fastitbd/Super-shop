<?php

namespace App\Http\Controllers\Backend;

use App\Models\Product;
use App\Models\Category;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\BankAccount;
use App\Models\Transaction;
use App\Models\PurchaseItem;
use App\Models\ProductVariation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\BankTransaction;
use App\Models\SerialNumber;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ActualPayment;
use Faker\Provider\ar_EG\Payment;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        //get all purchase with supplier and user
        $data['purchases'] = Purchase::with('supplier', 'user')
            ->orderBy('created_at', 'DESC')
            ->paginate(10);
        $data['startDate'] = $request->startDate;
        $data['endDate'] = $request->endDate;
        $data['purchase_no'] = $request->purchase_no;
        $data['supplier_id'] = $request->supplier_id;
        $data['product_id'] = $request->product_id;
        $sdate = Carbon::createFromDate($request->startDate)->toDateString();
        $edate = Carbon::createFromDate($request->endDate)->toDateString();

        // dd($data);
        if ($request->startDate != null && $request->endDate != null && $request->supplier_id != null) {
            $data['purchases'] = Purchase::with('supplier', 'user')->whereBetween('date', [$sdate, $edate])->where('supplier_id', $request->supplier_id)
                ->orderBy('created_at', 'DESC')
                ->paginate(10)
                ->appends([
                    'supplier_id' => $request->supplier_id,
                    'startDate' => $sdate,
                    'endDate' => $edate,
                ]);
        }
        if ($request->startDate != null && $request->endDate != null) {
            $data['purchases'] = Purchase::with('supplier', 'user')->whereBetween('date', [$sdate, $edate])
                ->orderBy('created_at', 'DESC')
                ->paginate(10)
                ->appends([
                    'startDate' => $sdate,
                    'endDate' => $edate,
                ]);
        }
        if ($request->purchase_no != null) {
            $data['purchases'] = Purchase::with('supplier', 'user')->where('purchase_no', $request->purchase_no)
                ->orderBy('created_at', 'DESC')
                ->paginate(10)
                ->appends([
                    'purchase_no' => $request->purchase_no,
                ]);
        }
        if ($request->supplier_id != null) {
            $data['purchases'] = Purchase::with('supplier', 'user')->where('supplier_id', $request->supplier_id)
                ->orderBy('created_at', 'DESC')
                ->paginate(10)
                ->appends([
                    'supplier_id' => $request->supplier_id,
                ]);
        }
        if ($request->product_id != null) {
            $keyword = $request->product_id;
            $data['purchases'] = Purchase::whereHas('purchaseItems.product', function ($query) use ($keyword) {
                $query->where('id', $keyword);
            })->orderBy('created_at', 'DESC')->paginate(20)
                ->appends([
                    'keyword' => $request->keyword,
                ]);
        }
        // return response()->json($purchases);
        return view('backend.pages.purchase.index', $data);
    }

    public function create()
    {
        if (env('APP_SC') == 'yes') {
            $suppliers = Supplier::where('status', 1)->get();
            $categories = Category::orderBy('name', 'asc')->get();
            $products = Product::orderBy('name', 'asc')->get();
            $variation = ProductVariation::get();
            $bank_accounts = BankAccount::where('status', 1)->get();
            $purchase = Purchase::orderBy('id', 'desc')->select('purchase_no')->first();

            if ($purchase == null) {
                $purchase_no = "PUR0000001";
            } else {
                $purchase_no = $purchase->purchase_no;
                $purchase_no++;
            }

            return view('backend.pages.purchase.sc-create', compact('suppliers', 'categories', 'products', 'bank_accounts', 'purchase_no'));
        } else if (env('APP_IMEI') == 'yes') {

            $suppliers = Supplier::where('status', 1)->get();
            $categories = Category::orderBy('name', 'asc')->get();
            $products = Product::orderBy('name', 'asc')->get();
            $bank_accounts = BankAccount::where('status', 1)->get();
            $purchase = Purchase::orderBy('id', 'desc')->select('purchase_no')->first();

            if ($purchase == null) {
                $purchase_no = "PUR0000001";
            } else {
                $purchase_no = $purchase->purchase_no;
                $purchase_no++;
            }
            return view('backend.pages.purchase.imei-create', compact('suppliers', 'categories', 'products', 'bank_accounts', 'purchase_no'));
        } else {
            $suppliers = Supplier::where('status', 1)->get();
            $categories = Category::orderBy('name', 'asc')->get();
            $products = Product::orderBy('name', 'asc')->get();
            $bank_accounts = BankAccount::where('status', 1)->get();
            $purchase = Purchase::orderBy('id', 'desc')->select('purchase_no')->first();
            if ($purchase == null) {
                $purchase_no = "PUR0000001";
            } else {
                $purchase_no = $purchase->purchase_no;
                $purchase_no++;
            }
            return view('backend.pages.purchase.create', compact('suppliers', 'categories', 'products', 'bank_accounts', 'purchase_no'));
        }
    }

    public function store(Request $request)
    {

        if (env('APP_IMEI') == 'yes') {
            // dd($request->all());
            $purchase = new Purchase();
            $purchase->date = $request->date;
            $purchase->purchase_no = $request->purchase_no;
            $purchase->supplier_id = $request->supplier_id;
            $purchase->estimated_amount = $request->estimated_amount;
            $purchase->discount = $request->discount_amount;
            $purchase->total_amount = $request->total_amount;
            $purchase->note = $request->note;
            $purchase->created_by = auth()->user()->id;

            DB::transaction(function () use ($request, $purchase) {
                if ($purchase->save()) {
                    //save product_id and category_id in purchase_items table where $request->product_id is array of product_id
                    foreach ($request->new_product as $key => $product_id) {
                        $purchase_item = new PurchaseItem();
                        $find_unit_id = Product::where('id', $product_id)->first();
                        if ($find_unit_id->has_serial == 1) {
                            $purchase_item->purchase_id = $purchase->id;
                            $purchase_item->product_id = $product_id;
                            $purchase_item->rate = $request->new_rate[$key];

                            $imeis = $request->new_imei;
                            $qty = 0;
                            foreach ($imeis as $product_id => $imei_list) {
                                // Split the serials into an array, trimming whitespace
                                $trimmedArray = array_filter(array_map('trim', explode("\n", $imei_list)));

                                foreach ($trimmedArray as $ime) {
                                    // Check if the serial number already exists for the product
                                    $exists = SerialNumber::where('product_id', $product_id)
                                        ->where('serial', $ime)
                                        ->exists();

                                    if (!$exists) {
                                        $serial = new SerialNumber();
                                        $serial->purchase_id = $purchase->id;
                                        $serial->product_id = $product_id; // Correctly assign the product ID
                                        $serial->serial = $ime; // Save the individual serial
                                        $serial->save();
                                    }
                                }
                            }
                            // dd($qty);
                            $purchase_item->main_qty = $request->new_main_qty[$key];
                            $purchase_item->stock_qty = $request->new_main_qty[$key];
                            $purchase_item->subtotal = $request->new_subtotal_input[$key];
                        } else {
                            $purchase_item->purchase_id = $purchase->id;
                            $purchase_item->product_id = $product_id;
                            $purchase_item->rate = $request->new_rate[$key];
                            if ($find_unit_id->unit->related_unit == null) {
                                $purchase_item->main_qty = $request->new_main_qty[$key];
                                $purchase_item->stock_qty = $request->new_main_qty[$key];
                            } else {
                                $purchase_item->main_qty = $request->new_main_qty[$key];
                                $purchase_item->sub_qty = $request->new_sub_qty[$key];
                                $main = $request->new_main_qty[$key] * $find_unit_id->unit->related_value;
                                $sub = $request->new_sub_qty[$key];
                                $purchase_item->stock_qty = $main + $sub;
                            }
                            $purchase_item->subtotal = $request->new_subtotal_input[$key];
                        }

                        $purchase_item->date = $request->date;
                        $purchase_item->save();
                    }
                    //create purchase log call createPurchaseLog function
                    $id = $purchase->id;
                    $type = 'Purchase';
                    // Transaction
                    $transaction = new Transaction();
                    $transaction->transaction_type = $type;
                    $transaction->date = $request->date;
                    $transaction->purchase_id = $id;
                    $transaction->supplier_id = $request->supplier_id;
                    $transaction->debit = NULL;
                    $transaction->credit = $request->total_amount;
                    $transaction->created_by = auth()->user()->id;
                    $transaction->save();
                    $this->createPurchaseLog($request, $id, $type);
                }
            });

            notify()->success('Purchase Created Successfully');
            return redirect()->route('purchase.index');
        } else {
            $purchase = new Purchase();
            $purchase->date = $request->date;
            $purchase->purchase_no = $request->purchase_no;
            $purchase->supplier_id = $request->supplier_id;
            $purchase->estimated_amount = $request->estimated_amount;
            $purchase->discount = $request->discount_amount;
            $purchase->total_amount = $request->total_amount;
            $purchase->note = $request->note;
            $purchase->created_by = auth()->user()->id;

            DB::transaction(function () use ($request, $purchase) {
                if ($purchase->save()) {
                    //save product_id and category_id in purchase_items table where $request->product_id is array of product_id
                    foreach ($request->new_product as $key => $product_id) {
                        $purchase_item = new PurchaseItem();
                        $purchase_item->date = $request->date;
                        $find_unit_id = Product::where('id', $product_id)->first();
                        $purchase_item->purchase_id = $purchase->id;
                        $purchase_item->product_id = $product_id;
                        $purchase_item->rate = $request->new_rate[$key];
                        // dd($find_unit_id);
                        if ($find_unit_id->unit->related_unit == null) {
                            $purchase_item->main_qty = $request->new_main_qty[$key];
                            $purchase_item->stock_qty = $request->new_main_qty[$key];
                        } else {
                            $purchase_item->main_qty = $request->new_main_qty[$key];
                            $purchase_item->sub_qty = $request->new_sub_qty[$key];
                            $main = $request->new_main_qty[$key] * $find_unit_id->unit->related_value;
                            $sub = $request->new_sub_qty[$key];
                            $purchase_item->stock_qty = $main + $sub;
                        }
                        if ($request->variation) {
                            $purchase_item->product_variation_id = $request->variation[$key] ?? null;
                        }
                        $purchase_item->subtotal = $request->new_subtotal_input[$key];
                        $purchase_item->date = $request->date;
                        $purchase_item->save();
                    }

                    //create purchase log call createPurchaseLog function
                    $id = $purchase->id;
                    $type = 'Purchase';

                    // Transaction
                    $transaction = new Transaction();
                    $transaction->transaction_type = $type;
                    $transaction->date = $request->date;
                    $transaction->purchase_id = $id;
                    $transaction->supplier_id = $request->supplier_id;
                    $transaction->debit = NULL;
                    $transaction->credit = $request->total_amount;
                    $transaction->created_by = auth()->user()->id;
                    $transaction->save();
                    $this->createPurchaseInv($request, $id, $type);
                }
            });

            notify()->success('Purchase Created Successfully');
            return redirect()->route('purchase.index');
        }
    }

    public function purchaseEdit($id)
    {
        $supplier = Supplier::where('status', 1)->get();
        $bank_accounts = BankAccount::where('status', 1)->get();
        $purchase = Purchase::where('id', $id)->with('purchaseItems')->first();
        return view('backend.pages.purchase.edit', compact('purchase', 'supplier', 'bank_accounts'));
    }
    public function purchaseUpdate(Request $request, $id)
    {
        // dd($request->all());
        $purchase = Purchase::where('id', $request->id)->first();
        $purchase->date = $request->date;
        $purchase->supplier_id = $request->supplier_id;
        $purchase->estimated_amount = $request->estimated_amount;
        $purchase->discount = $request->discount_amount;
        $purchase->total_amount = $request->total_amount;
        $purchase->note = $request->note;

        if ($request->due_amount < 0) {
            $purchase->return_amount = $request->due_amount;
        } else {
            $purchase->total_due = $request->due_amount;
        }
        if ($request->due_amount > 0) {
            $purchase->status = 0;
        } else {
            $purchase->status = 1;
        }

        DB::transaction(function () use ($request, $purchase) {
            if ($purchase->save()) {
                // Delete old purchase items
                foreach ($request->itemID as $key => $item) {
                    PurchaseItem::where('id', $item)->delete();
                }

                // Save new purchase items and handle IMEI numbers
                foreach ($request->product_id as $key => $product_id) {
                    $variation_id = $request->variation_id[$key] ?? null;
                    $purchase_item = new PurchaseItem();
                    $find_unit_id = Product::where('id', $product_id)->first();

                    $purchase_item->purchase_id = $purchase->id;
                    $purchase_item->product_id = $product_id;
                    $purchase_item->rate = $request->new_rate[$key];
                    $purchase_item->main_qty = $request->new_main_qty[$key];
                    if ($find_unit_id->unit->related_unit != null) {
                        $purchase_item->sub_qty = $request->new_sub_qty[$key];
                    }
                    if ($variation_id) {
                        $purchase_item->product_variation_id = $variation_id;
                    }
                    $purchase_item->subtotal = $request->new_subtotal_input[$key];
                    $purchase_item->stock_qty = $request->new_main_qty[$key];

                    $purchase_item->save();
                }

                // Create the transaction log
                $id = $purchase->id;
                $type = 'Purchase';

                $transaction = new Transaction();
                $transaction->transaction_type = $type;
                $transaction->date = $request->date;
                $transaction->purchase_id = $id;
                $transaction->supplier_id = $request->supplier_id;
                $transaction->debit = null;
                $transaction->credit = $request->total_amount;
                $transaction->created_by = auth()->user()->id;
                $transaction->save();

                // Call the purchase log creation method
                $this->createPurchaseUpd($request, $id, $type);
            }
        });

        // DB::transaction(function () use ($request, $purchase) {
        //     if ($purchase->save()) {
        //         foreach ($request->itemID as $key => $item) {
        //             // dd($item);
        //             PurchaseItem::where('id', $item)->delete();
        //         }
        //         //save product_id and category_id in purchase_items table where $request->product_id is array of product_id
        //         foreach ($request->new_product as $key => $product_id) {
        //             $purchase_item = new purchaseItem();
        //             $find_unit_id = Product::where('id', $product_id)->first();
        //             $purchase_item->purchase_id = $purchase->id;
        //             $purchase_item->product_id = $product_id;
        //             $purchase_item->rate = $request->new_rate[$key];
        //             if ($find_unit_id->unit->related_unit == null) {
        //                 $purchase_item->main_qty = $request->new_main_qty[$key];
        //             } else {
        //                 $purchase_item->main_qty = $request->new_main_qty[$key];
        //                 $purchase_item->sub_qty = $request->new_sub_qty[$key];
        //             }
        //             $purchase_item->subtotal = $request->new_subtotal_input[$key];
        //             $purchase_item->save();
        //         }

        //         //create purchase log call createPurchaseLog function
        //         $id = $purchase->id;
        //         $type = 'Purchase';

        //         // Transaction
        //         $transaction = new Transaction();
        //         $transaction->transaction_type = $type;
        //         $transaction->date = $request->date;
        //         $transaction->purchase_id = $id;
        //         $transaction->supplier_id = $request->supplier_id;
        //         $transaction->debit = NULL;
        //         $transaction->credit = $request->total_amount;
        //         $transaction->created_by = auth()->user()->id;
        //         $transaction->save();
        //         $this->createPurchaseUpd($request, $id, $type);
        //     }
        // });

        notify()->success('Successfully edit purchase.');
        return redirect()->route('purchase.index');
    }

    public function destroy(string $id)
    {
        $purchase = Purchase::find($id);
        $purchaseItem = PurchaseItem::where('purchase_id', $id)->get();
        foreach ($purchaseItem as $item) {
            $item->delete();
        }
        $transactions = Transaction::where('purchase_id', $purchase->id)->get();
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
        $purchase->delete();
        notify()->success('Purchase deleted successfully');
        return back();
    }

    public function purchasePay($id)
    {
        //get purchase with supplier and user by id
        $purchase = Purchase::with('supplier', 'user', 'purchaseItems')
            ->where('id', $id)->first();

        if ($purchase->total_due <= 0) {
            return redirect()->back();
        }
        // return response()->json($purchase);
        //get all payment methods
        $bank_accounts = BankAccount::where('status', 1)->get();
        // return response()->json($payment_methods);

        return view('backend.pages.purchase.pay', compact('purchase', 'bank_accounts'));
    }

    public function storePurchaseLog(Request $request)
    {
        $id = $request->purchase_id;
        $type = $request->type;
        $this->createPurchaseDue($request, $id, $type);

        notify()->success('Due Paid successfully');
        return redirect()->route('purchase.index');
    }

    public function printPurchase($id)
    {
        //get invoice with supplier and user by id
        // $purchase = Purchase::with('supplier', 'user', 'purchaseItems')
        //     ->where('id', $id)->first();
        $purchase = Purchase::with(['supplier', 'user', 'purchaseItems' => function ($query) {
            $query->where('is_return', '=', 0);
        }])->where('id', $id)->first();


        return view('backend.pages.purchase.print', compact('purchase'));
    }
    public function imeiPrintPurchase($id)
    {
        //get invoice with supplier and user by id
        $purchase = Purchase::with('supplier', 'user', 'purchaseItems')
            ->where('id', $id)->first();

        return view('backend.pages.purchase.imei-print', compact('purchase'));
    }

    function createPurchaseLog(Request $request, $id, $type)
    {
        //added total_paid and total_due in purchase table
        $purchase = Purchase::find($id);
        if ($request->type == 'Due Paid') {
            $purchase->total_paid = $purchase->total_paid + $request->paid_amount;
            $purchase->total_due = $purchase->total_due - $request->paid_amount;
        } else {
            $purchase->total_paid = $request->paid_amount;
            $purchase->total_due = $request->due_amount;
        }
        //change purchase status to 1 if paid amount is equal to total amount
        if ($request->due_amount == 0) {
            $purchase->status = 1;
        }
        $purchase->save();

        DB::transaction(function () use ($request, $purchase, $id) {
            if ($purchase->save()) {
                //create bank transaction
                if ($request->paid_amount > 0) {
                    //create bank transaction
                    $bank_transaction = new BankTransaction();
                    $bank_transaction->trans_type = 'withdraw';
                    if ($request->type == 'Due Paid') {
                        $bank_transaction->date = Carbon::now()->format('Y-m-d');
                    } else {
                        $bank_transaction->date = $request->date;
                    }
                    $bank_transaction->bank_id = $request->bank_id;
                    $bank_transaction->purchase_id = $id;
                    $bank_transaction->amount = $request->paid_amount;
                    $bank_transaction->created_by = auth()->user()->id;
                    $bank_transaction->save();

                    // Transaction
                    $transaction = new Transaction();
                    $transaction->transaction_type = 'Paid to Supplier';
                    if ($request->type == 'Due Paid') {
                        $transaction->date = Carbon::now()->format('Y-m-d');
                    } else {
                        $transaction->date = $request->date;
                    }
                    $transaction->bank_id = $request->bank_id;
                    $transaction->purchase_id = $id;
                    $transaction->supplier_id = $request->supplier_id;
                    $transaction->debit = $request->paid_amount;
                    $transaction->credit = NULL;
                    $transaction->created_by = auth()->user()->id;
                    $transaction->save();
                }
            }
        });
    }

    function createPurchaseInv(Request $request, $id, $type)
    {
        //added total_paid and total_due in purchase table
        $purchase = Purchase::find($id);
        if ($request->type == 'Due Paid') {
            $purchase->total_paid = $purchase->total_paid + $request->paid_amount;
            $purchase->total_due = $purchase->total_due - $request->paid_amount;
        } else {
            $purchase->total_paid = $request->paid_amount;
            $purchase->total_due = $request->due_amount;
        }
        //change purchase status to 1 if paid amount is equal to total amount
        if ($request->due_amount == 0) {
            $purchase->status = 1;
        }
        $purchase->save();

        DB::transaction(function () use ($request, $purchase, $id) {
            if ($purchase->save()) {
                //create bank transaction
                if ($request->paid_amount > 0) {
                    //create bank transaction
                    $bank_transaction = new BankTransaction();
                    $bank_transaction->trans_type = 'withdraw';
                    $bank_transaction->pay_type = 'purchase';
                    if ($request->type == 'Due Paid') {
                        $bank_transaction->date = Carbon::now()->format('Y-m-d');
                    } else {
                        $bank_transaction->date = $request->date;
                    }
                    $bank_transaction->bank_id = $request->bank_id;
                    $bank_transaction->purchase_id = $id;
                    $bank_transaction->amount = $request->paid_amount;
                    $bank_transaction->created_by = auth()->user()->id;
                    $bank_transaction->save();

                    // Transaction
                    $transaction = new Transaction();
                    $transaction->transaction_type = 'Paid to Supplier';
                    if ($request->type == 'Due Paid') {
                        $transaction->date = Carbon::now()->format('Y-m-d');
                    } else {
                        $transaction->date = $request->date;
                    }
                    $transaction->bank_id = $request->bank_id;
                    $transaction->purchase_id = $id;
                    $transaction->supplier_id = $request->supplier_id;
                    $transaction->debit = $request->paid_amount;
                    $transaction->credit = NULL;
                    $transaction->created_by = auth()->user()->id;
                    $transaction->save();
                }
            }
        });
    }
    function createPurchaseDue(Request $request, $id, $type)
    {
        //added total_paid and total_due in purchase table
        $purchase = Purchase::find($id);
        if ($request->type == 'Due Paid') {
            $purchase->total_paid = $purchase->total_paid + $request->paid_amount;
            $purchase->total_due = $purchase->total_due - $request->paid_amount;
        } else {
            $purchase->total_paid = $request->paid_amount;
            $purchase->total_due = $request->due_amount;
        }
        //change purchase status to 1 if paid amount is equal to total amount
        if ($request->due_amount == 0) {
            $purchase->status = 1;
        }
        $purchase->save();

        DB::transaction(function () use ($request, $purchase, $id) {
            if ($purchase->save()) {
                //create bank transaction
                if ($request->paid_amount > 0) {
                    //create bank transaction
                    $bank_transaction = new BankTransaction();
                    $bank_transaction->trans_type = 'withdraw';
                    $bank_transaction->pay_type = 'purdue';
                    if ($request->type == 'Due Paid') {
                        $bank_transaction->date = Carbon::now()->format('Y-m-d');
                    } else {
                        $bank_transaction->date = $request->date;
                    }
                    $bank_transaction->bank_id = $request->bank_id;
                    $bank_transaction->purchase_id = $id;
                    $bank_transaction->amount = $request->paid_amount;
                    $bank_transaction->created_by = auth()->user()->id;
                    $bank_transaction->save();

                    // Transaction
                    $transaction = new Transaction();
                    $transaction->transaction_type = 'Paid to Supplier';
                    if ($request->type == 'Due Paid') {
                        $transaction->date = Carbon::now()->format('Y-m-d');
                    } else {
                        $transaction->date = $request->date;
                    }
                    $transaction->bank_id = $request->bank_id;
                    $transaction->purchase_id = $id;
                    $transaction->supplier_id = $request->supplier_id;
                    $transaction->debit = $request->paid_amount;
                    $transaction->credit = NULL;
                    $transaction->created_by = auth()->user()->id;
                    $transaction->save();
                }
            }
        });
    }
    function createPurchaseUpd(Request $request, $id, $type)
    {
        //added total_paid and total_due in purchase table
        $purchase = Purchase::find($id);
        if ($request->type == 'Due Paid') {
            $purchase->total_paid = $purchase->total_paid + $request->paid_amount;
            $purchase->total_due = $purchase->total_due - $request->paid_amount;
        } else {
            $purchase->total_paid = $request->paid_amount;
            $purchase->total_due = $request->due_amount;
        }
        //change purchase status to 1 if paid amount is equal to total amount
        if ($request->due_amount == 0) {
            $purchase->status = 1;
        }
        $purchase->save();

        DB::transaction(function () use ($request, $purchase, $id) {
            if ($purchase->save()) {
                //create bank transaction
                if ($request->paid_amount > 0) {
                    //create bank transaction
                    $bank_transaction = new BankTransaction();
                    $bank_transaction->trans_type = 'withdraw';
                    $bank_transaction->pay_type = 'purdue';
                    if ($request->type == 'Due Paid') {
                        $bank_transaction->date = Carbon::now()->format('Y-m-d');
                    } else {
                        $bank_transaction->date = $request->date;
                    }
                    $bank_transaction->bank_id = $request->bank_id;
                    $bank_transaction->purchase_id = $id;
                    $bank_transaction->amount = $request->paid_amount;
                    $bank_transaction->created_by = auth()->user()->id;
                    $bank_transaction->save();

                    // Transaction
                    $transaction = new Transaction();
                    $transaction->transaction_type = 'Paid to Supplier';
                    if ($request->type == 'Due Paid') {
                        $transaction->date = Carbon::now()->format('Y-m-d');
                    } else {
                        $transaction->date = $request->date;
                    }
                    $transaction->bank_id = $request->bank_id;
                    $transaction->purchase_id = $id;
                    $transaction->supplier_id = $request->supplier_id;
                    $transaction->debit = $request->paid_amount;
                    $transaction->credit = NULL;
                    $transaction->created_by = auth()->user()->id;
                    $transaction->save();
                }
            }
        });
    }
}
