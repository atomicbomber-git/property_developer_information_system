<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::select('id', 'name')
            ->withCount('items')
            ->orderBy('name')
            ->get();

        return view('category.index', compact('categories'));
    }

    public function create()
    {
        return view('category.create');
    }

    public function processCreate()
    {
        $data = $this->validate(request(), [
            'name' => 'required|string'
        ]);

        Category::create(['name' => $data['name']]);

        return redirect()
            ->route('category.index')
            ->with('message.success', __('messages.create.success'));
    }

    public function update(Category $category)
    {
        return view('category.update', compact('category'));
    }

    public function processUpdate(Category $category)
    {
        $data = $this->validate(request(), [
            'name' => 'required|string'
        ]);

        $category->update(['name' => $data['name']]);

        return redirect()
            ->route('category.index')
            ->with('message.success', __('messages.update.success'));
    }

    public function delete(Category $category)
    {
        if ($category->items()->count() > 0)
        abort(409);

        $category->delete();
        return back()
            ->with('message.success', __('messages.delete.success'));
    }
}
