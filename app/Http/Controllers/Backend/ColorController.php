<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\Variation;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() 
    {
        $product_color = ProductColor::orderBy('color','ASC')->get();
        return view('backend.pages.product-variation.color',compact('product_color'));
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
        //     'color' => 'required', 

        // ]);

        $color = new ProductColor();
        $color->color = $request->color_name;
        $color->save();
        $this->generateVariations();
        notify()->success('Color created successfully');
        return back();
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
        $color = ProductColor::find($id);
        $color->delete();
        notify()->success('Color deleted successfully');
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
