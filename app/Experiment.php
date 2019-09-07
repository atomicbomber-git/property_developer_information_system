<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Experiment extends Model
{
    public $table = "items";

    public function get($columns = ['*'])
    {
        dump($this->builder->toSql());

        parent::get($columns);
    }
}
