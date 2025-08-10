<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\BusinessSetting;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\ProductVariation;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\Variation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Image;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if (env('APP_SC') == 'yes') {

            $data['products'] = Product::with(['brand', 'category', 'unit.related_unit'])
                ->orderBy('created_at', 'DESC')
                ->paginate(10);
            $data['product_id'] = $request->product_id;
            $data['category_id'] = $request->category_id;
            $data['barcode'] = $request->barcode;
            $data['com'] = BusinessSetting::where('id', 6)->first();
            $data['vat'] = BusinessSetting::where('id', 11)->first();

            if ($request->product_id != null) {
                $data['products'] = Product::with(['brand', 'category', 'unit.related_unit'])
                    ->where('id', $request->product_id)
                    ->paginate(10);
            }
            if ($request->barcode != null) {
                $data['products'] = Product::with(['brand', 'category', 'unit.related_unit'])
                    ->where('barcode', $request->barcode)
                    ->paginate(10);
            }
            if ($request->category_id != null) {
                $data['products'] = Product::with(['brand', 'category', 'unit.related_unit'])
                    ->where('category_id', $request->category_id)
                    ->paginate(10);
            }
            if ($request->category_id != null && $request->product_id != null) {
                $data['products'] = Product::with(['brand', 'category', 'unit.related_unit'])
                    ->where('category_id', $request->category_id)->where('id', $request->product_id)
                    ->paginate(10);
            }

            return view('backend.pages.product.sc-index', $data);
        } else {
            $data['products'] = Product::with(['brand', 'category', 'unit.related_unit'])->where('is_service', 0)
                ->orderBy('created_at', 'DESC')->paginate(10);
            $data['product_id'] = $request->product_id;
            $data['category_id'] = $request->category_id;
            $data['barcode'] = $request->barcode;
            $data['com'] = BusinessSetting::where('id', 6)->first();
            $data['vat'] = BusinessSetting::where('id', 11)->first();

            if ($request->product_id != null) {
                $data['products'] = Product::with(['brand', 'category', 'unit.related_unit'])->where('is_service', 0)
                    ->where('id', $request->product_id)
                    ->orderBy('created_at', 'DESC')
                    ->paginate(10)->appends([
                        'product_id' => $request->product_id,
                    ]);
            }
            if ($request->barcode != null) {
                $data['products'] = Product::with(['brand', 'category', 'unit.related_unit'])->where('is_service', 0)
                    ->where('barcode', $request->barcode)
                    ->orderBy('created_at', 'DESC')
                    ->paginate(10);
            }
            if ($request->category_id != null) {
                $data['products'] = Product::with(['brand', 'category', 'unit.related_unit'])->where('is_service', 0)
                    ->where('category_id', $request->category_id)
                    ->orderBy('created_at', 'DESC')
                    ->paginate(30)
                    ->appends([
                        'category_id' => $request->category_id,
                    ]);
            }
            if ($request->category_id != null && $request->product_id != null) {
                $data['products'] = Product::with(['brand', 'category', 'unit.related_unit'])->where('is_service', 0)
                    ->where('category_id', $request->category_id)->where('id', $request->product_id)
                    ->orderBy('created_at', 'DESC')
                    ->paginate(10)
                    ->appends([
                        'category_id' => $request->category_id,
                        'product_id' => $request->product_id,
                    ]);
            }

            return view('backend.pages.product.index', $data);
        }
    }

    public function create()
    {

        $brands = Brand::all();
        $categories = Category::all();
        $units = Unit::all();
        $variations = Variation::all();
        $sizes = ProductSize::all();
        $colors = ProductColor::all();
        $suppliers = Supplier::all();
        return view('backend.pages.product.create', compact('brands', 'sizes', 'colors', 'variations', 'categories', 'units', 'suppliers'));
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate(
            [
                'name' => 'required|unique:products',
                'barcode' => 'unique:products',
                'category_id' => 'required',
                'unit_id' => 'required',
                'purchase_price' => 'required',
                'selling_price' => 'required',
                'status' => 'required',
            ],
            [
                'name.unique' => 'The product name has already been taken !',
                'barcode.unique' => 'The product barcode has already been taken !',
            ]
        );

        $slug = 'P' . Str::upper(Str::random(10));

        $product = new Product();
        $product->name = $request->name;
        $product->date = date('Y-m-d');
        $numberBarcode = rand(000000, 999999);
        if ($request->barcode == NULL) {
            $product->barcode = $numberBarcode;
        } else {
            $product->barcode = $request->barcode;
        }
        $product->is_service = 0;
        $product->category_id = $request->category_id;
        $product->subcategory_id = $request->subcategory_id;
        $product->brand_id = $request->brand_id;
        $product->weight = $request->weight;
        $product->unit_id = $request->unit_id;
        $product->main_qty = $request->main_qty;
        $product->has_serial = $request->has_serial;
        $product->sub_qty = $request->sub_qty;
        $product->purchase_price = $request->purchase_price;
        $product->after_discount_price = $request->after_discount_price;
        $product->selling_price = $request->selling_price;
        $product->discount = $request->discount;
        $product->status = $request->status;
        $product->description = $request->description;
        $product->slug = $slug;
        $product->created_by = Auth::user()->id;

        if ($product->save()) {
            if ($request->size != null || $request->color != null) {
                $sizes = $request->size ?? [null];
                $colors = $request->color ?? [null];
                foreach ($sizes as $size) {
                    foreach ($colors as $color) {
                        $product->product_variations()->create([
                            'product_id' => $product->id,
                            'size_id' => $size,
                            'color_id' => $color,
                        ]);
                    }
                }
            }
        }

           if ($request->hasFile('images')) {
            $image = $request->file('images');
            $imageName = "pro_" . time() . '.' . $image->getClientOriginalExtension();

            $uploadPath = public_path('uploads/products');

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            Image::read($image)->resize(150, 180)->save($uploadPath . '/' . $imageName);
            $product->images = $imageName;
        }
        $product->save();
        // if($request->main_qty != null || $request->main_qty != null && $request->sub_qty != null){
        //     $this->open_stock_purchase($request, $product->id);
        // }
        notify()->success('Product created successfully!');
        return Redirect()->route('product.index');
    }

    public function edit(string $id)
    {
        $data['brands'] = Brand::all();
        $data['categories'] = Category::all();
        $data['sizes'] = ProductSize::all();
        $data['colors'] = ProductColor::all();
        $data['units'] = Unit::all();
        $selectedVariations = ProductVariation::where('product_id', $id)->get();
        $data['selectedColorIds'] = $selectedVariations->pluck('color_id')->unique()->toArray();
        $data['selectedSizeIds'] = $selectedVariations->pluck('size_id')->unique()->toArray();
        $data['data'] = Product::with(['brand', 'category', 'unit.related_unit'])->where('id', $id)->first();
        return view('backend.pages.product.edit', $data);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'barcode' => 'numeric',
            'category_id' => 'required',
            'purchase_price' => 'required',
            'selling_price' => 'required',
            'status' => 'required',
        ]);

        $slug = 'P' . Str::upper(Str::random(10));

        $product = Product::findorfail($id);
        $product->name = $request->name;
        $numberBarcode = rand(000000, 999999);
        if ($product->barcode == NULL) {
            $product->barcode = $numberBarcode;
        } else {
            $product->barcode = $request->barcode;
        }
        $product->category_id = $request->category_id;
        $product->subcategory_id = $request->subcategory_id;
        $product->brand_id = $request->brand_id;
        $product->weight = $request->weight;
        $product->unit_id = $request->unit_id;
        $product->main_qty = $request->main_qty;
        $product->sub_qty = $request->sub_qty;
        $product->purchase_price = $request->purchase_price;
        $product->selling_price = $request->selling_price;
        $product->selling_price = $request->selling_price;
        $product->discount = $request->discount;
        $product->status = $request->status;
        $product->description = $request->description;
        $product->slug = $slug;

        if ($product->save()) {
            $existingVariations = ProductVariation::where('product_id', $product->id)->get();

            $newCombinations = collect([]);
            $sizes = $request->size ?? [null];
            $colors = $request->color ?? [null];

            foreach ($sizes as $size) {
                foreach ($colors as $color) {
                    $newCombinations->push(['size_id' => $size, 'color_id' => $color]);
                }
            }

            // Mark existing as matched or to be deleted
            $existingVariations->each(function ($variation) use ($newCombinations) {
                $exists = $newCombinations->contains(function ($combo) use ($variation) {
                    return $combo['size_id'] == $variation->size_id && $combo['color_id'] == $variation->color_id;
                });

                if (!$exists) {
                    $variation->delete(); // Remove unmatched variation
                }
            });

            // Insert missing combinations
            foreach ($newCombinations as $combo) {
                $exists = $existingVariations->contains(function ($variation) use ($combo) {
                    return $variation->size_id == $combo['size_id'] && $variation->color_id == $combo['color_id'];
                });

                if (!$exists) {
                    $product->product_variations()->create([
                        'product_id' => $product->id,
                        'size_id' => $combo['size_id'],
                        'color_id' => $combo['color_id'],
                    ]);
                }
            } 
        }


        if ($request->hasFile('images')) {
            $image = $request->file('images');
            $imageName = "pro_" . time() . '.' . $image->getClientOriginalExtension();
            $uploadPath = public_path('uploads/products');

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            if (!empty($product->images) && file_exists($uploadPath . '/' . $product->images)) {
            unlink($uploadPath . '/' . $product->images);
            }


            Image::read($image)->resize(150, 180)->save($uploadPath . '/' . $imageName);
            $product->images = $imageName;
        }

        $product->save();
        notify()->success('Product updated successfully');
        return Redirect()->route('product.index');
    }

    public function destroy(string $id)
    {
        $product = Product::findorfail($id);
        if (file_exists('public/uploads/products/' . $product->images) and !empty($product->images)) {
            unlink('public/uploads/products/' . $product->images);
        }
        $product->delete();
        notify()->success('Successfully Product Delete!');
        return back();
    }

    public function search(Request $request)
    {
        $data['product_id'] = $request->product_id;
        $data['category_id'] = $request->category_id;

        if ($request->product_id != null) {
            $data['products'] = Product::with(['brand', 'category', 'unit.related_unit'])
                ->where('id', $request->product_id)
                ->paginate(10);
        }
        if ($request->category_id != null) {
            $data['products'] = Product::with(['brand', 'category', 'unit.related_unit'])
                ->where('category_id', $request->category_id)
                ->paginate(10);
        }
        return view('backend.pages.product.index', $data);
    }
}
