<?php

namespace App\Http\Controllers;

use App\Storage;
use Illuminate\Http\Request;

class StorageStockAdjustmentController extends Controller
{
    public function create(Request $request, Storage $storage)
    {
        return $storage;
    }
}
