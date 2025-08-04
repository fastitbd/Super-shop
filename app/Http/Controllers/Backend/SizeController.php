<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductSize;
use App\Models\ProductColor;
use App\Models\Variation;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product_size = ProductSize::orderBy('id','DESC')->get();
        return view('backend.pages.product-variation.size',compact('product_size'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'size_name' => 'required|string|unique:product_sizes,size', // Correct column name in the 'product_sizes' table
        // ], [
        //     'size_name.unique' => 'This size already exists.', // Custom error message
        // ]);

        $size = new ProductSize();
        $size->size = $request->size_name;
        $size->save();
        $this->generateVariations();

        notify()->success('Size created successfully');
        return back();
    }

//     public function stores(Request $request)
// {
//     $validator = Validator::make($request->all(), [
//         'field_name' => 'required',
//         // Add more validation rules as needed
//     ]);

//     if ($validator->fails()) {
//         return response()->json([
//             'status' => 'error',
//             'errors' => $validator->errors()
//         ], 422);
//     }

//     // Process and save the data
//     return response()->json(['status' => 'success', 'message' => 'Data saved successfully.']);
// }

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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $size = ProductSize::find($id);
        $size->delete();
        notify()->success('Size deleted successfully');
        return back();
    }

    function generateVariations()
    {
        // Fetch all sizes and colors
        $sizes = ProductSize::all();
        $colors = ProductColor::all();

        // Clear existing variations
        Variation::truncate();

        // Generate combinations
        foreach ($sizes as $size) {
            foreach ($colors as $color) {
                Variation::create([
                    'size_id' => $size->id,
                    'color_id' => $color->id,
                ]);
            }
        }

        return response()->json(['message' => 'Variations generated successfully.']);
    }
}
