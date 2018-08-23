<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    public $fillable = [
        'name',
        'address',
        'contact_person',
        'contact_person_phone'
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
