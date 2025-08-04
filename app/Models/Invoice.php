<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
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
