<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Item;
use App\Vendor;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();

        return view('item.index', [
            'items' => $items
        ]);
    }

    public function create()
    {
        $vendors = Vendor::select('id', 'name')
            ->get();

        return view('item.create', [
            'vendors' => $vendors
        ]);
    }

    public function processCreate()
    {
        $vendors = Vendor::select('id')
            ->pluck('id');

        $data = $this->validate(request(), [
            'name' => 'required|string',
            'unit' => 'required|string',
            'vendor_id' => ['required', Rule::in($vendors)]
        ]);

        Item::create($data);
    }
}
