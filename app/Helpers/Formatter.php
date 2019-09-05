<?php

namespace App\Helpers;

use Jenssegers\Date\Date;

class Formatter
{
    public function date($value)
    {
        return $value ?
            (new Date($value))->format("d/m/Y") :
            $this->emptySymbol();
    }

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
