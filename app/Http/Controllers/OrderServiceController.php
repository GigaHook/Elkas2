<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use App\Models\OrderService;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderServiceController extends Controller
{
    public static function index(): Array {
        $services = [];
        if (!Auth::user()->admin)
        foreach (Order::where('user_id', Auth::id())->get() as $order) 
        foreach (OrderService::where('order_id', $order->id)->get() as $orderService) {
            try {
                $service = Service::find($orderService->service_id);
                $service->count = $orderService->count;
                $service->order_id = $orderService->order_id;
                $services[] = $service;
            } catch (Error) {
                continue;
            }
        }
        else foreach (OrderService::all() as $orderService) {
            try {
                $service = Service::find($orderService->service_id);
                $service->count = $orderService->count;
                $service->order_id = $orderService->order_id;
                $services[] = $service;
            } catch (Error) {
                continue;
            }
        }
        return $services;
    }
}
