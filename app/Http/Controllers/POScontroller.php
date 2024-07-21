<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class POSController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
    }

    public function index()
    {
        // Lógica para la página de POS
        return view('pos.index');
    }

    public function new()
    {
        // Lógica para la página de POS
        return view('pos.new');
    }
}
