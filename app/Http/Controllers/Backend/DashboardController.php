<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\ReturnItem;
use App\Models\ReturnPurchase;
use App\Models\Customer;
use App\Models\ReturnTbl;
use App\Models\Damage;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $data['total_pur_due'] = Purchase::sum('total_due');
        $total_pur = Purchase::sum('total_amount');
        $data['total_pur_amount'] = $total_pur;
        $data['total_product'] = Product::count();
        $data['total_sale_due'] = Invoice::sum('total_due');
        $data['total_expenses'] = Expense::sum('amount');
        $total_inv = Invoice::sum('total_amount');
        $data['total_sale'] = $total_inv;
        // dd($total_sale);
        $data['total_customer'] = Customer::count();
        $data['total_return_amount'] = ReturnTbl::sum('total_return');
        $data['inv_due'] = Invoice::where('date',date('Y-m-d'))->sum('total_due');
        // $f = Product::all()->sum(function ($product) {
        //     // dd(product_stock_balance($product));
        //     return product_stock_balance($product) * $product->purchase_price;
        // });


        $saleCost = InvoiceItem::sum('inv_subtotal');
        $purchaseCost = InvoiceItem::sum('pur_subtotal');
        $returns = ReturnItem::get();
        $discount = Invoice::sum('discount_amount');
        $returnDis = ReturnTbl::sum('discount_amount');
        $damage = Damage::sum('total_amount');
        $return_total = ReturnItem::sum('pur_subtotal');
        $dis = $discount - $returnDis;
        $totalProfit = $saleCost - $purchaseCost;
        $profit = $totalProfit - $dis ;

        $sale_amu = $total_inv - $profit;

        $avail_stock = $total_pur + $return_total - $sale_amu - $damage;

        $data['totalPrice'] = $avail_stock;

        $data['total_invoice_count'] = Invoice::count();

        $items = $this->getDashboardData('Today');
        return view('backend.pages.dashboard.index',$data,['data' => $items, 'filter' => 'Today']);
    }

    public function filterData(Request $request)
    {
        $filter = $request->input('filter');
        $data = $this->getDashboardData($filter);

        return response()->json($data);
    }

    private function getDashboardData($filter)
    {
        switch ($filter) { 
            case 'Today':
                $dateFilter = 'Today';
                $dateRange = [Carbon::today(), Carbon::today()->endOfDay()];
                break;
            case 'Yesterday':
                $dateFilter = 'Yesterday';
                $dateRange = [Carbon::yesterday(), Carbon::yesterday()->endOfDay()];
                break;
            case 'This-week':
                $dateFilter = 'This Week';
                $dateRange = [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()];
                break;
            case 'This-month':
                $dateFilter = 'This Month';
                $dateRange = [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()];
                break;
            case 'This-year':
                $dateFilter = 'This Year';
                $dateRange = [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()];
                break;
            default:
                $dateRange = [Carbon::minValue(), Carbon::maxValue()];
                break;
        }

        return [
            $total_sale_today = Invoice::whereBetween('date', $dateRange)->sum('total_amount'),
            $returns = ReturnItem::whereBetween('date',$dateRange)->sum('subtotal'),
            $today_sale = $total_sale_today,
            'sale' => $today_sale,
            'purchase' => Purchase::whereBetween('date', $dateRange)->sum('total_amount'),
            'expense' => Expense::whereBetween('date', $dateRange)->sum('amount'),
            'profit' => $this->calculateProfit($dateRange),
        ];
    }

    private function calculateProfit($dateRange)
    {
        $saleCost = InvoiceItem::whereBetween('date', $dateRange)->sum('inv_subtotal');
        $purchaseCost = InvoiceItem::whereBetween('date', $dateRange)->sum('pur_subtotal');
        $returns = ReturnItem::whereBetween('date', $dateRange)->get();
        $discount = Invoice::whereBetween('date', $dateRange)->sum('discount_amount');
        $returnDis = ReturnTbl::whereBetween('date', $dateRange)->sum('discount_amount');
        $dis = $discount - $returnDis;
        $totalProfit = $saleCost - $purchaseCost;
        $profit = $totalProfit - rtn_profit($returns)- $dis ;
        return $profit;
    }
}
