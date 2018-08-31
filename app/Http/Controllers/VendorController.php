<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vendor;
use App\VendorContactPerson;
use DB;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::query()
            ->withCount('items', 'contact_people')
            ->with('contact_people:vendor_id,name,phone')
            ->get();

        return view('vendor.index', compact('vendors'));
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
            'contact_people' => 'required|array',
            'contact_people.*.name' => 'required|string',
            'contact_people.*.phone' => 'required|string',
        ]);

        DB::transaction(function() use($data) {
            $vendor = Vendor::create([
                'name' => $data['name'],
                'address' => $data['address']
            ]);

            foreach ($data['contact_people'] as $contact_person) {
                $vendor->contact_people()
                    ->save(new VendorContactPerson($contact_person));
            }
        });

        return redirect()
            ->route('vendor.index')
            ->with('message.success', __('messages.create.success'));
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
                $query->select('id', 'source_id', 'source_type', 'target_id', 'target_type');
                $query->where('source_type', 'VENDOR');
                $query->has('delivery_order_items');
                $query->whereNull('invoice_id');
            },
            'delivery_orders.target:id,name',
            'delivery_orders.delivery_order_items:delivery_order_id,item_id,quantity',
            'delivery_orders.delivery_order_items.item:id,name,unit',
        ]);

        return $vendor->delivery_orders;
    }

    public function item(Vendor $vendor)
    {
        $vendor->load('items:id,name,vendor_id');
        return $vendor->items;
    }
}
