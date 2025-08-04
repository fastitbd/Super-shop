<?php

namespace App\Http\Controllers\Backend;

use App\Models\Expense;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use App\Models\BankTransaction;
use App\Models\ExpenseCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $data['startDate'] = $request->startDate;
        $data['endDate'] = $request->endDate;
        $data['category_id'] = $request->category_id;
        $sdate = Carbon::createFromDate($request->startDate)->toDateString();
        $edate = Carbon::createFromDate($request->endDate)->toDateString();
        $data['expenses'] = Expense::with('expense_category', )
                    ->orderBy('created_at', 'DESC')
                    ->paginate(10);  
        $data['total_amt'] = Expense::with('expense_category')->sum('amount');

        if ($request->startDate != null && $request->endDate != null && $request->category_id != null) {
            $data['expenses'] = Expense::with('expense_category')->whereBetween('date', [$sdate, $edate])->where('category_id', $request->category_id)
                ->orderBy('created_at', 'DESC')
                ->paginate(20)->appends([
                    'category_id' => $request->category_id,
                    'startDate' => $sdate,
                    'endDate' => $edate,
                ]);
            $data['total_amt'] = Expense::with('expense_category')->whereBetween('date', [$sdate, $edate])->where('category_id', $request->category_id)
                ->orderBy('created_at', 'DESC')->sum('amount');
            
                
        }
        if ($request->startDate != null && $request->endDate != null) {
            $data['expenses'] = Expense::with('expense_category')->whereBetween('date', [$sdate, $edate])
                ->orderBy('created_at', 'DESC')
                ->paginate(20)->appends([
                    'startDate' => $sdate,
                    'endDate' => $edate,
                ]);
            $data['total_amt'] = Expense::with('expense_category')->whereBetween('date', [$sdate, $edate])
                ->orderBy('created_at', 'DESC')
                ->sum('amount');
        }
        if ($request->category_id != null) {
            $data['expenses'] = Expense::with('expense_category')->where('category_id', $request->category_id)
                ->orderBy('created_at', 'DESC')
                ->paginate(20)->appends([
                    'category_id' => $request->category_id,
                ]);
            $data['total_amt'] = Expense::with('expense_category')->where('category_id', $request->category_id)
                ->orderBy('created_at', 'DESC')
                ->sum('amount');
        }

        return view('backend.pages.expense.index',$data);
    }

    public function create()
    {
        $categories = ExpenseCategory::orderBy('name', 'asc')->get();
        $bank_accounts = BankAccount::where('status', 1)->get();

        return view('backend.pages.expense.create', compact('categories', 'bank_accounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'date' => 'required',
            'category_id' => 'required',
            'bank_id' => 'required',
            'amount' => 'required|numeric',
        ]);

        $expense = new Expense();
        $expense->name = $request->name;
        $expense->date = $request->date;
        $expense->category_id = $request->category_id;
        $expense->bank_id = $request->bank_id;
        $expense->amount = $request->amount;
        $expense->note = $request->note;
        $expense->created_by = auth()->user()->id;

        DB::transaction(function() use($request, $expense) {
            if ($expense->save()) {
                //create bank transaction
                $bank_transaction = new BankTransaction();
                $bank_transaction->trans_type = 'withdraw';
                $bank_transaction->pay_type = 'expense';
                $bank_transaction->date = $request->date;
                $bank_transaction->bank_id = $request->bank_id;
                $bank_transaction->expense_id = $expense->id;
                $bank_transaction->amount = $request->amount;
                $bank_transaction->created_by = auth()->user()->id;
                $bank_transaction->save();
            }
        });
        notify()->success('Expense entry successfully');
        return redirect()->route('expense.index');
    }

    public function edit(string $id)
    {
        $data['categories'] = ExpenseCategory::orderBy('name', 'asc')->get();
        $data['bank_accounts'] = BankAccount::where('status', 1)->get();
     	$data['data'] = Expense::find($id);
        return view('backend.pages.expense.edit', $data);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'date' => 'required',
            'category_id' => 'required',
            'bank_id' => 'required',
            'amount' => 'required|numeric',
        ]);

        $expense = Expense::find($id);
        $expense->name = $request->name;
        $expense->date = $request->date;
        $expense->category_id = $request->category_id;
        $expense->bank_id = $request->bank_id;
        $expense->amount = $request->amount;
        $expense->note = $request->note;
        $expense->created_by = auth()->user()->id;

        DB::transaction(function() use($request, $expense) {
            if ($expense->save()) {
                $transaction = BankTransaction::where('expense_id', $expense->id)->first();
                $transaction->delete();
                //create bank transaction
                $bank_transaction = new BankTransaction();
                $bank_transaction->trans_type = 'withdraw';
                $bank_transaction->date = $request->date;
                $bank_transaction->bank_id = $request->bank_id;
                $bank_transaction->expense_id = $expense->id;
                $bank_transaction->amount = $request->amount;
                $bank_transaction->created_by = auth()->user()->id;
                $bank_transaction->save();
            }
        });
        notify()->success('Customer updated successfully');
        return redirect()->route('expense.index');
    }

    public function destroy(string $id)
    {
        $expense = Expense::find($id);
        $transaction = BankTransaction::where('expense_id', $expense->id)->first();
        $transaction->delete();
        $expense->delete();
        notify()->success('Expense deleted successfully');
        return back();
    }

    public function categoryIndex()
    {
        $categories = ExpenseCategory::orderBy('id', 'desc')->paginate(20);
        return view('backend.pages.expense.category-index', compact('categories'));
    }

    public function categoryStore(Request $request)
    {
        $category = new ExpenseCategory();
        $category->name = $request->name;
        $category->save();
        notify()->success('Expense Category created successfully');
        return back();
    }

    public function categoryUpdate(Request $request, string $id)
    {
        $category = ExpenseCategory::find($id);
        $category->name = $request->name;
        $category->save();
        notify()->success('Expense Category updated successfully');
        return back();
    }

    public function categoryDestroy(string $id)
    {
        $category = ExpenseCategory::find($id);
        $category->delete();
        notify()->success('Expense Category deleted successfully');
        return back();
    }
}
