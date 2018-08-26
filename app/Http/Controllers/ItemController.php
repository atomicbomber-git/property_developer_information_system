<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Item;
use App\Vendor;
use App\Category;

class ItemController extends Controller
{
    public function index(Category $category)
    {
        $items = Item::select('id', 'name', 'unit', 'vendor_id')
            ->where('category_id', $category->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('item.index', compact('items', 'category'));
    }

    public function create(Category $category)
    {
        $vendors = Vendor::select('id', 'name')
            ->get();

        $categories = Category::select('id', 'name')
            ->get();

        return view('item.create', compact('vendors', 'categories', 'category'));
    }

    public function processCreate(Category $category)
    {
        $vendors = Vendor::select('id')
            ->pluck('id');

        $data = $this->validate(request(), [
            'name' => 'required|string',
            'unit' => 'required|string',
            'vendor_id' => ['required', Rule::in($vendors)]
        ]);

        Item::create(array_merge($data, ['category_id' => $category->id]));

        return redirect()
            ->route('item.index', $category)
            ->with('message.success', __('messages.create.success'));
    }

    public function update(Category $category, Item $item) {
        $vendors = Vendor::select('id', 'name')
            ->get();

        return view('item.update', compact('vendors', 'item', 'category'));
    }

    public function processUpdate(Category $category, Item $item)
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
            ->route('item.index', $category)
            ->with('message.success', __('messages.update.success'));
    }

    public function delete(Category $category, Item $item)
    {
        $item->delete();
        return back()
            ->with('message.success', __('messages.delete.success'));
    }
}
