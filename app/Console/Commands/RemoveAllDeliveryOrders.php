<?php

namespace App\Console\Commands;

use App\DeliveryOrder;
use App\DeliveryOrderItem;
use Illuminate\Console\Command;

class RemoveAllDeliveryOrders extends Command
{
    protected $signature = 'delivery-orders:destroy';

    public function handle()
    {
        DeliveryOrderItem::query()->delete();
        DeliveryOrder::query()->delete();
    }
}
