<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnTbl extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function invoice()
    {
        return $this->belongsTo('App\Models\Invoice','invoice_id','id');
    }
    // public function returnItems()
    // {
    //     return $this->belongsTo('App\Models\ReturnItem','id','return_id');
    // }
    public function customer()
    {
        return $this->belongsTo(Customer::class)->select('id', 'name', 'phone', 'email', 'address');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
