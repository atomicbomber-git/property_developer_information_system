<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Storage;

class ItemAllocation extends Model
{
    public $fillable = [
        'invoice_item_id',
        'storage_id',
        'quantity'
    ];

    public function storage()
    {
        return $this->belongsTo(Storage::class);
    }
}
