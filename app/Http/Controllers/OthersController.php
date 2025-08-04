<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\BankAccount;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\Variation;
use App\Models\SerialNumber;
use App\Models\UsedProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Picqer\Barcode\BarcodeGeneratorSVG;

class OthersController extends Controller 
{
    public function statusUpdate(Request $request)
    {
        // validation
        // dd($request->all());
        $validated = $request->validate([
            'id' => 'required',
            'status' => 'required',
            'model' => 'required',
        ]);

        if ($validated) {
            $model = "\App\Models\\" . $request->model;
            $data = $model::find($request->id);
            $data->status = $request->status;
            $data->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Status updated successfully',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong',
            ]);
        }
    }

    public function getProductBySupplier($supplier_id)
    {
        $products = Product::where('supplier_id', $supplier_id)
            ->with('unit.related_unit')
            ->where('status', 1)
            ->orderBy('name', 'asc')
            ->get();
        return response()->json($products);
    }

    public function productSearch(Request $request)
    {
        $query = request('req');
        $products = Product::where('name', 'LIKE', "%$query%")->orWhere('barcode', 'LIKE', "%$query%")->where('status',1)->limit(10)->get();
        return response()->json($products);
    }
    public function scProductSearch(Request $request)
    {
        $query = request('req');
        $products = Product::where('name', 'LIKE', "%$query%")->orWhere('barcode', 'LIKE', "%$query%")->where('status',1)->limit(10)->get();
        return response()->json($products);
    }

    public function serialSearch(Request $request)
    {
        $query = request('req');
        $query = trim($query);
        $imeis = SerialNumber::where('serial', 'LIKE', "%$query%")->get();
        // $query = $query->product_id;
        // $products = Product::where('id',$imeis->product_id)->first();
        // return $query;
        return response()->json($imeis);
    }


    public function serialSearchDetails($my_id)
    {
        $data['imeis'] = SerialNumber::where('serial', 'LIKE', "%$my_id%")->first();
        $imeis = SerialNumber::where('serial', 'LIKE', "%$my_id%")->first();
        $data['product'] = Product::where('id', $imeis->product_id)->with('unit.related_unit')->first();
        $data['imeies'] = SerialNumber::where('product_id',$data['product']->id)->where('status',1)->get();
        $data['stock_qty'] = product_stock_check($data['product']);
        return response()->json($data);
    }

    public function productExchange(Request $request)
    {
        $query = request('req');
        $products = Product::where('name', 'LIKE', "%$query%")->orWhere('barcode', 'LIKE', "%$query%")->get();
        return response()->json($products);
    }

    public function usedProductSearch(Request $request)
    {
        $query = request('req');
        $products = UsedProduct::where('name', 'LIKE', "%$query%")->orWhere('barcode', 'LIKE', "%$query%")->where('status',1)->limit(10)->get();
        return response()->json($products);
    }

    public function productSearchDetails($my_id)
    {
        $data['product'] = Product::where('id', $my_id)->with('unit.related_unit')->where('status',1)->limit(10)->first();
        $product = Product::with('unit.related_unit')->where('status',1)->where('is_service',0)->where('id', $my_id)->first();
        $data['stock_qty'] = product_stock_check($data['product']);
        $data['brand'] = Brand::find($data['product']->brand_id);

        return response()->json($data);
    }

    public function scproductSearchDetails($my_id)
    {
        $data['product'] = Product::where('id', $my_id)->with('unit.related_unit')->first();
        $data['stock_qty'] = product_stock_check($data['product']);

        $variations = $data['product']->product_variations()->orderBy('variation_id')->get();
        $dataa = [];
        
        foreach ($variations as $variation) {
            // dd($variation);
            $dataa[] = [
                'id' => $variation->id,
                'name' => $variation->product->name,
                'size' => $variation->size->size ?? '',
                'color' => $variation->color->color ?? '',
                'stock' => variation_stock($variation->id)
            ];
        }
        $data['variations'] = $dataa;
        return response()->json($data);
    }

    public function usedProductSearchDetails($my_id)
    {
        $data['product'] = UsedProduct::where('id', $my_id)->with('unit.related_unit')->where('status',1)->limit(10)->first();
        $product = Product::with('unit.related_unit')->where('status',1)->where('is_service',0)->where('id', $my_id)->first();
        $data['stock_qty'] = used_product_stock_check($data['product']);
        // $data['brand'] = Brand::find($data['product']->brand_id);

        return response()->json($data);
    }

    public function productBarcode($code)
    {
        $generatorSVG = new BarcodeGeneratorSVG();
        $code = $generatorSVG->getBarcode($code, $generatorSVG::TYPE_CODE_128, 1.3, 20);
        return response()->json($code);
    }

    public function productUnit($my_id)
    {
        $unit = Unit::where('id', $my_id)->with('related_unit')->first();
        if ($unit->related_unit != NULL) {
            return response()->json($unit);
        }
    }

    public function posProducts(Request $request)
    {
        $data['products'] = Product::where('category_id', $request->cat_id)->with('unit.related_unit')->orderBy('name', 'ASC')->get();
        return view('backend.pages.invoice.scat-products', $data);
    }

    public function productPosDetails($my_id)
    {
        $data['product'] = Product::where('id', $my_id)->with('unit.related_unit')->first();
        $data['stock_qty'] = product_stock_check($data['product']);
        $data['brand'] = Brand::find($data['product']->brand_id);
        return response()->json($data);
    }
    public function productScPosDetails($my_id)
    {
        $data['product'] = Product::where('id', $my_id)->with('unit.related_unit')->first();
        $data['stock_qty'] = product_stock_check($data['product']);
        $variations = $data['product']->product_variations()->orderBy('variation_id')->get();
        $dataa = [];

        foreach ($variations as $variation) {
            $dataa[] = [
                'id' => $variation->id,
                'name' => $variation->product->name,
                'size' => $variation->size->size ?? '',
                'color' => $variation->color->color ?? '',
                'stock' => variation_stock($variation->id)
            ];
        }
        $data['variations'] = $dataa;
        return response()->json($data);
    }

    public function getToAccount(Request $request)
    {
        $from_bank_id = $request->from_bank_id;
        $data = BankAccount::whereNot('id', $from_bank_id)->get();
        return response()->json($data);
    }

    public function getAccountBalance(Request $request)
    {
        $bank_id = $request->bank_id;
        $data['balance'] = current_balance($bank_id);
        return response()->json($data);
    }

    public function getCustomerAccountBalance($my_id)
    {
        $customer = Customer::where('id', $my_id)->first();
        $due_invoice = Invoice::where('customer_id', $my_id)->where('status', 0)->count('id');
        $invoice_due = Invoice::where('customer_id', $my_id)->where('status', 0)->sum('total_due');
        $data['customer_name'] = $customer->name;
        $data['due_invoice'] = $due_invoice;
        $data['invoice_due'] = $invoice_due;
        $data['walletBalance'] = open_balance_customer($my_id, $customer->open_receivable, $customer->open_payable);
        $data['total_due'] = $data['invoice_due'] + $data['walletBalance'];
        return response()->json($data);
    }

    public function getSupplierAccountBalance($my_id)
    {
        $supplier = Supplier::where('id', $my_id)->first();
        $due_purchase = Purchase::where('supplier_id', $my_id)->where('status', 0)->count('id');
        $purchase_due = Purchase::where('supplier_id', $my_id)->where('status', 0)->sum('total_due');
        $data['supplier_name'] = $supplier->name;
        $data['due_purchase'] = $due_purchase;
        $data['purchase_due'] = $purchase_due;
        $data['walletBalance'] = open_balance_supplier($my_id, $supplier->open_receivable, $supplier->open_payable);
        return response()->json($data);
    }
    public function findCustomerDue(Request $request)
    {
        $customerId = $request->customer_id;
        $customer = Customer::where('id',$customerId)->first();
        $openingDue =  open_balance_customer($customerId, $customer->open_receivable, $customer->open_payable);
        $invDue = Invoice::where('customer_id', $customerId)->where('status', 0)->sum('total_due');
        
        $totalDue = $openingDue + $invDue;

        return response()->json(['total_due' => $totalDue]);
    }

    public function downloadBackup(Request $request)
    {        
        if (env('APP_MODE') == 'demo') {
            notify()->error('This Feature is not available in Demo');
            return back();
        }
        $files = Storage::files(config('app.name'));
        foreach ($files as $file) {
            Storage::delete($file);
        }
        
        Artisan::call('backup:run', ['--only-db' => true]);
        $files = Storage::files(config('app.name'));
        if ($files != null) {
            return Storage::download($files[0]);
        } else {
            notify()->warning('Database not backed up');
            return back();
        }
    }
}
