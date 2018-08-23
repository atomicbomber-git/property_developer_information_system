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
}
