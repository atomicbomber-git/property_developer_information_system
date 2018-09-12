<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Giro extends Model
{
    public $fillable = [
        'amount',
        'number',
        'transfered_at'
    ];

    public $dates = [
        'created_at',
        'updated_at',
        'transfered_at'
    ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function getAmount($value)
    {
        return number_format($value, 0, '', '');
    }

    public function getNumberAttribute($value)
    {
        return strtoupper($value);
    }
}
