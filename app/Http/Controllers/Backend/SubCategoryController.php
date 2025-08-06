<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class SubCategoryController extends Controller
{

    public function index()
    {
        $allcategory = Category::orderBy('id','asc')->get();
        $subcategories = SubCategory::orderBy('id', 'desc')->paginate(20);
        return view('backend.pages.subcategory.index', compact('subcategories','allcategory'));
    }


    public function getSubcategories($categoryId)
{
    $subcategories = SubCategory::where('category_id', $categoryId)->get();

    return response()->json($subcategories);
}
 
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $url = Str::slug($request['name'], '-');
        $subcategory = new SubCategory();
        $subcategory->name = $request->name;
        $subcategory->url = $url;
        $subcategory->category_id = $request->category_id;
        $subcategory->order_by = $request->order_by;


        $subcategory->save();
        notify()->success('Category created successfully');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

 
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    $subcategory = SubCategory::findOrFail($id);
    $subcategory->name = $request->name;
    $subcategory->url = Str::slug($request->name, '-');
    $subcategory->category_id = $request->category_id;
    $subcategory->order_by = $request->order_by;
    $subcategory->save();

    notify()->success('Sub Category updated successfully');
    return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subcategory = SubCategory::find($id);
        $subcategory->delete();
        notify()->success('Sub Category deleted successfully');
        return back();
    }
}
