<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('vendor_id');
            $table->unsignedInteger('item_id');
            $table->unique(['vendor_id', 'item_id']);

            $table->timestamps();

            $table->foreign('vendor_id')
                ->references('id')
                ->on('vendors');

            $table->foreign('item_id')
                ->references('id')
                ->on('items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_items');
    }
}
