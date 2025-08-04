<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnItem extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function return()
    {
        return $this->belongsTo(ReturnTbl::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class)->select('id', 'name', 'phone', 'email', 'address');
    }

    //created by
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by')->select('id', 'name');
    }
}
