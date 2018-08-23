<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('creator_id')
                ->unsigned();

            $table->integer('receiver_id')
                ->unsigned()
                ->nullable();

            $table->integer('vendor_id')
                ->unsigned();

            $table->string('payment_type')
                ->nullable();

            $table->string('payment_id')
                ->nullable();
            
            $table->date('received_at')
                ->nullable();

            $table->foreign('creator_id')
                ->references('id')
                ->on('users');

            $table->foreign('receiver_id')
                ->references('id')
                ->on('users');
            
            $table->foreign('vendor_id')
                ->references('id')
                ->on('vendors');

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
        Schema::dropIfExists('invoices');
    }
}
