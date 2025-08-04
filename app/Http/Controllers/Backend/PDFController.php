<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Transaction;
use Illuminate\Support\Carbon;
use App\Models\Invoice;
use App\Models\User;
use App\Models\InvoiceItem;
use App\Models\PurchaseItem;
use Carbon\CarbonPeriod;
use PDF;

class PDFController extends Controller
{
    public function stock_pdf(Request $request)
    {

        $data['product_id'] = $request->product_id;
        $data['keyword'] = $request->search_keyword;
        $data['category_id'] = $request->category_id;
        $data['brand_id'] = $request->brand_id;
        //get all stock with supplier and user
        $data['products'] = Product::with('unit.related_unit')
                    ->orderBy('created_at', 'DESC')->get();
        $data['totalPrice'] = Product::all()->sum(function ($product) {
            return product_stock_check($product) * $product->purchase_price;
        });

        if ($request->product_id != null) {
            $data['products'] = Product::with('unit.related_unit')->where('id',$request->product_id )
                    ->orderBy('created_at', 'DESC')->get()
                    ->appends([
                        'product_id' => $request->product_id,
                    ]);
        }
        
        
        if ($request->category_id != null) {
            $data['products'] = Product::with('unit.related_unit')->where('category_id',$request->category_id )
                    ->orderBy('created_at', 'DESC')->get()
                    ->appends([
                        'category_id' => $request->category_id,
                    ]);
        }
        
        
        if ($request->brand_id != null) {
            $data['products'] = Product::with('unit.related_unit')->where('brand_id',$request->brand_id )
                    ->orderBy('created_at', 'DESC')->get()
                    ->appends([
                        'brand_id' => $request->brand_id,
                    ]);
        }
        
        if ($request->search_keyword != null) {
            $data['products'] = Product::with('unit.related_unit')->where('name','like','%'.$request->search_keyword.'%' )
                    ->orWhere('barcode',$request->search_keyword)
                    ->orderBy('created_at', 'DESC')->get()
                    ->appends([
                        'search_keyword' => $request->search_keyword,
                    ]);
        }
        $pdf = PDF::loadView('backend.pages.report.pdf.stock_pdf',$data);
            return $pdf->download('stock_report.pdf');
        
    }

    public function daily_pdf(Request $request){
        // if ($request->all() != NULL) {
            $data['sdate'] = Carbon::createFromDate($request->start_date)->toDateString();
            $data['edate'] = Carbon::createFromDate($request->end_date)->toDateString();
            $dateRange = CarbonPeriod::create($data['sdate'], $data['edate']);

            $data['dates'] = array_map(fn ($date) => $date->format('Y-m-d'), iterator_to_array($dateRange));
            // return view('backend.pages.report.daily', $data);
        // }
        $pdf = PDF::loadView('backend.pages.report.daily',$data);

        return $pdf->download('user_sell.pdf');
    }

    public function pdf(Request $request)
    {
            $invoice = Invoice::orderBy('id', 'desc')->get();
        $pdf = PDF::loadView('backend.pages.report.user_sell_pdf',compact('invoice'));
        return $pdf->download('user_sell.pdf');
    }
}
