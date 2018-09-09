<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vendor;

class VendorApiController extends Controller
{
    public function index()
    {
        return Vendor::select('id', 'name')
            ->get();
    }
}
