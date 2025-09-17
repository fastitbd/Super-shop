<?php

namespace App\Http\Controllers\Backend;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\Customer;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class BackendOrderController extends Controller
{
    public function index(Request $request)
    {

        $data['invoice_no'] = $request->invoice_no;
        $data['customer_id'] = $request->customer_id;
        $data['startDate'] = $request->startDate;
        $data['endDate'] = $request->endDate;
        $data['product_id'] = $request->product_id;
        $sdate = Carbon::createFromDate($request->startDate)->toDateString();
        $edate = Carbon::createFromDate($request->endDate)->toDateString();

        $data['invoices'] = Invoice::with('customer', 'user')->where('sale_type', 'Online')
            ->where('is_web',1)
            ->where('list_status',0)
            ->orderBy('created_at', 'DESC')
            ->paginate(20);

        if ($request->startDate != null && $request->endDate != null && $request->customer_id != null) {
            $data['invoices'] = Invoice::with('customer', 'user')->where('sale_type', 'Online') ->where('is_web',1)  ->where('list_status',0)->whereBetween('date', [$sdate, $edate])->where('customer_id', $request->customer_id)
                ->orderBy('created_at', 'DESC')
                ->paginate(20)->appends([
                    'customer_id' => $request->customer_id,
                    'startDate' => $sdate,
                    'endDate' => $edate,
                ]);
        }
        if ($request->startDate != null && $request->endDate != null) {
            $data['invoices'] = Invoice::with('customer', 'user')->where('sale_type', 'Online')->where('is_web',1)->where('list_status',0)->whereBetween('date', [$sdate, $edate])
                ->orderBy('created_at', 'DESC')
                ->paginate(20)->appends([
                    'startDate' => $sdate,
                    'endDate' => $edate,
                ]);
        }
        if ($request->invoice_no != null) {
            $data['invoices'] = Invoice::with('customer', 'user')->where('sale_type', 'Online')->where('is_web',1)->where('invoice_no', $request->invoice_no)
                ->orderBy('created_at', 'DESC')
                ->paginate(20)->appends([
                    'invoice_no' => $request->invoice_no,
                ]);
        }
        if ($request->customer_id != null) {
            $data['invoices'] = Invoice::with('customer', 'user')->where('sale_type', 'Online')->where('is_web',1)->where('list_status',1)->where('customer_id', $request->customer_id)
                ->orderBy('created_at', 'DESC')
                ->paginate(20)->appends([
                    'customer_id' => $request->customer_id,
                ]);
        }
        if ($request->product_id != null) {
            $keyword = $request->product_id;
            $data['invoices'] = Invoice::where('sale_type', 'Online')->where('is_web',1)->where('list_status',0)->whereHas('invoiceItems.product', function ($query) use ($keyword) {
                $query->where('id', $keyword);
            })->orderBy('created_at', 'DESC')->paginate(20)
                ->appends([
                    'keyword' => $request->keyword,
                ]);
        }
        if ($request->courier != null) {
            $data['invoices'] = Invoice::with('customer', 'user')->where('is_web',1)->where('sale_type', 'Online')->where('list_status',0)->where('courier_type', $request->courier)
                ->orderBy('created_at', 'DESC')
                ->paginate(20)->appends([
                    'invoice_no' => $request->courier,
                ]);
        }


        $invoices = Invoice::orderBy('created_at', 'desc')->where('is_web',1)->get();  // Get all invoices
        $latestInvoice = $invoices->first();
        return view('backend.pages.order.index',$data, compact('invoices'));
    }
}
