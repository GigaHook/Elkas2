<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class OrderController extends Controller
{
    public function index(): InertiaResponse {
        return Inertia::render('Orders', [
            'user' => Auth::user(),
            'orders' => Order::all(),
        ]);
    }
}
