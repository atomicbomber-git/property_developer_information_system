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
        return $this->morphMany(ItemAllocation::class, 'source');
    }

    public function total_quantity()
    {
        return $this->allocations()
            ->selectRaw('source_id, SUM(quantity) as value')
            ->groupBy('source_id');
    }

    public function getTotalQuantityAttribute($value) {
        if (!$this->relationLoaded('total_quantity'))
            $this->load('total_quantity');
            
        return $this->getRelation('total_quantity')->first()->value;
    }
}
