<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockMutationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_mutations', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->nullableMorphs('source');
            $table->nullableMorphs('target');

            $table->unsignedInteger('item_id');
            $table->decimal('quantity');
            $table->decimal('value');

            $table->timestamps();
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
        Schema::dropIfExists('stock_mutations');
    }
}
