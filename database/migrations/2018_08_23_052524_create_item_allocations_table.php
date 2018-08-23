<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemAllocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_allocations', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('invoice_item_id')
                ->unsigned();

            $table->integer('storage_id')
                ->unsigned();

            $table->integer('quantity')
                ->unsigned();

            $table->foreign('invoice_item_id')
                ->references('id')
                ->on('invoice_items');

            $table->foreign('storage_id')
                ->references('id')
                ->on('storages');

            $table->unique(['invoice_item_id', 'storage_id']);

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
        Schema::dropIfExists('invoice_item_allocations');
    }
}
