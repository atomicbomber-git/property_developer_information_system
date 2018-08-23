<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\InvoiceItemAllocation;
use App\InvoiceItem;
use App\Invoice;
use App\Vendor;
use App\Storage;
use DB;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::query()
            ->select('id', 'creator_id', 'receiver_id', 'vendor_id')
            ->with(['creator:id,name', 'receiver:id,name', 'vendor:id,name'])
            ->withCount('invoice_items')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('invoice.index', [
            'invoices' => $invoices
        ]);
    }

    public function create()
    {
        $vendors = Vendor::query()
            ->select('id', 'name')
            ->get();

        return view('invoice.create', [
            'vendors' => $vendors
        ]);
    }

    public function processCreate()
    {
        $vendor_ids = Vendor::query()
            ->select('id')
            ->pluck('id');

        $data = $this->validate(request(), [
            'vendor_id' => ['required', 'integer', Rule::in($vendor_ids)]
        ]);

        Invoice::create([
            'creator_id' => auth()->user()->id,
            'vendor_id' => $data['vendor_id']
        ]);

        return redirect()
            ->route('invoice.index')
            ->with('message.success', __('messages.create.success'));
    }

    public function update(Invoice $invoice)
    {
        if ($invoice->invoice_items()->count() > 0) {
            abort(409);
        }

        $vendors = Vendor::query()
            ->select('id', 'name')
            ->get();

        return view('invoice.update', [
            'invoice' => $invoice,
            'vendors' => $vendors
        ]);
    }

    public function processUpdate(Invoice $invoice)
    {
        $vendor_ids = Vendor::query()
            ->select('id')
            ->pluck('id');

        $data = $this->validate(request(), [
            'vendor_id' => ['required', 'integer', Rule::in($vendor_ids)]
        ]);

        $invoice->update([
            'vendor_id' => $data['vendor_id']
        ]);

        return redirect()
            ->route('invoice.index')
            ->with('message.success', __('messages.update.success'));
    }

    public function delete(Invoice $invoice)
    {
        if ($invoice->invoice_items()->count() > 0) {
            abort(409);
        }

        $invoice->delete();

        return back()
            ->with('message.success', __('messages.delete.success'));
    }

    public function detail(Invoice $invoice)
    {
        $invoice->load([
            'invoice_items' => function ($query) {
                $query->select('id', 'item_id', 'price', 'invoice_id');
                $query->has('allocations');
            },
            'invoice_items.total_quantity',
            'invoice_items.allocations:id,invoice_item_id,storage_id,quantity',
            'invoice_items.allocations.storage:id,name',
            'invoice_items.item:id,name,unit',
            'vendor:id,name',
            'vendor.items:id,name,vendor_id',
            'creator:id,name'
        ]);

        $storages = Storage::select('id', 'name')
            ->get();
        
        return view('invoice.detail', [
            'invoice' => $invoice,
            'storages' => $storages
        ]);
    }

    public function createAllocation(Invoice $invoice) {
        
        $invoice->load([
            'vendor:id,name',
            'vendor.items:id,name,vendor_id',
            'invoice_items:id,item_id,invoice_id'
        ]);

        $invoice_items = $invoice->invoice_items->keyBy('item_id');
        $allowed_item_ids = $invoice->vendor->items->pluck('id');

        $data = $this->validate(request(), [
            'item_id' => ['required', 'integer', Rule::in($allowed_item_ids)],
            'quantity' => 'required|integer|min:1',
            'storage_id' => 'required|integer'
        ]);
        
        DB::transaction(function() use($invoice, $invoice_items, $data) {
            $invoice_item = $invoice_items->get($data['item_id']);

            if (empty($invoice_item)) {
                $invoice_item = InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'item_id' => $data['item_id']
                ]);
            }

            $allocation = InvoiceItemAllocation::where([
                'invoice_item_id' => $invoice_item->id,
                'storage_id' => $data['storage_id']
            ])->first();

            if (!$allocation) {
                InvoiceItemAllocation::create([
                    'invoice_item_id' => $invoice_item->id,
                    'quantity' => $data['quantity'],
                    'storage_id' => $data['storage_id']
                ]);
                return;
            }

            $allocation->update([
                'quantity' => $allocation->quantity + $data['quantity'],
            ]);
        });

        return back()
            ->with('message.success', __('messages.create.success'));
    }

    public function deleteAllocation(Invoice $invoice, InvoiceItemAllocation $allocation)
    {
        $allocation->delete();
        return back()
            ->with('message.success', __('messages.delete.success'));
    }
}
