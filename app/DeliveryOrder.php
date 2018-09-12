<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryOrder extends Model
{
    public $fillable = [
        'receiver_id',
        'source_type',
        'source_id',
        'target_type',
        'target_id',
        'received_at'
    ];

    public $dates = [
        'created_at',
        'updated_at',
        'received_at'
    ];

    protected $casts = [
        'received_at' => 'datetime:d-m-Y'
    ];

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function delivery_order_items()
    {
        return $this->hasMany(DeliveryOrderItem::class);
    }

    public function source()
    {
        return $this->morphTo();
    }

    public function target()
    {
        return $this->morphTo();
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function scopeIsFromVendor($query, $vendor_id)
    {
        return $query
            ->where('source_id', $vendor_id)
            ->where('source_type', 'VENDOR');
    }

    public function scopeInternal($query)
    {
        return $query
            ->where('source_type', 'STORAGE')
            ->where('target_type', 'STORAGE');
    }
}
