<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_order_items', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('delivery_order_id')->unsigned();
            $table->integer('item_id')->unsigned();
            $table->integer('quantity')->unsigned();

            $table->foreign('delivery_order_id')->references('id')->on('delivery_orders');
            $table->foreign('item_id')->references('id')->on('items');
            $table->unique(['delivery_order_id', 'item_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_order_items');
    }
}
