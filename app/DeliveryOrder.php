<?php

namespace App;

use App\Traits\CanCountRelatedModels;
use Illuminate\Database\Eloquent\Model;

class DeliveryOrder extends Model
{
    use CanCountRelatedModels;

    public $fillable = [
        'receiver_id',
        'source_type',
        'source_id',
        'target_type',
        'target_id',
        'received_at',
        'sender_id',
        'sent_at',
        'driver_id',
    ];

    public $dates = [
        'created_at',
        'updated_at',
        'received_at',
        'sent_at',
    ];

    public static function countedRelations()
    {
        return [
            "invoice"
        ];
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id')
            ->withDefault([
                "name" => "-",
            ]);
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id')
            ->withDefault([
                "name" => "-",
            ]);
    }

    public function driver()
    {
        return $this->belongsTo(User::class, "driver_id")
            ->withDefault([
                "name" => "-",
            ]);
    }

    public function delivery_order_items()
    {
        return $this->hasMany(DeliveryOrderItem::class);
    }

    public function delivery_order_items_with_price()
    {
        return $this->delivery_order_items()
            ->whereNotNull("price");
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
        return $query->where('source_id', $vendor_id)
            ->where('source_type', 'VENDOR');
    }
}
