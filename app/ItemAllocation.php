<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Storage;

class ItemAllocation extends Model
{
    public $fillable = [
        'source_id',
        'source_type',
        'target_id',
        'target_type',
        'quantity'
    ];

    const morphMap = [
        'INVOICE' => \App\InvoiceItem::class,
        'STORAGE' => \App\Storage::class,
    ];

    public function storage()
    {
        return $this->belongsTo(Storage::class, 'target_id');
    }
}
