<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class POSController extends Controller
{
    public function index()
    {
        // Lógica para la página de POS
        return view('pos.index');
    }
}
