<?php

namespace App\Http\Controllers;

use App\Category;
use App\DeliveryOrder;
use App\DeliveryOrderItem;
use App\Item;
use App\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index(Request $request)
    {
        if (!$request->ajax()) {
            return view("item.index");
        }

        $delivery_order_query = DeliveryOrder::query()
            ->select("received_at")
            ->whereColumn("id", "delivery_order_items.delivery_order_id")
            ->limit(1)
            ->getQuery();

        $delivery_order_item_query = DeliveryOrderItem::query()
            ->select("id")
            ->orderByDesc($delivery_order_query)
            ->whereColumn("item_id", "items.id")
            ->whereNotNull("price")
            ->limit(1)
            ->getQuery();

        $delivery_order_item_price_query = DeliveryOrderItem::query()
            ->select("price")
            ->orderByDesc($delivery_order_query)
            ->whereColumn("item_id", "items.id")
            ->whereNotNull("price")
            ->limit(1)
            ->getQuery();

        $items_query = Item::query()
            ->select("items.id", "items.name", "unit", "items.vendor_id", "category_id")
            ->selectSub($delivery_order_item_query, "latest_delivery_order_item_id")
            ->orderBy("name")
            ->with([
                "latest_delivery_order_item:id,price",
                "vendors:vendors.id,name",
                "category:id,name",
            ]);

        return DataTables::of($items_query)
            ->addColumn('vendor_list', function (Item $user) {
                return $user->vendors->implode("name", ",");
            })
            ->filterColumn('latest_delivery_order_item.price', function ($query, $keyword) use($delivery_order_item_price_query) {
                $query->where(DB::raw("({$delivery_order_item_price_query->toSql()})"), "like", "%$keyword%");
            })
            ->addColumn('controls', function (Item $item) {
                return view("item.control", compact("item"));
            })
            ->addIndexColumn()
            ->toJson();
    }

    public function create()
    {
        $vendors = Vendor::query()
            ->select("id", "name")
            ->get();

        $categories = Category::query()
            ->select("id", "name")
            ->get();

        return view("item.create", compact("vendors", "categories"));
    }

    public function store()
    {
        $data = request()->validate([
            "name" => "required|string|unique:items",
            "unit" => "required|string",
            "note" => "nullable|string",
            "category_id" => "required|exists:categories,id",
            "vendors" => "required|array",
            "vendors.*" => "required|exists:vendors,id"
        ]);

        DB::transaction(function() use($data) {
            $item = Item::create([
                "name" => $data["name"],
                "unit" => $data["unit"],
                "note" => $data["note"],
                "category_id" => $data["category_id"],
            ]);

            foreach ($data["vendors"] as $vendor_id) {
                $item->vendors()
                    ->attach(Vendor::find($vendor_id));
            }
        });

        session()->flash('message.success', __('messages.create.success'));
    }

    public function edit(Item $item)
    {
        $item->load(["vendors:vendors.id,name"]);

        $vendors = Vendor::query()
            ->select("id", "name")
            ->get();

        $categories = Category::query()
            ->select("id", "name")
            ->get();

        return view("item.edit", compact("item", "vendors", "categories"));
    }

    public function update(Item $item)
    {
        $data = request()->validate([
            "name" => ["required", "string", Rule::unique("items")->ignore($item->id)],
            "unit" => "required|string",
            "note" => "nullable|string",
            "category_id" => "required|exists:categories,id",
            "vendors" => "required|array",
            "vendors.*" => "required|exists:vendors,id"
        ]);

        DB::transaction(function() use($item, $data) {
            $item->update([
                "name" => $data["name"],
                "unit" => $data["unit"],
                "note" => $data["note"],
                "category_id" => $data["category_id"],
            ]);

            $item->vendors()->detach();

            foreach ($data["vendors"] as $vendor_id) {
                $item->vendors()
                    ->attach(Vendor::find($vendor_id));
            }
        });

        session()->flash('message.success', __('messages.update.success'));
    }

    public function delete(Item $item)
    {
        DB::transaction(function () use($item) {
            $item->vendors()->detach();
            $item->delete();
        });

        return redirect()
            ->route("item.index")
            ->with("message.success", __("messages.delete.success"));
    }
}
