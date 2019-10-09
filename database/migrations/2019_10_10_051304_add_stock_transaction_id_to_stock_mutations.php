<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStockTransactionIdToStockMutations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_mutations', function (Blueprint $table) {
            $table->unsignedInteger('stock_transaction_id');
            $table->foreign('stock_transaction_id')
                ->references('id')
                ->on('stock_transactions');
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
            $table->dropForeign(["stock_transaction_id"]);
            $table->dropColumn("stock_transaction_id");
        });
    }
}
