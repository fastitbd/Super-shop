<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessSetting;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Artisan;

class BusinessSettingsController extends Controller
{
    public function index()
    {
        return view('backend.pages.setting');
    }

    public function update(Request $request)
    {
        foreach ($request->types as $key => $type) {
            $business_settings = BusinessSetting::where('type', $type)->first();
            if ($business_settings != null) {
                $business_settings->value = $request[$type];
            } else {
                $business_settings = new BusinessSetting;
                $business_settings->type = $type;
                $business_settings->value = $request[$type];
            }
            $business_settings->save();
        }
    
        // Handle System Icon Upload
        if ($request->hasFile('system_icon')) {
            $this->uploadAndResizeImage($request->file('system_icon'), 'system_icon', 556, 244);
        }
    
        // Handle System Logo Upload
        if ($request->hasFile('system_logo')) {
            $this->uploadAndResizeImage($request->file('system_logo'), 'system_logo', 556, 244);
        }
    
        // Clear cache
        Artisan::call('cache:clear');
    
        notify()->success('Successfully System Settings Updated!');
        return redirect()->back();
    }
    
    /**
     * Upload and resize an image using Intervention Image v2
     */
    private function uploadAndResizeImage($image, $type, $width, $height)
    {
        $business_settings = BusinessSetting::where('type', $type)->first();
        $imgName = date('YmdHi') . '.' . $image->getClientOriginalExtension();
    
        $destinationPath = public_path('uploads/logo/');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }
    
        // Resize and save image
        $resizedImage = Image::make($image->getRealPath());
        $resizedImage->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio(); // Maintain aspect ratio
            $constraint->upsize(); // Prevent upsizing
        })->save($destinationPath . $imgName);
    
        // Delete old image if exists
        if ($business_settings && file_exists($destinationPath . $business_settings->value) && !empty($business_settings->value)) {
            unlink($destinationPath . $business_settings->value);
        }
    
        // Save new image name to database
        if ($business_settings) {
            $business_settings->value = $imgName;
            $business_settings->save();
        } else {
            BusinessSetting::create([
                'type' => $type,
                'value' => $imgName
            ]);
        }
    }
}
