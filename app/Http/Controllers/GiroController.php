<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Giro;
use DB;

class GiroController extends Controller
{
    public function index()
    {
        $giros = Giro::select('id', 'number', 'amount', 'transfered_at')
            ->withCount('invoices')
            ->paginate(10);
        
        return view('giro.index', compact('giros'));
    }

    public function search()
    {
        return Giro::select('id')
            ->limit(10)
            ->when(request('id'), function ($query) {
                return $query->where('id', request('id'));
            })
            ->orderBy('created_at', 'desc')
            ->pluck('id');

    }

    public function update(Giro $giro)
    {
        $invoices = DB::table('invoices AS i')
            ->select('invoice_id', 'item_id', 'items.name', 'items.unit', 'price', 'quantity AS quantity_subtotal', DB::raw('quantity * price AS price_subtotal'))
            ->join('delivery_orders AS dor', 'dor.invoice_id', '=', 'i.id')
            ->join('delivery_order_items AS dori', 'dori.delivery_order_id', '=', 'dor.id')
            ->join('items', 'items.id', '=', 'dori.item_id')
            ->where('giro_id', $giro->id)
            ->orderBy('dor.id')
            // ->groupBy('invoice_id', 'item_id', 'items.name', 'items.unit', 'price')
            ->get()
            ->groupBy('invoice_id');

        $price_sums = $invoices
            ->map(function ($invoice) { return $invoice->sum('price_subtotal'); });

        return view('giro.update', compact('giro', 'invoices', 'price_sums'));
    }

    public function processUpdate(Giro $giro)
    {
        $data = $this->validate(request(), [
            'number' => 'nullable|numeric',
            'amount' => 'nullable|min:0',
            'transfered_at' => 'nullable:date'
        ]);

        $giro->update($data);

        return back()
            ->with('message.success', __('messages.update.success'));
    }

    public function delete(Giro $giro)
    {
        $giro->delete();
        return back()
            ->with('message.success', __('messages.delete.success'));
    }
}
