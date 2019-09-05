<?php

use Illuminate\Database\Migrations\Migration;

class DeleteDuplicateItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("DELETE FROM items a USING items b WHERE a.id < b.id AND a.name = b.name");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
