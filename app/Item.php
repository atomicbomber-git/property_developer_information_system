<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public $fillable = [
        'vendor_id',
        'name',
        'unit'
    ];

    public function vendor()
    {
        return $this->belongsTo(\App\Vendor::class);
    }
}
