<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateItemTransfersView extends Migration
{
    private $view_name = 'item_transfers';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE VIEW $this->view_name AS
            SELECT * FROM (
                SELECT item_id, source_type, source_id, target_type, target_id, quantity FROM delivery_orders
                    JOIN delivery_order_items ON delivery_orders.id = delivery_order_items.delivery_order_id
                    UNION ALL
                SELECT item_id, source_type, source_id, target_type, target_id, -quantity FROM delivery_orders
                    JOIN delivery_order_items ON delivery_orders.id = delivery_order_items.delivery_order_id
            ) AS item_transfers
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW $this->view_name");
    }
}
