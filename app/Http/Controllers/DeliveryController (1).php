<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function index()
    {
        // Lógica para la página de Delivery
        return view('delivery.index');
    }
}
