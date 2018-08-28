<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Giro extends Model
{
    public $fillable = ['amount', 'number', 'paid_at'];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
