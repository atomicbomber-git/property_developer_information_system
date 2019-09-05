<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Storage;
use DB;

class StorageController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index()
    {
        if (request()->ajax())
            return Storage::select('id', 'name')->orderBy('name')->get();

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

    public function stock(Storage $storage)
    {
        $transfer_quantity_expr = "
            CASE
                WHEN ( source_id = ? AND source_type = 'STORAGE' ) THEN -quantity
                WHEN ( target_id = ? AND target_type = 'STORAGE' ) THEN quantity
            END AS transfer_quantity
        ";

        $subquery = DB::table('delivery_order_items AS doi')
            ->join('delivery_orders AS do', 'do.id', '=', 'doi.delivery_order_id')
            ->select('item_id', 'quantity')
            ->selectRaw($transfer_quantity_expr, [$storage->id, $storage->id])
            ->where(function ($query) use($storage) {
                $query
                    ->where(function ($query) use($storage) {
                        $query
                            ->where('do.source_type', 'STORAGE')
                            ->where('do.source_id', $storage->id);
                    })
                    ->orWhere(function ($query) use($storage) {
                        $query
                            ->where('do.target_type', 'STORAGE')
                            ->where('do.target_id', $storage->id);
                    });
            });

        $subquery_sql = $subquery->toSql();

        $item_stocks = DB::table(DB::raw("($subquery_sql) AS subtable"))
            ->mergeBindings($subquery)
            ->select('items.id', DB::raw('UPPER(items.name) AS name'), DB::raw('UPPER(items.unit) AS unit'), DB::raw('SUM(transfer_quantity) AS stock'))
            ->join('items', 'items.id', '=', 'subtable.item_id')
            ->orderBy(DB::raw('LOWER(items.name)'))
            ->groupBy('items.id', 'item_id')
            ->get();

        return view('storage.stock', compact('item_stocks', 'storage'));
    }

    public function delete(Storage $storage)
    {
        $storage->delete();

        return back()
            ->with('message.success', __('messages.delete.success'));
    }
}
