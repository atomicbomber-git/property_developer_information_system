<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemTransfer extends Model
{
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function scopePertaining($query, $type, $id)
    {
        return $query
            ->where(function($where_query) use($type, $id) {
                $where_query
                    ->where('source_type', $type)
                    ->where('source_id', $id)
                    ->where('quantity', '<', 0);
            })
            ->orWhere(function($where_query) use($type, $id) {
                $where_query
                    ->where('target_type', $type)
                    ->where('target_id', $id)
                    ->where('quantity', '>', 0);
            });
    }
}
