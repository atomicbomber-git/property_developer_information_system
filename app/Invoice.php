<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public $fillable = [
        'received_at',
        'transfered_at',
        'cash_amount',
        'number'
    ];

    public $dates = [
        'received_at',
        'transfered_at'
    ];

    public function getPaymentMethodAttribute()
    {
        if (!$this->cash_amount == NULL)
            return 'cash';
        
        if (!$this->giro_id == NULL)
            return 'giro';

        return 'unpaid';
    }

    public function giro()
    {
        return $this->belongsTo(Giro::class);
    }

    public function delivery_orders()
    {
        return $this->hasMany(DeliveryOrder::class);
    }

    public function getCashAmountAttribute($value)
    {
        return number_format($value, 0, '', '');
    }
}
