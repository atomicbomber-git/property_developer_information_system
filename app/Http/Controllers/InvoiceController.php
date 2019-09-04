<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Invoice;
use App\DeliveryOrder;
use App\DeliveryOrderItem;
use App\Vendor;
use App\Giro;
use DB;
use URL;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::select('id', 'cash_amount', 'giro_id', 'received_at', 'transfered_at', 'number')
            ->with([
                'delivery_orders' => function ($query) { $query->select('invoice_id', 'source_id', 'source_type'); },
                'delivery_orders.source',
                'giro:id,amount,number,transfered_at'
            ])
            ->orderBy(DB::raw('giro_id IS NOT NULL OR cash_amount IS NOT NULL'))
            ->orderBy('received_at', 'desc')
            ->paginate(10);

        $invoices->transform(function($invoice) {
            $code = optional(optional($invoice->delivery_orders->first())->source)->code;
            $invoice->code = $code ? $code . '-' . $invoice->id : null;
            return $invoice;
        });

        return view('invoice.index', compact('invoices'));
    }

    public function create()
    {
        $vendors = Vendor::select('id', 'name')
            ->get();

        return view('invoice.create', compact('vendors'));
    }

    public function processCreate()
    {
        $vendor_ids = Vendor::select('id')
            ->pluck('id');

        $temp = $this->validate(request(), [
            'vendor_id' => ['required', Rule::in($vendor_ids)],
            'received_at' => ['required', 'date'],
            'number' => ['nullable', 'string']
        ]);

        $delivery_order_ids = DeliveryOrder::select('id')
            ->where([
                'source_id' => $temp['vendor_id'],
                'source_type' => 'VENDOR',
                'invoice_id' => NULL,
            ])
            ->has('delivery_order_items')
            ->pluck('id');

        $data = $this->validate(request(), [
            'delivery_orders' => ['required', 'array'],
            'delivery_orders.*' => [Rule::in($delivery_order_ids)]
        ]);

        DB::transaction(function () use($temp, $data) {
            $invoice = Invoice::create([
                'number' => $temp['number'],
                'received_at' => $temp['received_at']
            ]);

            DeliveryOrder::whereIn('id', $data['delivery_orders'])
                ->update(['invoice_id' => $invoice->id]);
        });

        session()->flash('message.success', __('messages.create.success'));

        return [
            'status' => 'success',
            'redirect' => route('invoice.index')
        ];
    }

    public function update(Invoice $invoice)
    {
        $vendors = Vendor::query()
            ->select('id', 'name')
            ->whereHas('delivery_orders', function ($query) {
                $query->whereNull('invoice_id');
            })
            ->get();

        $invoice->load([
            'delivery_orders:id,invoice_id,target_id,target_type,received_at',
            'delivery_orders.target:id,name',
            'delivery_orders.delivery_order_items:delivery_order_id,item_id,quantity',
            'delivery_orders.delivery_order_items.item:id,name,unit'
        ]);

        $current_vendor_id = $invoice
            ->delivery_orders()
            ->limit(1)
            ->value('source_id');

        return view('invoice.update', compact('invoice', 'vendors', 'current_vendor_id'));
    }

    public function processUpdate(Invoice $invoice)
    {
        $data = $this->validate(request(), [
            'received_at' => ['required', 'date'],
            'number' => ['nullable', 'string']
        ]);

        $invoice->update($data);

        return back()
            ->with('message.success', 'messages.update.success');
    }

    public function processAttachDeliveryOrder(Invoice $invoice)
    {
        $vendor_ids = Vendor::select('id')
            ->pluck('id');

        $temp = $this->validate(request(), [
            'vendor_id' => ['required', Rule::in($vendor_ids)]
        ]);

        $delivery_order_ids = DeliveryOrder::select('id')
            ->where([
                'source_id' => $temp['vendor_id'],
                'source_type' => 'VENDOR',
                'invoice_id' => NULL,
            ])
            ->has('delivery_order_items')
            ->pluck('id');

        $data = $this->validate(request(), [
            'delivery_orders' => ['required', 'array'],
            'delivery_orders.*' => [Rule::in($delivery_order_ids)]
        ]);

        DeliveryOrder::whereIn('id', $data['delivery_orders'])
            ->update(['invoice_id' => $invoice->id]);

        return back()
            ->with('message.success', __('messages.create.success'));
    }

    public function processRemoveDeliveryOrder(Invoice $invoice)
    {
        $invoice->load('delivery_orders:id,invoice_id');

        $data = $this->validate(request(), [
            'delivery_order_id' => ['required', Rule::in($invoice->delivery_orders->pluck('id'))]
        ]);

        DeliveryOrder::where('id', $data['delivery_order_id'])
            ->update(['invoice_id' => null]);

        return back()
            ->with('message.success', __('messages.delete.success'));
    }

    public function pay(Invoice $invoice)
    {
        $invoice->load('giro:id,number');

        $vendor = $invoice->delivery_orders()
            ->with('source')
            ->select('source_id', 'source_type')
            ->distinct()
            ->value('source');

        $delivery_orders = DeliveryOrderItem::query()
            ->select(
                'delivery_orders.id', 'delivery_orders.received_at', DB::raw('SUM(price * quantity) AS subtotal'),
                'source.name AS source_name', 'target.name AS target_name', 'target_id'
            )
            ->join('delivery_orders', 'delivery_orders.id', '=', 'delivery_order_items.delivery_order_id')
            ->join("vendors AS source", 'delivery_orders.source_id', '=', 'source.id')
            ->join("storages AS target", 'delivery_orders.target_id', '=', 'target.id')
            ->join('items', 'items.id', '=', 'delivery_order_items.item_id')
            ->where('delivery_orders.invoice_id', $invoice->id)
            ->groupBy('delivery_orders.id', 'source_name', 'target_name', 'target_id')
            ->get()
            ->keyBy('id');

        // return $delivery_orders;

        $detailed_delivery_orders = DB::table('delivery_order_items')
            ->select('delivery_orders.id', 'delivery_orders.received_at', 'quantity', 'price', 'delivery_order_id', 'name')
            ->join('items', 'items.id', '=', 'delivery_order_items.item_id')
            ->join('delivery_orders', 'delivery_orders.id', '=', 'delivery_order_items.delivery_order_id')

            ->where('invoice_id', $invoice->id)
            ->get()
            ->transform(function($record) {
                $record->subtotal = $record->price * $record->quantity;
                return $record;
            })
            ->groupBy('delivery_order_id');

        // return $delivery_order_items;

        return view('invoice.pay', compact('invoice', 'delivery_orders', 'vendor', 'detailed_delivery_orders'));
    }

    public function processPay(Invoice $invoice)
    {
        $cash_amount = DeliveryOrderItem::query()
            ->select(DB::raw('SUM(price * quantity) AS total'))
            ->join('delivery_orders', 'delivery_orders.id', '=', 'delivery_order_items.delivery_order_id')
            ->join('items', 'items.id', '=', 'delivery_order_items.item_id')
            ->where('delivery_orders.invoice_id', $invoice->id)
            ->value('total');

        // ----- VALIDATION START ------
        $delivery_order_ids = DeliveryOrder::select('id')
            ->where('invoice_id', $invoice->id)
            ->pluck('id');

        $validation_rules = [
            'payment_method' => ['required', Rule::in('cash', 'new_giro', 'giro')]
        ];

        $validator = Validator::make(request()->all(), $validation_rules);

        $validator->sometimes('giro_number', 'required|unique:giros,number', function ($input) {
            return $input->payment_method == 'new_giro';
        });

        $validator->sometimes('giro_id', 'required', function ($input) {
            return $input->payment_method == 'giro';
        });

        $data = $validator->validate();
        // ----- VALIDATION END ------

        DB::transaction(function() use($invoice, $data, $cash_amount) {
            switch ($data['payment_method']) {
                case 'cash':

                    if ($invoice->payment_method == 'giro')
                        $invoice->giro_id = NULL;

                    $invoice->cash_amount = $cash_amount;
                    break;

                case 'new_giro':

                    if ($invoice->payment_method == 'cash')
                        $invoice->cash_amount = NULL;

                    // Creates a new giro and assigns this invoice to it
                    $giro = Giro::create(['number' => $data['giro_number']]);
                    $giro->invoices()->save($invoice);

                    break;
                case 'giro':

                    if ($invoice->payment_method == 'cash')
                        $invoice->cash_amount = NULL;

                    // Use an existing giro
                    $giro = Giro::find($data['giro_id']);
                    $giro->invoices()->save($invoice);

                    break;
            }

            $invoice->save();
        });

        session()->flash('message.success', __('messages.update.success'));

        return [
            'status' => 'success',
            'redirect' => URL::previous()
        ];
    }

    public function delete(Invoice $invoice)
    {
        $invoice->delete();

        return back()
            ->with('message.success', __('messages.delete.success'));
    }

}
