<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    public $fillable = [
        'invoice_id',
        'item_id',
        'price',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function allocations()
    {
        return $this->hasMany(InvoiceItemAllocation::class);
    }

    public function total_quantity()
    {
        return $this->allocations()
            ->selectRaw('invoice_item_id, SUM(quantity) as value')
            ->groupBy('invoice_item_id');
    }

    public function getTotalQuantityAttribute($value) {
        if (!$this->relationLoaded('total_quantity'))
            $this->load('total_quantity');
            
        return $this->getRelation('total_quantity')->first()->value;
    }
}
