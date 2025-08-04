<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Damage;
use App\Models\DamageItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class DamageController extends Controller
{ 
    public function index(Request $request)
    {
        $data['damages'] = Damage::with('damageItems')->where('status', 1)->get();
        $data['products'] = Product::orderBy('created_at', 'asc')->get();
        
        if ($request->product_id != null) {
            $data['damages'] = Damage::with(['damageItems' => function($query) use ($request) {
                $query->where('product_id', $request->product_id);
            }])
            ->whereHas('damageItems', function($query) use ($request) {
                $query->where('product_id', $request->product_id);
            })
            ->orderBy('created_at', 'asc')
            ->get();
        }
        

        if ($request->date != NULL) {
            $data['sdate'] = Carbon::createFromDate($request->start_date)->toDateString();
            $data['edate'] = Carbon::createFromDate($request->end_date)->toDateString();
            $sdate = $data['sdate'];
            $edate = $data['edate'];
            $damages = Damage::orderBy('created_at', 'DESC')->whereBetween('date', [$sdate, $edate]); 
            $data['damages'] = $damages->get();
        }
        
        return view('backend.pages.damage.index',$data);
    }
    

    public function create()
    {
        $products = Product::orderBy('id', 'DESC')->get();
        if (env('APP_SC') == 'yes') {
            return view('backend.pages.damage.sc-create',compact('products'));
        }else{
            return view('backend.pages.damage.create',compact('products'));
        }
    }
    public function insert(Request $request){
        // dd($request->all());
        $request->validate([
            'date' => 'required',
            'product_id' => 'required',
            'main_qty' => 'required',
        ]);

        $damage = new Damage();
        $damage->date = $request->date;
        $damage->total_amount = $request->payable_amount;
        DB::transaction(function () use ($request, $damage) {
            if ($damage->save()) {
                foreach($request->product_id as $key => $product){
                    $damageItem = new DamageItem();
                    $damageItem->date = $request->date;
                    $damageItem->damage_id = $damage->id;
                    $damageItem->product_id = $product;
                    $damageItem->product_variation_id = $request->variation[$key] ?? null;
                    $damageItem->main_qty = $request->main_qty[$key];
                    $damageItem->sub_qty = $request->sub_qty[$key] ?? 0;
                    $damageItem->rate = $request->rate[$key];
                    $damageItem->subtotal = $request->sub_total[$key];
                    calculateUnitPriceUsingFIFO($product,$request->main_qty[$key]);
                    $damageItem->save();
                }
            }
        });
        notify()->success('Damage Created Successfully');
        return redirect()->route('damage.index');
    }

    public function softDelete($id){
        $damage = Damage::find($id);
        
        $damageItem = DamageItem::where('damage_id',$id)->get();
        foreach($damageItem as $item){
            $item->delete();
        }
        $damage->delete();
        notify()->success('Damage deleted successfully');
        return back();
        
    }
}




