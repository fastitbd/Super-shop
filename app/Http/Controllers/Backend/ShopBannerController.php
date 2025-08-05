<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShopBanner;
use Illuminate\Support\Str;
use Image;

class ShopBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allshopbanner = ShopBanner:: where('status', 1)->orderBy('order_by','asc')->get();
        return view('backend.pages.shopBanner.index', compact('allshopbanner'));
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
        $url = Str::slug($request['name'], '-');
        $shopbanner = new ShopBanner();
        $shopbanner->name = $request->name;
        $shopbanner->url = $url;
        $shopbanner->order_by = $request->order_by;


        if ($request->hasFile('images')) {
            $image = $request->file('images');
            $imageName = "cat_" . time() . '.' . $image->getClientOriginalExtension();

            $uploadPath = public_path('uploads/shopbanner');

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            Image::read($image)->resize(850, 400)->save($uploadPath . '/' . $imageName);
            $shopbanner->images = $imageName;
        }

        $shopbanner->save();
        notify()->success('Banner created successfully');
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
        $shopbanner = ShopBanner::findOrFail($id);

        $url = Str::slug($request->name, '-');
        $shopbanner->name = $request->name;
        $shopbanner->url = $url;
        $shopbanner->order_by = $request->order_by;

        if ($request->hasFile('images')) {
            $image = $request->file('images');
            $imageName = "cat_" . time() . '.' . $image->getClientOriginalExtension();
            $uploadPath = public_path('uploads/shopbanner');

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            if (!empty($shopbanner->images) && file_exists($uploadPath . '/' . $shopbanner->images)) {
            unlink($uploadPath . '/' . $shopbanner->images);
            }


            Image::read($image)->resize(850, 400)->save($uploadPath . '/' . $imageName);
            $shopbanner->images = $imageName;
        }

        $shopbanner->save();
        notify()->success('Banner updated successfully');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $shopbanner = ShopBanner::find($id);
        $shopbanner->delete();
        notify()->success('Shopbanner deleted successfully');
        return back();
    }
}
