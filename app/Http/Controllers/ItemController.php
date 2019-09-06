<?php

namespace App\Http\Controllers;

use App\Category;
use App\DeliveryOrder;
use App\DeliveryOrderItem;
use App\Item;
use App\Vendor;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index()
    {
        $delivery_order_query = DeliveryOrder::query()
            ->select("received_at")
            ->whereColumn("id", "delivery_order_items.item_id")
            ->limit(1)
            ->getQuery();

        $delivery_order_item_query = DeliveryOrderItem::query()
            ->select("price")
            ->orderByDesc($delivery_order_query)
            ->whereColumn("item_id", "items.id")
            ->whereNotNull("price")
            ->limit(1)
            ->getQuery();

        $items = Item::query()
            ->select("id", "name", "vendor_id", "category_id")
            ->selectSub($delivery_order_item_query, "latest_price")
            ->orderBy("name")
            ->with([
                "vendors:vendors.id,name",
                "category:id,name",
            ])
            ->get();

        return view("item.index", compact("items"));
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
    }
}
