<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\BankTransaction;
use App\Models\OwnerShip;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class BankTransactionController extends Controller
{
    public function deposit()
    {
        //all active bank accounts
        $bank_accounts = BankAccount::where('status', 1)->get();
        $owners = OwnerShip::where('status',1)->get();
        return view('backend.pages.account.deposit', compact('bank_accounts','owners'));
    }

    //deposit store
    public function depositStore(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'bank_id' => 'required',
            'owner_id' => 'required',
            'deposit_amount' => 'required|numeric',
        ]);
        // return response()->json($request->all());

        //store to database bank_transactions table
        $bank_transaction = new BankTransaction();
        $bank_transaction->trans_type = 'deposit';
        $bank_transaction->pay_type = 'ownpay';
        $bank_transaction->owner_id = $request->owner_id;
        $bank_transaction->date = $request->date;
        $bank_transaction->bank_id = $request->bank_id;
        $bank_transaction->amount = $request->deposit_amount;
        $bank_transaction->note = $request->note;
        $bank_transaction->status = 1;
        $bank_transaction->created_by = auth()->user()->id;
        $bank_transaction->save();


        DB::transaction(function() use($request) {
                $transaction = new Transaction();
                $transaction->transaction_type = 'Owner Deposit';
                $transaction->date = Carbon::now()->format('Y-m-d');
                $transaction->owner_id = $request->owner_id;
                $transaction->bank_id = $request->bank_id;
                $transaction->debit = $request->deposit_amount;
                $transaction->credit = NULL;
                $transaction->created_by = auth()->user()->id;
                $transaction->save();
            
        });

        notify()->success('Deposit successfully created.');
        return redirect('transaction-history');
    }

    //withdraw
    public function withdraw()
    {
        //all active bank accounts
        $bank_accounts = BankAccount::where('status', 1)->get();
        $owners = OwnerShip::where('status',1)->get();
        return view('backend.pages.account.withdraw', compact('bank_accounts','owners'));
    }

    //withdraw store
    public function withdrawStore(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'bank_id' => 'required',
            'withdraw_amount' => 'required|numeric',
        ]);
        // return response()->json($request->all());

        //store to database bank_transactions table
        if ($request->withdraw_amount <= $request->from_amount ) {
            $bank_transaction = new BankTransaction();
            $bank_transaction->trans_type = 'withdraw';
            $bank_transaction->pay_type = 'ownwith';
            $bank_transaction->date = $request->date;
            $bank_transaction->bank_id = $request->bank_id;
            $bank_transaction->owner_id = $request->owner_id;
            $bank_transaction->amount = $request->withdraw_amount;
            $bank_transaction->note = $request->note;
            $bank_transaction->status = 1;
            $bank_transaction->created_by = auth()->user()->id;
            $bank_transaction->save();

            DB::transaction(function() use($request) {
                $transaction = new Transaction();
                $transaction->transaction_type = 'Owner Withdraw';
                $transaction->date = Carbon::now()->format('Y-m-d');
                $transaction->owner_id = $request->owner_id;
                $transaction->bank_id = $request->bank_id;
                $transaction->debit = NULL;
                $transaction->credit = $request->withdraw_amount;
                $transaction->created_by = auth()->user()->id;
                $transaction->save();
            
            });

            notify()->success('Withdraw successfully created.');
            return redirect('transaction-history');
        } else {
            notify()->error('Sorry ! You approve maximum transfer amount.');
            return back();
        }
    }

    //bank transfer list
    public function bankTransferIndex()
    {
        //with bank account
        $bank_transfers = BankTransaction::with('from_bank_account', 'to_bank_account', 'user')
                            ->where('trans_type', 'transfer')
                            ->orderBy('id', 'DESC')
                            ->paginate(10);
        $all_accounts = BankAccount::where('status', 1)->get();
        // return response()->json($bank_transfers);

        return view('backend.pages.account.transfer.index', compact('bank_transfers', 'all_accounts'));
    }

    //bank transfer store
    public function bankTransferStore(Request $request)
    {
        $request->validate([
            'from_bank_id' => 'required',
            'to_bank_id' => 'required',
            'date' => 'required',
            'transfer_amount' => 'required|numeric',
        ]);

        // return response()->json($request->all());

        //store to database bank_transactions table
        if ($request->transfer_amount <= $request->from_amount ) {
            $bank_transaction = new BankTransaction();
            $bank_transaction->trans_type = 'transfer';
            $bank_transaction->pay_type = 'transfer';
            $bank_transaction->date = $request->date;
            $bank_transaction->from_bank_id = $request->from_bank_id;
            $bank_transaction->to_bank_id = $request->to_bank_id;
            $bank_transaction->amount = $request->transfer_amount;
            $bank_transaction->status = 1;
            $bank_transaction->created_by = auth()->user()->id;
            $bank_transaction->save();
            notify()->success('Bank Transfer Created Successfully');
        } else {
            notify()->error('Sorry ! You approve maximum transfer amount.');
        }
        return back();
    }

    public function transactionHistory(Request $request)
    {
        $data['bank_transactions'] = BankTransaction::with('bank_account', 'user')
                                ->where('trans_type', '!=', 'transfer')
                                ->where('bank_id', '!=', NULL)
                                ->orderBy('created_at', 'DESC')
                                ->paginate(20);
                if ($request->all() != NULL) {
                    $data['sdate'] = Carbon::createFromDate($request->start_date)->toDateString();
                    $data['edate'] = Carbon::createFromDate($request->end_date)->toDateString();
                    $sdate = $data['sdate'];
                    $edate = $data['edate'];
        
                    $invoiceItem = BankTransaction::whereBetween('date', [$sdate, $edate]);
                    $data['bank_transactions'] = $invoiceItem->get();
                }
            return view('backend.pages.account.transaction',$data);
        
    }
}
