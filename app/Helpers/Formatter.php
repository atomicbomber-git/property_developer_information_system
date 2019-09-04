<?php

namespace App\Helpers;

class Formatter
{
    public function currency($value)
    {
        return number_format($value, 2);
    }
}
