<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStorageIdToStockAdjustments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_adjustments', function (Blueprint $table) {
            $table->unsignedInteger('storage_id');
            $table->foreign('storage_id')
                ->references('id')
                ->on('storages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_adjustments', function (Blueprint $table) {
            $table->dropForeign('storage_id');
        });
    }
}
