<?php

namespace App\Helpers;

class Formatter
{
    public function currency($value)
    {
        return isset($value) ?
            number_format($value, 2) :
            $this->emptySymbol();
    }

    private function emptySymbol()
    {
        return "-";
    }
}
