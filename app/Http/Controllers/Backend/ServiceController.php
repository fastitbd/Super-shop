<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['products'] = Product::where('is_service', '1')
            ->orderBy('created_at', 'DESC')->paginate(20);
        $data['product_id'] = $request->product_id;
        // $data['category_id'] = $request->category_id;
        $data['barcode'] = $request->barcode;
        // $data['com'] = BusinessSetting::where('id', 6)->first();

        if ($request->product_id != null) {
            $data['products'] = Product::where('is_service', '1')
                ->where('id', $request->product_id)
                ->orderBy('created_at', 'DESC')
                ->paginate(10)->appends([
                    'product_id' => $request->product_id,
                ]);
        }
        if ($request->barcode != null) {
            $data['products'] = Product::where('is_service', '1')
                ->where('barcode', $request->barcode)
                ->orderBy('created_at', 'DESC')
                ->paginate(10);
        }

        return view('backend.pages.service.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.service.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate(
            [
                'name' => 'required|unique:products',
                'barcode' => 'unique:products',
                'selling_price' => 'required',
                'status' => 'required',
            ],
            [
                'name.unique' => 'The service name has already been taken !',
                'barcode.unique' => 'The service barcode has already been taken !',
            ]
        );



        $product = new Product();
        $product->date = date('Y-m-d');
        $product->name = $request->name;
        $product->is_service = 1;
        $numberBarcode = rand(000000, 999999);
        if ($request->barcode == NULL) {
            $product->barcode = $numberBarcode;
        } else {
            $product->barcode = $request->barcode;
        }
        $product->selling_price = $request->selling_price;
        $product->status = $request->status;
        $product->description = $request->description;

        $product->save();
        notify()->success('Service created successfully!');
        return Redirect()->route('service.index');
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
        $data['data'] = Product::where('is_service', 1)->where('id', $id)->first();
        return view('backend.pages.service.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'barcode' => 'numeric',
            'selling_price' => 'required',
            'status' => 'required',
        ]);
        $product = Product::findorfail($id);
        $product->name = $request->name;
        $numberBarcode = rand(000000, 999999);
        if ($product->barcode == NULL) {
            $product->barcode = $numberBarcode;
        } else {
            $product->barcode = $request->barcode;
        }
        $product->selling_price = $request->selling_price;
        $product->status = $request->status;
        $product->description = $request->description;
        $product->save();

        notify()->success('Service update successfully!'); 
        return Redirect()->route('service.index'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findorfail($id);
        $product->delete();
        notify()->success('Successfully Service Delete!');
        return back();
    }
}
