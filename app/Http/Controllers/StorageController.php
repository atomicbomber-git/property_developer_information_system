<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Storage;
use DB;

class StorageController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index()
    {
        if (request()->ajax())
            return Storage::select('id', 'name')->orderBy('name')->get();

        $storages = Storage::query()
            ->select('id', 'name', 'address')
            ->withCount('inbound_delivery_orders')
            ->withCount('outbound_delivery_orders')
            ->get()
            ->map(function ($storage) {
                $storage->delivery_orders_count =
                    $storage->inbound_delivery_orders_count +
                    $storage->outbound_delivery_orders_count;
                return $storage;
            });

        return view('storage.index', [
            'storages' => $storages
        ]);
    }

    public function create()
    {
        return view('storage.create');
    }

    public function store()
    {
        $data = $this->validate(request(), [
            'name' => 'required|string|unique:storages',
            'address' => 'required|string'
        ]);

        Storage::create($data);

        return redirect()
            ->route('storage.index')
            ->with('message.success', __('messages.create.success'));
    }

    public function edit(Storage $storage)
    {
        return view('storage.edit', compact('storage'));
    }

    public function update(Storage $storage)
    {
        $data = $this->validate(request(), [
            'name' => ['required', 'string', Rule::unique('storages')->ignore($storage->id)],
            'address' => 'required|string'
        ]);

        $storage->update($data);

        return redirect()
            ->route('storage.edit', $storage)
            ->with('message.success', __('messages.update.success'));
    }

    public function delete(Storage $storage)
    {
        $storage->delete();

        return back()
            ->with('message.success', __('messages.delete.success'));
    }
}
