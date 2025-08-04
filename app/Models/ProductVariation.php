<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasFactory;

    protected $fillable = ['size_id', 'color_id','product_id', 'variation_id'];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function size()
    {
        return $this->belongsTo('App\Models\ProductSize','size_id','id');
        // return $this->belongsTo(ProductSize::class);
    }

    public function color()
    {
        return $this->belongsTo('App\Models\ProductColor','color_id','id');
        // return $this->belongsTo(ProductColor::class);
    }
}
