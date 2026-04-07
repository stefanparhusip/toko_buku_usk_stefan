<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\View\View;

class PromoController extends Controller
{
    public function index(): View
    {
        $promos = Promo::activeAndValid()->latest()->paginate(12);

        return view('user.promos.index', compact('promos'));
    }
}
