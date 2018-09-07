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

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::select('id', 'cash_amount', 'giro_id', 'received_at', 'transfered_at')
            ->with([
                'delivery_orders' => function ($query) { $query->select('invoice_id', 'source_id', 'source_type'); },
                'delivery_orders.source',
                'giro:id,amount,number,transfered_at'
            ])
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
            'received_at' => ['required', 'date']
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
            'delivery_orders' => ['required', 'array',
                function ($attribute, $value, $fail) {
                    if (count($value) < 1) {
                        return $fail("$attribute must have at least one member.");
                    }
                }
            ],
            'delivery_orders.*' => [Rule::in($delivery_order_ids)]
        ]);

        DB::transaction(function () use($temp, $data) {
            $invoice = Invoice::create([
                'received_at' => $temp['received_at']
            ]);
        
            DeliveryOrder::whereIn('id', $data['delivery_orders'])
                ->update(['invoice_id' => $invoice->id]);
        });

        return redirect()
            ->route('invoice.index')
            ->with('message.success', __('messages.create.success'));
    }

    public function update(Invoice $invoice)
    {
        $vendors = Vendor::select('id', 'name')
            ->get();

        $invoice->load([
            'delivery_orders:id,invoice_id,target_id,target_type',
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
            'received_at' => ['required', 'date']
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
        $vendor_name = $invoice->delivery_orders()
            ->with('source')
            ->select('source_id', 'source_type')
            ->distinct()
            ->value('source')
            ->name;

        $delivery_orders = DeliveryOrderItem::query()
            ->select('delivery_orders.id', 'delivery_orders.received_at', DB::raw('SUM(price * quantity) AS subtotal'))
            ->join('delivery_orders', 'delivery_orders.id', '=', 'delivery_order_items.delivery_order_id')
            ->join('items', 'items.id', '=', 'delivery_order_items.item_id')
            ->where('delivery_orders.invoice_id', $invoice->id)
            ->groupBy('delivery_orders.id')
            ->get();
        
        $latest_giro_ids = Giro::select('id')
            ->limit(10)
            ->when($invoice->giro_id, function ($query, $giro_id) {
                return $query->where('id', '<>', $giro_id);
            })
            ->orderBy('created_at', 'desc')
            ->pluck('id');

        return view('invoice.pay', compact('invoice', 'delivery_orders', 'latest_giro_ids', 'vendor_name'));
    }

    public function processPay(Invoice $invoice)
    {
        // ----- VALIDATION START ------
        $delivery_order_ids = DeliveryOrder::select('id')
            ->where('invoice_id', $invoice->id)
            ->pluck('id');

        $validation_rules = [
            'payment_method' => ['required', Rule::in('cash', 'new_giro', 'giro')]
        ];

        $validator = Validator::make(request()->all(), $validation_rules);
        
        $validator->sometimes('cash_amount', 'required|min:0', function ($input) {
            return $input->payment_method == 'cash';
        });

        $validator->sometimes('giro_id', 'required', function ($input) {
            return $input->payment_method == 'giro';
        });

        $data = $validator->validate();
        // ----- VALIDATION END ------

        DB::transaction(function() use($invoice, $data) {
            switch ($data['payment_method']) {
                case 'cash':
                    
                    if ($invoice->payment_method == 'giro')
                        $invoice->giro_id = NULL;

                    $invoice->cash_amount = $data['cash_amount'];
                    break;

                case 'new_giro':

                    if ($invoice->payment_method == 'cash')
                        $invoice->cash_amount = NULL;

                    // Creates a new giro and assigns this invoice to it
                    $giro = Giro::create();
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

        return back()
            ->with('message.success', __('messages.update.success'));
    }

    public function delete(Invoice $invoice)
    {
        $invoice->delete();

        return back()
            ->with('message.success', __('messages.delete.success'));
    }

}
