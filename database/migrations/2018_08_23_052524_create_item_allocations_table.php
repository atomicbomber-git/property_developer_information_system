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

            $table->integer('source_id')->unsigned();
            $table->string('source_type');

            $table->integer('target_id')->unsigned();
            $table->string('target_type');

            $table->integer('quantity')->unsigned();

            $table->unique(
                ['source_id', 'source_type', 'target_id', 'target_type'],
                'item_allocation_unique_pairing'
            );

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
        Schema::dropIfExists('item_allocations');
    }
}
