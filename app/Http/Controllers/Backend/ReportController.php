<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\BankTransaction;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\OwnerShip;
use App\Models\Product;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Models\UsedProduct;
use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
class ReportController extends Controller
{
    public function stock(Request $request)
    {       
        if(env('APP_SC') == 'yes'){
                $data['product_id'] = $request->product_id;
                $data['keyword'] = $request->search_keyword;
                $data['category_id'] = $request->category_id;
                $data['brand_id'] = $request->brand_id;
                //get all stock with supplier and user
                $data['products'] = Product::with('unit.related_unit')
                            ->orderBy('created_at', 'DESC')
                            ->paginate(20);

                if ($request->product_id != null) {
                    $data['products'] = Product::with('unit.related_unit')->where('id',$request->product_id )
                            ->orderBy('created_at', 'DESC')
                            ->paginate(20);
                }
                
                
                if ($request->category_id != null) {
                    $data['products'] = Product::with('unit.related_unit')->where('category_id',$request->category_id )
                            ->orderBy('created_at', 'DESC')
                            ->paginate(20);
                }
                
                
                if ($request->brand_id != null) {
                    $data['products'] = Product::with('unit.related_unit')->where('brand_id',$request->brand_id )
                            ->orderBy('created_at', 'DESC')
                            ->paginate(20);
                }
                
                
                if ($request->search_keyword != null) {
                    $data['products'] = Product::with('unit.related_unit')->where('name','like','%'.$request->search_keyword.'%' )
                            ->orWhere('barcode',$request->search_keyword)
                            ->orderBy('created_at', 'DESC')
                            ->paginate(20);
                }
                return view('backend.pages.report.sc_stock', $data);
        }else if(env('APP_IMEI') == 'yes'){
        
            $data['product_id'] = $request->product_id;
            $data['keyword'] = $request->search_keyword;
            $data['category_id'] = $request->category_id;
            $data['brand_id'] = $request->brand_id;
            //get all stock with supplier and user
            $data['products'] = Product::with('unit.related_unit')
                        ->orderBy('created_at', 'DESC')
                        ->paginate(20);
    
            if ($request->product_id != null) {
                $data['products'] = Product::with('unit.related_unit')->where('id',$request->product_id )
                        ->orderBy('created_at', 'DESC')
                        ->paginate(20);
            }
            
            
            if ($request->category_id != null) {
                $data['products'] = Product::with('unit.related_unit')->where('category_id',$request->category_id )
                        ->orderBy('created_at', 'DESC')
                        ->paginate(20);
            }
            
            
            if ($request->brand_id != null) {
                $data['products'] = Product::with('unit.related_unit')->where('brand_id',$request->brand_id )
                        ->orderBy('created_at', 'DESC')
                        ->paginate(20);
            }
            
            
            if ($request->search_keyword != null) {
                $data['products'] = Product::with('unit.related_unit')->where('name','like','%'.$request->search_keyword.'%' )
                        ->orWhere('barcode',$request->search_keyword)
                        ->orderBy('created_at', 'DESC')
                        ->paginate(20);
            }
            return view('backend.pages.report.imei_stock_report', $data);

        }else{
            $data['product_id'] = $request->product_id;
            $data['keyword'] = $request->search_keyword;
            $data['category_id'] = $request->category_id;
            $data['brand_id'] = $request->brand_id;
            //get all stock with supplier and user
            $data['products'] = Product::with('unit.related_unit')
                        ->where('is_service',0)
                        ->orderBy('created_at', 'DESC')
                        ->paginate(20);
            $data['totalPrice'] = Product::all()->sum(function ($product) {
                // dd(product_stock_balance($product));
                return (float)product_stock($product) * $product->purchase_price;
            });

            if ($request->product_id != null) {
                $data['products'] = Product::with('unit.related_unit')->where('id',$request->product_id )
                        ->orderBy('created_at', 'DESC')
                        ->paginate(20)
                        ->appends([
                            'product_id' => $request->product_id,
                        ]);
            }
            
            if ($request->category_id != null) {
                $data['products'] = Product::with('unit.related_unit')->where('category_id',$request->category_id )
                        ->orderBy('created_at', 'DESC')
                        ->paginate(20)
                        ->appends([
                            'category_id' => $request->category_id,
                        ]);
            }
            
            
            if ($request->brand_id != null) {
                $data['products'] = Product::with('unit.related_unit')->where('brand_id',$request->brand_id )
                        ->orderBy('created_at', 'DESC')
                        ->paginate(20)
                        ->appends([
                            'brand_id' => $request->brand_id,
                        ]);
            }
            
            
            if ($request->search_keyword != null) {
                $data['products'] = Product::with('unit.related_unit')->where('name','like','%'.$request->search_keyword.'%' )
                        ->orWhere('barcode',$request->search_keyword)
                        ->orderBy('created_at', 'DESC')
                        ->where('is_service',0)
                        ->paginate(20)
                        ->appends([
                            'search_keyword' => $request->search_keyword,
                        ]);
            }
            return view('backend.pages.report.stock', $data);
        }
    }

    public function supplierLedger(Request $request)
    {
        $data['suppliers'] = Supplier::orderBy('created_at', 'desc')->get();
        if ($request->all() != NULL) {
            $data['oneSupplier'] = Supplier::where('id', $request->supplier_id)->where('status', 1)->first();
            $data['sdate'] = Carbon::createFromDate($request->start_date)->format('Y-m-d');
            $data['edate'] = Carbon::createFromDate($request->end_date)->format('Y-m-d');
            // dd($data['sdate'],$data['edate']);
            $data['transaction'] = Transaction::with('invoice', 'purchase', 'supplier')
                                    ->where('supplier_id', $request->supplier_id)
                                    ->whereBetween('date', [$data['sdate'], $data['edate']])
                                    ->get();
            $transc = Transaction::with('invoice', 'purchase', 'supplier')
                ->where('supplier_id', $request->supplier_id)
                ->get();                                
            $data['closeing_balance']  = $transc->sum('debit') - $transc->sum('credit'); 
        }
        return view('backend.pages.report.supplier_ledger', $data);
    }

    public function customerLedger(Request $request)
    {
        $data['customers'] = Customer::orderBy('created_at', 'desc')->get();
        if ($request->all() != NULL) {
            $data['oneCustomer'] = Customer::where('id', $request->customer_id)->where('status', 1)->first();
            $data['sdate'] = Carbon::createFromDate($request->start_date)->format('Y-m-d');
            $data['edate'] = Carbon::createFromDate($request->end_date)->format('Y-m-d');
            // dd($data['sdate'],$data['edate']);
            $data['transaction'] = Transaction::with('invoice', 'purchase', 'customer')
                                    ->where('customer_id', $request->customer_id)
                                    ->whereBetween('date', [$data['sdate'], $data['edate']])
                                    ->get();
            $transc = Transaction::with('invoice', 'purchase', 'customer')
            ->where('customer_id', $request->customer_id)
            ->get();                                
            $data['closeing_balance']  = $transc->sum('debit') - $transc->sum('credit');  
        }
        return view('backend.pages.report.customer_ledger', $data);
    }



    public function customerDue(Request $request)
    {
        $data['customer_id'] = $request->customer_id;
        $data['phone_no'] = $request->phone_no;

        // Query base
        $customersQuery = Customer::query();

        if ($request->customer_id != null) {
            $customersQuery->where('id', $request->customer_id);
        }

        if ($request->phone_no != null) {
            $customersQuery->where('phone', $request->phone_no);
        }

        // Get customers and filter those who have due
        $filteredCustomers = $customersQuery->get()->filter(function ($customer) {
            $inv_due = Invoice::where('customer_id', $customer->id)->sum('total_due');
            $open_balance = open_balance_customer($customer->id, $customer->open_receivable, $customer->open_payable);
            return ($inv_due + $open_balance) > 0;
        })->values(); // reset index

        // Manual pagination
        $page = request()->get('page', 1);
        $perPage = 20;
        $offset = ($page - 1) * $perPage;

        $paginated = new LengthAwarePaginator(
            $filteredCustomers->slice($offset, $perPage),
            $filteredCustomers->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $data['customers'] = $paginated;

        return view('backend.pages.report.customer_due',$data);
    }
    public function supplierDue(Request $request)
    {
        $data['supplier_id'] = $request->supplier_id;
        $data['phone_no'] = $request->phone_no;
    
        // Base query
        $suppliersQuery = Supplier::query();
    
        if ($request->supplier_id != null) {
            $suppliersQuery->where('id', $request->supplier_id);
        }
    
        if ($request->phone_no != null) {
            $suppliersQuery->where('phone', $request->phone_no);
        }
    
        // Get all matching suppliers
        $filteredSuppliers = $suppliersQuery->get()->filter(function ($supplier) {
            $total_payable = \App\Models\Purchase::where('supplier_id', $supplier->id)->sum('total_amount');
            $total_paid = \App\Models\Purchase::where('supplier_id', $supplier->id)->sum('total_paid');
            $opening_balance = $supplier->opening_balance ?? 0;
    
            $total_due = ($total_payable - $total_paid) + $opening_balance;
    
            return $total_due > 0;
        })->values(); // reset index
    
        // Manual pagination
        $page = request()->get('page', 1);
        $perPage = 20;
        $offset = ($page - 1) * $perPage;
    
        $paginated = new LengthAwarePaginator(
            $filteredSuppliers->slice($offset, $perPage),
            $filteredSuppliers->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    
        $data['suppliers'] = $paginated;
    
        return view('backend.pages.report.supplier_due',$data);
    }

    public function daily(Request $request)
    { 
        if ($request->all() != NULL) {
            $data['sdate'] = Carbon::createFromDate($request->start_date)->toDateString();
            // $data['edate'] = Carbon::createFromDate($request->end_date)->toDateString();
            // $dateRange = CarbonPeriod::create($data['sdate'], $data['edate']);
            $ssdate = Carbon::createFromDate('2023-09-01')->toDateString();
            $sdate = Carbon::createFromDate($request->start_date)->toDateString();

            $data['bankAcc'] = BankAccount::where('status',1)->orderBy('id','asc')->first();
            
            $data['invoices'] = Invoice::with('invoiceItems')->where('date',$sdate)->get();
            // $data['dueInvoices'] = Invoice::with('invoiceItems')->where('due_date',$sdate)->get();
            $data['bankTrans'] = BankTransaction::where('date',$sdate)->where('pay_type','duepay')->get();
            $data['bankTransdue'] = BankTransaction::where('date',$sdate)->where('pay_type','duepay')->sum('amount');
            

            $previous_total_sale = Invoice::whereBetween('date', [$ssdate,$sdate])->sum('total_amount');

            
            
            $today_total_sale = Invoice::where('date',$sdate)->sum('total_amount');
            $privious_sale = ($previous_total_sale - $today_total_sale);
            $today_sale_amount = Invoice::where('date',$sdate)->sum('total_amount');
            $total_expense = Expense::where('date',$sdate)->get();

            return view('backend.pages.report.daily', $data ,compact('today_sale_amount','total_expense','privious_sale','previous_total_sale'));
        } else {
            return view('backend.pages.report.daily');
        }
    }
    public function sale(Request $request)
    {   
        $data['categories'] = Category::orderBy('created_at', 'desc')->get();
        $data['products'] = Product::orderBy('created_at', 'desc')->get();

        if ($request->all() != NULL) {
            $data['oneProduct'] = Product::find($request->product_id); // Using find() for efficiency
            $data['sdate'] = Carbon::parse($request->start_date)->toDateString(); // Use parse() for more flexibility
            $data['edate'] = Carbon::parse($request->end_date)->toDateString();

            $sdate = $data['sdate'];
            $edate = $data['edate'];

            $invoiceItem = Invoice::whereBetween('date', [$sdate, $edate]);

           
            $invoiceItem = Invoice::whereBetween('date', [$sdate, $edate])
            ->whereHas('invoiceItems', function($query) use ($request) {
                if (!empty($request->product_id) || !empty($request->category_id)) {
                    // Filter by product_id in the InvoiceItem table
                    if (!empty($request->product_id)) {
                        $query->where('product_id', $request->product_id);
                    }
    
                    // Filter by category_id in the Product table
                    if (!empty($request->category_id)) {
                        $query->whereHas('product', function($subQuery) use ($request) {
                            $subQuery->where('category_id', $request->category_id);
                        });
                    }
                }
            });

        $data['invoiceItem'] = $invoiceItem->get();
        }

        return view('backend.pages.report.sale', $data);

    }

    public function topSellingProducts(Request $request)
    {
        $data['categories'] = Category::orderBy('created_at', 'desc')->get();
        $data['productList'] = Product::where('is_service',0)->orderBy('created_at', 'desc')->get();
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $data['category_id'] = $request->category_id;
        $data['product_id'] = $request->product_id;
        

         $data['products'] = Product::select('products.id', 'products.name', 'products.barcode', DB::raw('SUM(invoice_items.main_qty) as total_sold'))
            ->where('products.is_service', 0)
            ->join('invoice_items', 'products.id', '=', 'invoice_items.product_id')
            ->whereBetween('invoice_items.date', [$startDate, $endDate])
            ->groupBy('products.id', 'products.name', 'products.barcode')
            ->orderByDesc('total_sold')
            ->get();
        // dd($data['products']);

        return view('backend.pages.report.top_selling_products', $data);
    }


    public function topCustomers(Request $request)
        {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $data['invoices'] = Invoice::orderBy('created_at', 'desc')->get();
            $data['customerlist'] = Customer::orderBy('created_at', 'desc')->get();

            $data['sdate'] = $startDate;
            $data['edate'] = $endDate;

            $data['customer'] = Customer::select(
                    'customers.id',
                    'customers.name',
                    'customers.phone',
                    'customers.address',
                    DB::raw('COUNT(invoices.id) as total_invoices')
                )
                ->join('invoices', 'customers.id', '=', 'invoices.customer_id')
                ->where('customers.id', '!=', 1)
                ->whereBetween('invoices.created_at', [$startDate, $endDate])
                ->groupBy('customers.id', 'customers.name', 'customers.phone', 'customers.address')
                ->orderByDesc('total_invoices')
                ->get();

            return view('backend.pages.report.top_customer', $data);
        }


    

    public function purchase(Request $request)
    {
        $data['products'] = Product::orderBy('created_at', 'desc')->get();

        if ($request->all() != NULL) {
            $data['oneProduct'] = Product::where('id', $request->product_id)->first();
            $data['sdate'] = Carbon::createFromDate($request->start_date)->toDateString();
            $data['edate'] = Carbon::createFromDate($request->end_date)->toDateString();
            $sdate = $data['sdate'];
            $edate = $data['edate'];
            $purchaseItem = PurchaseItem::with('purchase', 'product')
                                        ->whereHas('purchase', function ($query) use ($sdate, $edate) {
                                            $query->whereBetween('date', [$sdate, $edate]);
                                        });
            if($request->product_id != NULL){
                $purchaseItem = $purchaseItem->where('product_id', $request->product_id);
            }
            $data['purchaseItem'] = $purchaseItem->get();
        }
        return view('backend.pages.report.purchase', $data);
    }

    public function dailyStock(Request $request)
    {
        $sdate = $request->start_date ? Carbon::parse($request->start_date)->toDateString() : Carbon::today()->toDateString();
        $edate = $request->end_date ? Carbon::parse($request->end_date)->toDateString() : Carbon::today()->toDateString();
        $productNameFilter = $request->product_name;

        $data['sdate'] = $sdate;
        $data['edate'] = $edate;
        $data['product_name'] = $productNameFilter;

        // Get items
        $previousPurchases = PurchaseItem::where('date', '<', $sdate)->get();
        $todayPurchases = PurchaseItem::whereBetween('date', [$sdate, $edate])->get();

        $previousInvoices = InvoiceItem::where('date', '<', $sdate)->get();
        $todayInvoices = InvoiceItem::whereBetween('date', [$sdate, $edate])->get();

        $previousReturns = ReturnItem::where('date', '<', $sdate)->get();
        $todayReturns = ReturnItem::whereBetween('date', [$sdate, $edate])->get();

        $previousDamages = DamageItem::where('date', '<', $sdate)->get();
        $todayDamages = DamageItem::whereBetween('date', [$sdate, $edate])->get();

        $products = [];
        $productQuantities = [];

        $initProduct = function ($product_id) use (&$products, &$productQuantities, $productNameFilter, $request) {
            if (!isset($products[$product_id])) {
                $product = Product::find($product_id);
                if (!$product) return;

                $nameMatch = !$productNameFilter || str_contains(strtolower($product->name), strtolower($productNameFilter));

                // Filter logic
                if ($request->filled('product_name') || $request->filled('start_date') || $request->filled('end_date')) {
                    if ($nameMatch) {
                        $products[$product_id] = $product;
                    }
                } else {
                    // No filters, show all
                    $products[$product_id] = $product;
                }
            }

            if (!isset($productQuantities[$product_id])) {
                $productQuantities[$product_id] = [
                    'prev_purchase' => 0,
                    'purchase' => 0,
                    'prev_invoice' => 0,
                    'invoice' => 0,
                    'prev_return' => 0,
                    'return' => 0,
                    'prev_damage' => 0,
                    'damage' => 0,
                ];
            }
        };

        // Fill quantities
        foreach ($previousPurchases as $item) {
            $initProduct($item->product_id);
            $productQuantities[$item->product_id]['prev_purchase'] += $item->main_qty;
        }

        foreach ($todayPurchases as $item) {
            $initProduct($item->product_id);
            $productQuantities[$item->product_id]['purchase'] += $item->main_qty;
        }

        foreach ($previousInvoices as $item) {
            $initProduct($item->product_id);
            $productQuantities[$item->product_id]['prev_invoice'] += $item->main_qty;
        }

        foreach ($todayInvoices as $item) {
            $initProduct($item->product_id);
            $productQuantities[$item->product_id]['invoice'] += $item->main_qty;
        }

        foreach ($previousReturns as $item) {
            $initProduct($item->product_id);
            $productQuantities[$item->product_id]['prev_return'] += $item->main_qty;
        }

        foreach ($todayReturns as $item) {
            $initProduct($item->product_id);
            $productQuantities[$item->product_id]['return'] += $item->main_qty;
        }

        foreach ($previousDamages as $item) {
            $initProduct($item->product_id);
            $productQuantities[$item->product_id]['prev_damage'] += $item->main_qty;
        }

        foreach ($todayDamages as $item) {
            $initProduct($item->product_id);
            $productQuantities[$item->product_id]['damage'] += $item->main_qty;
        }

        $data['products'] = array_values($products);
        $data['productQuantities'] = $productQuantities;

        return view('backend.pages.report.date_stock_report', $data);
    }

    
    public function profitLoss(Request $request)
    {
        if ($request->all() != NULL) {
            $data['sdate'] = Carbon::createFromDate($request->start_month)->toDateString();
            $data['edate'] = Carbon::createFromDate($request->end_month)->toDateString();
            $dateRange = CarbonPeriod::create($data['sdate'], $data['edate']);

            $data['groupedDates'] = [];
            foreach ($dateRange as $date) {
                $data['groupedDates'][$date->format('Y-m')][] = $date->toDateString();
            }
            return view('backend.pages.report.profit_loss', $data);
        } else {
            return view('backend.pages.report.profit_loss');
        }
    }

    public function low_stock(Request $request)
    {
        $data['product_id'] = $request->product_id;
        $data['keyword'] = $request->search_keyword;
        $data['category_id'] = $request->category_id;
        $data['brand_id'] = $request->brand_id;
        //get all stock with supplier and user
        $data['products'] = Product::with('unit.related_unit')
                    ->orderBy('created_at', 'DESC')
                    ->paginate(20);
        $data['low_stock'] = Product::all()->sum(function ($product) {
            
        });
        

        if ($request->product_id != null) {
            $data['products'] = Product::with('unit.related_unit')->where('id',$request->product_id )
                    ->orderBy('created_at', 'DESC')
                    ->paginate(20)
                    ->appends([
                        'product_id' => $request->product_id,
                    ]);
        }
        
        if ($request->category_id != null) {
            $data['products'] = Product::with('unit.related_unit')->where('category_id',$request->category_id )
                    ->orderBy('created_at', 'DESC')
                    ->paginate(20)
                    ->appends([
                        'category_id' => $request->category_id,
                    ]);
        }
        
        
        if ($request->brand_id != null) {
            $data['products'] = Product::with('unit.related_unit')->where('brand_id',$request->brand_id )
                    ->orderBy('created_at', 'DESC')
                    ->paginate(20)
                    ->appends([
                        'brand_id' => $request->brand_id,
                    ]);
        }
        
        
        if ($request->search_keyword != null) {
            $data['products'] = Product::with('unit.related_unit')->where('name','like','%'.$request->search_keyword.'%' )
                    ->orWhere('barcode',$request->search_keyword)
                    ->orderBy('created_at', 'DESC')
                    ->paginate(20)
                    ->appends([
                        'search_keyword' => $request->search_keyword,
                    ]);
        }
        return view('backend.pages.report.low_stock_report', $data);
    }

    public function user_sell(Request $request)
    {   
        $data['users'] = User::orderBy('created_at', 'desc')->get();
        
        if ($request->all() != NULL) {
            $data['sdate'] = Carbon::createFromDate($request->start_date)->toDateString();
            $data['edate'] = Carbon::createFromDate($request->end_date)->toDateString();
            $sdate = $data['sdate'];
            $edate = $data['edate'];
            $data['oneUser'] = $request->user_id;

            $invoiceItem = Invoice::where('created_by',$request->user_id)->whereBetween('date', [$sdate, $edate]);
            
            $data['invoiceItem'] = $invoiceItem->get();
        }
        return view('backend.pages.report.user_sell', $data);
    }

    public function usedStock(Request $request)
    {
        $data['product_id'] = $request->product_id;
        $data['keyword'] = $request->search_keyword;
        $data['category_id'] = $request->category_id;
        $data['brand_id'] = $request->brand_id;
        //get all stock with supplier and user
        $data['products'] = UsedProduct::with('unit.related_unit')
                    ->orderBy('created_at', 'DESC')
                    ->paginate(20);
        $data['totalPrice'] = UsedProduct::all()->sum(function ($product) {
            // dd(product_stock_balance($product));
            return product_stock_balance($product) * $product->purchase_price;
        });

        if ($request->product_id != null) {
            $data['products'] = UsedProduct::with('unit.related_unit')->where('id',$request->product_id )
                    ->orderBy('created_at', 'DESC')
                    ->paginate(20)
                    ->appends([
                        'product_id' => $request->product_id,
                    ]);
        }
        
        if ($request->category_id != null) {
            $data['products'] = UsedProduct::with('unit.related_unit')->where('category_id',$request->category_id )
                    ->orderBy('created_at', 'DESC')
                    ->paginate(20)
                    ->appends([
                        'category_id' => $request->category_id,
                    ]);
        }
        
        if ($request->brand_id != null) {
            $data['products'] = UsedProduct::with('unit.related_unit')->where('brand_id',$request->brand_id )
                    ->orderBy('created_at', 'DESC')
                    ->paginate(20)
                    ->appends([
                        'brand_id' => $request->brand_id,
                    ]);
        }
        
        if ($request->search_keyword != null) {
            $data['products'] = UsedProduct::with('unit.related_unit')->where('name','like','%'.$request->search_keyword.'%' )
                    ->orWhere('barcode',$request->search_keyword)
                    ->orderBy('created_at', 'DESC')
                    ->paginate(20)
                    ->appends([
                        'search_keyword' => $request->search_keyword,
                    ]);
        }
        return view('backend.pages.report.usedStock', $data);
    }



    
}
