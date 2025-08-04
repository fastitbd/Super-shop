<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->paginate(20);
        return view('backend.pages.category.index', compact('categories'));
    }


    public function store(Request $request)
    {

        $url = Str::slug($request['name'], '-');
        $category = new Category();
        $category->name = $request->name;
        $category->url = $url;
        $category->order_by = $request->order_by;


        if ($request->hasFile('images')) {
            $image = $request->file('images');
            $imageName = "cat_" . time() . '.' . $image->getClientOriginalExtension();

            $uploadPath = public_path('uploads/category');

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            Image::read($image)->resize(200, 150)->save($uploadPath . '/' . $imageName);
            $category->images = $imageName;
        }

        $category->save();
        notify()->success('Category created successfully');
        return back();
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $url = Str::slug($request->name, '-');
        $category->name = $request->name;
        $category->url = $url;
        $category->order_by = $request->order_by;

        if ($request->hasFile('images')) {
            $image = $request->file('images');
            $imageName = "cat_" . time() . '.' . $image->getClientOriginalExtension();
            $uploadPath = public_path('uploads/category');

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            if (!empty($category->images) && file_exists($uploadPath . '/' . $category->images)) {
            unlink($uploadPath . '/' . $category->images);
            }


            Image::read($image)->resize(200, 150)->save($uploadPath . '/' . $imageName);
            $category->images = $imageName;
        }

        $category->save();
        notify()->success('Category updated successfully');
        return back();
    }


    public function destroy(string $id)
    {
        $category = Category::find($id);
        $category->delete();
        notify()->success('Category deleted successfully');
        return back();
    }
}
