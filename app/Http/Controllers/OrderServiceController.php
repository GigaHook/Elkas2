<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use App\Models\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderServiceController extends Controller
{
    public static function index(): Array {
        $services = [];
        foreach (Order::where('user_id', Auth::id())->get() as $order) 
        foreach (OrderService::where('order_id', $order->id)->get() as $orderservice) {
            $service = Service::find($orderservice->service_id);
            $service->count = $orderservice->count;
            $service->order_id = $orderservice->order_id;
            $services[] = $service;
        }
        return $services;
    }
}
