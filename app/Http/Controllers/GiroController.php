<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Giro;

class GiroController extends Controller
{
    public function search()
    {
        return Giro::select('id')
            ->limit(10)
            ->when(request('id'), function ($query) {
                return $query->where('id', request('id'));
            })
            ->orderBy('created_at', 'desc')
            ->pluck('id');

    }

    public function detail(Giro $giro)
    {
        return $giro;
    }
}
