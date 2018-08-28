<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Storage;

class StorageController extends Controller
{
    public function index()
    {
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

    public function processCreate()
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

    public function update(Storage $storage)
    {
        return view('storage.update', [
            'storage' => $storage
        ]);
    }

    public function processUpdate(Storage $storage)
    {
        $data = $this->validate(request(), [
            'name' => ['required', 'string', Rule::unique('storages')->ignore($storage->id)],
            'address' => 'required|string'
        ]);
        
        $storage->update($data);

        return redirect()
            ->route('storage.index')
            ->with('message.success', __('messages.update.success'));
    }

    public function delete(Storage $storage)
    {
        $storage->delete();

        return back()
            ->with('message.success', __('messages.delete.success'));
    }

}
