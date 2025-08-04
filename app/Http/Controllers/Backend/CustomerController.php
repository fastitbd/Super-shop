<?php

namespace App\Http\Controllers\Backend;

use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Invoice;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['customers'] = Customer::orderBy('id','desc')->paginate(20);
        $data['customer_id'] = $request->customer_id;
        $data['phone_no'] = $request->phone_no;
        // dd($data);
        // $data['total_amount'] = Customer::where('id',$request->customer_id)->get();
        if($request->customer_id != null){
            $data['customers'] = Customer::where('id',$request->customer_id)->orderBy('id','asc')->paginate(20);
        }
        if($request->phone_no != null){
            $data['customers'] = Customer::where('phone',$request->phone_no)->orderBy('id','asc')->paginate(20);
        }

        return view('backend.pages.customer.index',$data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required',
            'phone' => 'required | unique:customers',
        ]);
        $customer = new Customer();
        $customer->date = date('Y-m-d');
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->open_receivable = $request->open_receivable;
        $customer->open_payable = $request->open_payable;

        DB::transaction(function() use($request, $customer) {
            if ($customer->save()) {
                if ($request->open_receivable != NULL) {
                    $transaction = new Transaction();
                    $transaction->transaction_type = 'Opening Receivable';
                    $transaction->date = Carbon::now()->format('Y-m-d');
                    $transaction->customer_id = $customer->id;
                    $transaction->debit = $request->open_receivable;
                    $transaction->credit = NULL;
                    $transaction->created_by = auth()->user()->id;
                    $transaction->save();
                }
                if ($request->open_payable != NULL) {
                    $transaction = new Transaction();
                    $transaction->transaction_type = 'Opening Payable';
                    $transaction->date = Carbon::now()->format('Y-m-d');
                    $transaction->customer_id = $customer->id;
                    $transaction->debit = NULL;
                    $transaction->credit = $request->open_payable;
                    $transaction->created_by = auth()->user()->id;
                    $transaction->save();
                }
            }
        });
        notify()->success('Customer created successfully');
        return back();
    }

    public function update(Request $request, string $id)
    {
        $customer = Customer::find($id);
        $customer->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'address'=>$request->address,
        ]);
        notify()->success('Customer updated successfully');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::find($id);
        $transactions = Transaction::where('customer_id', $id)->get();
        foreach ($transactions as $transaction) {
            $transaction->delete();
        }
        $customer->delete();
        notify()->success('Customer deleted successfully');
        return back();
    }
}
