<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexesToDeliveryOrderItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('delivery_order_items', function (Blueprint $table) {
            $table->index("delivery_order_id");
            $table->index("item_id");

            $table->index(["delivery_order_id", "id"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('delivery_order_items', function (Blueprint $table) {
            $table->dropIndex(["delivery_order_id"]);
            $table->dropIndex(["item_id"]);

            $table->dropIndex(["delivery_order_id", "id"]);
        });
    }
}
