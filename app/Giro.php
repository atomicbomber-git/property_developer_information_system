<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Giro extends Model
{
    public $fillable = [
        'amount',
        'number',
        'paid_at',
        'made_at',
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
}
