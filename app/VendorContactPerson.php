<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorContactPerson extends Model
{
    public $fillable = [
        'vendor_id',
        'name',
        'phone'
    ];
}
