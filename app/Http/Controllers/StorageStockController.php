<?php

namespace App\Http\Controllers;

use App\Storage;

class StorageStockController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index(Storage $storage)
    {
        return $storage;
    }
}
