<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function ownerShip()
    {
        return $this->belongsTo(OwnerShip::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function actualPayment()
    {
        return $this->belongsTo(ActualPayment::class);
    }


}
