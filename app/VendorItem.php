<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class VendorItem extends Pivot
{
    protected $table = "vendor_items";
}
