<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public $fillable = [
        'creator_id',
        'receiver_id',
        'vendor_id',
        'received_at',
        'payment_type',
        'payment_id'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function invoice_items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
