<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyStockMutationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_mutations', function (Blueprint $table) {
            $table->dropMorphs("source");
            $table->dropMorphs("target");

            $table->morphs("storage");
            $table->morphs("origin");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_mutations', function (Blueprint $table) {
            $table->dropMorphs("storage");
            $table->dropMorphs("origin");

            $table->morphs("source");
            $table->morphs("target");
        });
    }
}
