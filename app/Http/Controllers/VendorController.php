<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vendor;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::query()
            ->withCount('items')
            ->get();

        return view('vendor.index', [
            'vendors' => $vendors
        ]);
    }

    public function create()
    {
        return view('vendor.create');
    }

    public function processCreate()
    {
        $data = $this->validate(request(), [
            'name' => 'required|string',
            'address' => 'nullable|string',
            'contact_person' => 'nullable|string',
            'contact_person_phone' => 'nullable|string'
        ]);

        Vendor::create($data);

        return redirect()
            ->route('vendor.index')
            ->with('message.success', 'Data berhasil ditambahkan.');
    }

    public function update(Vendor $vendor)
    {
        return view('vendor.update', [
            'vendor' => $vendor
        ]);
    }

    public function processUpdate(Vendor $vendor)
    {
        $data = $this->validate(request(), [
            'name' => 'required|string',
            'address' => 'nullable|string',
            'contact_person' => 'nullable|string',
            'contact_person_phone' => 'nullable|string'
        ]);

        $vendor->update($data);
        
        return redirect()
            ->route('vendor.index')
            ->with('message.success', 'Data berhasil diperbarui.');
    }

    public function delete(Vendor $vendor)
    {
        if ($vendor->items()->count() > 0) {
            abort(409);
        } 

        $vendor->delete();
        return back()
            ->with('message.success', 'Data berhasil dihapus.');
    }

    public function unbilledDeliveryOrders(Vendor $vendor)
    {
        $vendor->load([
            'delivery_orders' => function ($query) {
                $query->select('id', 'source_id', 'source_type');
                $query->has('delivery_order_items');
                $query->whereNull('invoice_id');
            },
            'delivery_orders.delivery_order_items:delivery_order_id,item_id,quantity',
            'delivery_orders.delivery_order_items.item:id,name',
        ]);

        return $vendor->delivery_orders;
    }
}
