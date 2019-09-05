<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class FillVendorItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_items', function (Blueprint $table) {
            DB::statement("INSERT INTO vendor_items (item_id, vendor_id, created_at, updated_at) (SELECT id AS item_id, vendor_id, current_timestamp, current_timestamp
            FROM items);");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_items', function (Blueprint $table) {
            //
        });
    }
}
