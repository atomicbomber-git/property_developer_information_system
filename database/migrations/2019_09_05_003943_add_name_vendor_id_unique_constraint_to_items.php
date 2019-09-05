<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddNameVendorIdUniqueConstraintToItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            DB::statement("DELETE FROM items a USING items b WHERE a.id < b.id AND a.name = b.name AND a.vendor_id = b.vendor_id");
            $table->unique(["name", "vendor_id"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropUnique(["name", "vendor_id"]);
        });
    }
}
