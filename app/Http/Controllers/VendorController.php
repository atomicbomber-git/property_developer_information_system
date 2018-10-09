<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Vendor;
use App\VendorContactPerson;
use App\DeliveryOrder;
use DB;
use Validator;

class VendorController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return Vendor::select('id', 'name')->orderBy(DB::raw('LOWER(name)'))->get();
        }

        $vendors = Vendor::query()
            ->withCount('items', 'contact_people')
            ->with('contact_people:vendor_id,name,phone')
            ->orderBy('name')
            ->get();
        
        return view('vendor.index', compact('vendors'));
    }

    public function create()
    {
        return view('vendor.create');
    }

    public function processCreate()
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required|string',
            'code' => 'required|string',
            'address' => 'nullable|string',
            'contact_people' => 'nullable|array'
        ]);

        $validator->sometimes('contact_people.*.name', 'required|string', function ($input) {
            return filled($input->contact_people);
        });

        $validator->sometimes('contact_people.*.phone', 'required|string', function ($input) {
            return filled($input->contact_people);
        });

        $data = $validator->validate();

        DB::transaction(function() use($data) {
            $vendor = Vendor::create([
                'name' => $data['name'],
                'address' => $data['address'],
                'code' => $data['code']
            ]);

            foreach ($data['contact_people'] as $contact_person) {
                $vendor->contact_people()
                    ->save(new VendorContactPerson($contact_person));
            }
        });

        session()->flash('message.success', __('messages.create.success'));

        return [
            'status' => 'success',
            'redirect' => route('vendor.index')
        ];
    }

    public function update(Vendor $vendor)
    {
        $vendor->load('contact_people:id,vendor_id,name,phone');
        return view('vendor.update', [
            'vendor' => $vendor
        ]);
    }

    public function transactionHistory(Vendor $vendor)
    {
        $invoices = DB::table('vendors')
            ->select('invoice_id AS id', 'invoices.received_at', 'invoices.number')
            ->join('delivery_orders', function ($join) {
                $join
                    ->on('source_id', '=', 'vendors.id')
                    ->where('source_type', 'VENDOR')
                    ->whereNotNull('invoice_id');
            })
            ->join('invoices', 'invoices.id', '=', 'invoice_id')
            ->groupBy('invoice_id', 'invoices.received_at', 'invoices.number')
            ->orderBy('invoices.received_at', 'DESC')
            ->where('vendors.id', $vendor->id)
            ->paginate(10);

        return view('vendor.transaction_history', compact('invoices', 'vendor'));
    }

    public function processUpdate(Vendor $vendor)
    {
        $data = $this->validate(request(), [
            'name' => 'required|string',
            'address' => 'nullable|string',
            'code' => 'nullable|string'
        ]);

        $vendor->update($data);
        
        return redirect()
            ->back()
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
                $query->select('id', 'source_id', 'source_type', 'target_id', 'target_type', 'received_at');
                $query->where('source_type', 'VENDOR');
                $query->has('delivery_order_items');
                $query->whereNull('invoice_id');
            },
            'delivery_orders.target:id,name,received_at',
            'delivery_orders.delivery_order_items:delivery_order_id,item_id,quantity',
            'delivery_orders.delivery_order_items.item:id,name,unit',
        ]);

        return $vendor->delivery_orders;
    }

    public function item(Vendor $vendor)
    {
        return Item::query()
            ->select('id', 'name', 'vendor_id', 'unit')
            ->where('vendor_id', $vendor->id)
            ->orderBy(DB::raw('LOWER(name)'))
            ->get();
    }

    public function unbilled() {
        return Vendor::query()
            ->select('id', 'name')
            ->whereHas('delivery_orders', function ($query) {
                $query->whereNull('invoice_id');
            })
            ->get();
    }
}
