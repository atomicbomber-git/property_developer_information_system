<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Invoice;
use App\Vendor;

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

}
