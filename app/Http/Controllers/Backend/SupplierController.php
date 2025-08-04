<?php

namespace App\Http\Controllers\Backend;

use App\Models\Supplier;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $data['suppliers'] = Supplier::orderBy('id','asc')->paginate(20);
        $data['supplier_id'] = $request->supplier_id;
        $data['phone_no'] = $request->phone_no;
        // dd($data);
        if($request->supplier_id != null){
            $data['suppliers'] = Supplier::where('id',$request->supplier_id)->orderBy('id','asc')->paginate(20);
        }
        if($request->phone_no != null){
            $data['suppliers'] = Supplier::where('phone',$request->phone_no)->orderBy('id','asc')->paginate(20);
        }

        return view('backend.pages.supplier.index',$data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required',
            'phone' => 'required | unique:suppliers',
        ]);
        $supplier = new Supplier();
        $supplier->name = $request->name;
        $supplier->email = $request->email;
        $supplier->phone = $request->phone;
        $supplier->address = $request->address;
        $supplier->open_receivable = $request->open_receivable;
        $supplier->open_payable = $request->open_payable;

        DB::transaction(function() use($request, $supplier) {
            if ($supplier->save()) {
                if ($request->open_receivable != NULL) {
                    $transaction = new Transaction();
                    $transaction->transaction_type = 'Opening Receivable';
                    $transaction->date = Carbon::now()->format('Y-m-d');
                    $transaction->supplier_id = $supplier->id;
                    $transaction->debit = $request->open_receivable;
                    $transaction->credit = NULL;
                    $transaction->created_by = auth()->user()->id;
                    $transaction->save();
                }
                if ($request->open_payable != NULL) {
                    $transaction = new Transaction();
                    $transaction->transaction_type = 'Opening Payable';
                    $transaction->date = Carbon::now()->format('Y-m-d');
                    $transaction->supplier_id = $supplier->id;
                    $transaction->debit = NULL;
                    $transaction->credit = $request->open_payable;
                    $transaction->created_by = auth()->user()->id;
                    $transaction->save();
                }
            }
        });

        notify()->success('Supplier created successfully');
        return back();
    }

    public function update(Request $request, string $id)
    {
        $supplier = Supplier::find($id);
        $supplier->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'address'=>$request->address,
        ]);

        notify()->success('Supplier updated successfully');
        return back();
    }

    public function destroy(string $id)
    {
        $supplier = Supplier::find($id);
        $transactions = Transaction::where('supplier_id', $id)->get();
        foreach ($transactions as $transaction) {
            $transaction->delete();
        }
        $supplier->delete();

        notify()->success('Supplier deleted successfully');
        return back();
    }
}
