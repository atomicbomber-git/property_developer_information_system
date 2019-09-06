<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RemoveAllDuplicateItems extends Command
{
    protected $signature = 'duplicate-items:delete';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        DB::statement("DELETE FROM items a USING items b WHERE a.id < b.id AND a.name = b.name");
    }
}
