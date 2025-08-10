<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function product_variations()
    {
        return $this->hasMany(ProductVariation::class);
    }
    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function size()
    {
        return $this->belongsTo('App\Models\ProductSize','size_id','id');
    }

    public function color()
    {
        return $this->belongsTo('App\Models\ProductColor','color_id','id');
    }

    public function product_variation()
    {
        return $this->belongsTo(ProductVariation::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }
    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id');
    }
    }
