<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Str;
use Image;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    { 
        $allbanner = Banner:: where('status', 1)->orderBy('order_by','asc')->get();
        return view('backend.pages.banner.index', compact('allbanner'));
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
        $banner = new Banner();
        $banner->name = $request->name;
        $banner->url = $url;
        $banner->order_by = $request->order_by;


        if ($request->hasFile('images')) {
            $image = $request->file('images');
            $imageName = "cat_" . time() . '.' . $image->getClientOriginalExtension();

            $uploadPath = public_path('uploads/banner');

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            Image::read($image)->resize(850, 400)->save($uploadPath . '/' . $imageName);
            $banner->images = $imageName;
        }

        $banner->save();
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
        $banner = Banner::findOrFail($id);

        $url = Str::slug($request->name, '-');
        $banner->name = $request->name;
        $banner->url = $url;
        $banner->order_by = $request->order_by;

        if ($request->hasFile('images')) {
            $image = $request->file('images');
            $imageName = "cat_" . time() . '.' . $image->getClientOriginalExtension();
            $uploadPath = public_path('uploads/banner');

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            if (!empty($banner->images) && file_exists($uploadPath . '/' . $banner->images)) {
            unlink($uploadPath . '/' . $banner->images);
            }


            Image::read($image)->resize(850, 400)->save($uploadPath . '/' . $imageName);
            $banner->images = $imageName;
        }

        $banner->save();
        notify()->success('Banner updated successfully');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banner = Banner::find($id);
        $banner->delete();
        notify()->success('Banner deleted successfully');
        return back();
    }
}
