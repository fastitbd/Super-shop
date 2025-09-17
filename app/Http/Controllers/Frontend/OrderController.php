<?php

namespace App\Http\Controllers\Frontend;

use Cart;
use Carbon\Carbon;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Customer;
use App\Models\InvoiceItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\ProductDesign;
use App\Models\BankTransaction;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {
        //  
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {

    //    dd($request->all());

        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'district' => 'required',
            'thana' => 'required',
            'unions' => 'required',
         
            // 'city_id'=>'required',
            // 'zone_id'=>'required',
            // 'area_id'=>'required',
        ], [
            'name.required' => 'Enter your name',
            'phone.required' => 'Enter your phone number',
            'address.required' => 'Enter your full address',
            'district.required' => 'Enter your district',
            'thana.required' => 'Enter your thana',
            'unions.required' => 'Enter your unions',
            // 'city_id.required' => 'Select your city',
            // 'zone_id.required' => 'Select your zone',
            // 'area_id.required' => 'Select your area',
        ]);

        // dd($request->all());
        $customer = Customer::where('phone', $request->phone)->first();

        if (!$customer) {
            $customer = new Customer();
            $customer->name = $request->name;
            $customer->phone = $request->phone;
            $customer->email = $request->email;
            $customer->district = $request->district;
            $customer->thana = $request->thana;
            $customer->unions = $request->unions;
            $customer->address = $request->address;
            // $customer->city_id = $request->city_id;
            // $customer->zone_id = $request->zone_id;
            // $customer->area_id = $request->area_id;
            $customer->open_receivable = $request->open_receivable;
            $customer->open_payable = $request->open_payable;

            DB::transaction(function () use ($request, $customer) {
                if ($customer->save()) {
                    if ($request->open_receivable != NULL) {
                        $transaction = new Transaction();
                        $transaction->transaction_type = 'Opening Receivable';
                        $transaction->date = Carbon::now()->format('Y-m-d');
                        $transaction->customer_id = $customer->id;
                        $transaction->debit = $request->open_receivable;
                        $transaction->credit = NULL;
                        $transaction->created_by = 1;
                        $transaction->save();
                    }
                    if ($request->open_payable != NULL) {
                        $transaction = new Transaction();
                        $transaction->transaction_type = 'Opening Payable';
                        $transaction->date = Carbon::now()->format('Y-m-d');
                        $transaction->customer_id = $customer->id;
                        $transaction->debit = NULL;
                        $transaction->credit = $request->open_payable;
                        $transaction->created_by = 1;
                        $transaction->save();
                    }
                }
            });
        }

        $last_invoice_id = Invoice::orderBy('id', 'DESC')->select('invoice_no')->first();
        if ($last_invoice_id == null) {
            $invoice_no = "INV-8600";
        } else {
            $invoice_no = $last_invoice_id->invoice_no;
            $invoice_no++;
        }

        $invoice = new Invoice();
        $invoice->date = date('Y-m-d');
        $invoice->invoice_no = $invoice_no;
        $invoice->customer_id = $customer->id;
        $invoice->estimated_amount =$request->payable_amount;
        $invoice->delivery_charge = $request->shipping;
        $invoice->sale_type = $request->sale_type;
        $invoice->total_amount = $request->payable_amount;
        $invoice->order_status ='New Order';
        $invoice->is_web = 1;
        $invoice->created_by = 1;
        DB::transaction(function () use ($request, $invoice, $customer) {
            if ($invoice->save()) {
                // 👉 Case 2: If product has NO design
                if ($request->has('product_id') && is_array($request->product_id)) {
                    foreach ($request->product_id as $key => $product_id) {
                        $invoice_item = new InvoiceItem();
                      
                        $invoice_item->rate = $request->rate[$key];
                        $invoice_item->main_qty = $request->main_qty[$key];
                        $invoice_item->invoice_id = $invoice->id;
                        $invoice_item->product_id = $product_id;

                        $invoice_item->date = now();
                        $invoice_item->save();
                    }
                }
            }


                // create purchase log call createPurchaseLog function
                $id = $invoice->id;
                $type = 'Invoice';

                // Transaction
                $transaction = new Transaction();
                $transaction->transaction_type = $type;
                $transaction->date = $request->date;
                $transaction->invoice_id = $id;
                $transaction->customer_id =  $customer->id;
                $transaction->debit = (float) $request->payable_amount;
                $transaction->credit = NULL;
                $transaction->created_by = 1;
                $transaction->save();
                $this->createInvoiceInv($request, $id, $customer);

        });
        notify()->success('Your order is confirmed');
        Cart::instance('cart')->destroy();
        return redirect()->route('cart.index')->with('order_confirmed', true);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }



    function createInvoiceInv($request, $id, $customer)
    {
        // dd($request->all());
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

        DB::transaction(function () use ($request, $invoice, $id, $customer) {
            if ($invoice->save()) {
                if ($request->paid_amount > 0) {
                    //create bank transaction
                    $bank_transaction = new BankTransaction();
                    $bank_transaction->trans_type = 'deposit';
                    $bank_transaction->pay_type = 'invpay';
                    $bank_transaction->sale_type = 'online';
                    $bank_transaction->date = Carbon::now()->format('Y-m-d');
                    if ($request->type == 'Due Paid') {
                    } else {
                        $bank_transaction->date = $request->date;
                    }
                    $bank_transaction->bank_id = null;
                    $bank_transaction->invoice_id = $id;
                    $bank_transaction->amount = $request->paid_amount;
                    $bank_transaction->created_by = 1;
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
                    $transaction->customer_id = $customer->id;
                    $transaction->debit = NULL;
                    $transaction->credit = $request->paid_amount;
                    $transaction->created_by = 1;
                    $transaction->save();
                }
            }
        });
    }
}
