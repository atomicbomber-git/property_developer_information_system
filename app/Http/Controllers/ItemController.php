<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Item;
use App\Vendor;
use App\Category;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::select('id', 'name', 'unit', 'vendor_id')
            ->with('vendor:id,name')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
    
        return view('item.index', [
            'items' => $items
        ]);
    }

    public function create()
    {
        $vendors = Vendor::select('id', 'name')
            ->get();

        $categories = Category::select('id', 'name')
            ->get();

        return view('item.create', [
            'vendors' => $vendors,
            'categories' => $categories
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

        return redirect()
            ->route('item.index')
            ->with('message.success', __('messages.create.success'));
    }

    public function update(Item $item) {
        $vendors = Vendor::select('id', 'name')
            ->get();

        return view('item.update', [
            'vendors' => $vendors,
            'item' => $item
        ]);
    }

    public function processUpdate(Item $item)
    {
        $vendors = Vendor::select('id')
            ->pluck('id');
        
        $data = $this->validate(request(), [
            'name' => 'required|string',
            'unit' => 'required|string',
            'vendor_id' => ['required', Rule::in($vendors)]
        ]);

        $item->update($data);

        return redirect()
            ->route('item.index')
            ->with('message.success', __('messages.update.success'));
    }

    public function delete(Item $item)
    {
        $item->delete();
        return back()
            ->with('message.success', __('messages.delete.success'));
    }
}
