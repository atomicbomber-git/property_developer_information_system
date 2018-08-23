<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public $fillable = [
        'category_id',
        'vendor_id',
        'name',
        'unit'
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
