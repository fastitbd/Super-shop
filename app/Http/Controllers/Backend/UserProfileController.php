<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    public function index(){
        $data = User::where('id',Auth::user()->id)->first();
        return view('backend.pages.profile.index',compact('data'));
    }
    public function update(Request $request){
        $id = $request->id;
        

        if (env('APP_MODE') == 'demo') {
            notify()->error('This Feature is not available in Demo');
            return back();
        }else{
            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required',
            ]);
            $update = User::where('id',$id)->update([
                'name'=> $request->name,
                'email'=> $request->email,
                'phone'=> $request->phone,
            ]);
            if($update){
                notify()->success('User Information updated successfully!');
                return redirect()->back();
            }
        }
        
    }
    public function changePassword(Request $request){
        $id = $request->id;
        if (env('APP_MODE') == 'demo') {
            notify()->error('This Feature is not available in Demo');
            return back();
        }else{
            $request->validate([
                'password'=> 'required',
                'new_password'=>'required| same:con_password'
            ]);
            if(!Hash::check($request->password, Auth::user()->password)){
                notify()->error('Password dose not match');
                return back();
            }
            $pass = User::where('id',$id)->update([
                'password' => Hash::make($request->new_password)
            ]);
            if($pass){
                notify()->success('Successfully changed Password');
                return back();
            }else{
                notify()->error('Failed to change password');
                return back();
            }
        }
    }
}
