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
            ->orderBy('transfered_at', 'desc')
            ->paginate(10);
        
        return view('giro.index', compact('giros'));
    }

    public function create()
    {
        return view('giro.create');
    }

    public function processCreate()
    {
        $data = $this->validate(request(), [
            'number' => 'string|required',
            'amount' => 'required|min:0',
            'transfered_at' => 'string|required'
        ]);

        Giro::create($data);

        return redirect()
            ->route('giro.index')
            ->with('message.success', __('messages.create.success'));
    }

    public function search()
    {
        return Giro::select('id', 'number')
            ->limit(10)
            ->when(request('number'), function ($query) {
                return $query->where('number', 'like', '%' . request('number') . '%');
            })
            ->orderBy('created_at', 'desc')
            ->get();
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
            ->get()
            ->groupBy('invoice_id');

        $price_sums = $invoices
            ->map(function ($invoice) { return $invoice->sum('price_subtotal'); });

        return view('giro.update', compact('giro', 'invoices', 'price_sums'));
    }

    public function processUpdate(Giro $giro)
    {
        $data = $this->validate(request(), [
            'number' => 'nullable|string',
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
