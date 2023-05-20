<?php

namespace App\Http\Controllers;

use App\Http\Controllers\OrderProductController;
use App\Http\Controllers\OrderServiceController;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderService;
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
            'orderProducts' => OrderProduct::all(),
            'orderServices' => OrderService::all(),
        ]);
    }

    public function show(Int $userId): InertiaResponse {
        $orders = [];
        $rawOrders = Order::where('user_id', $userId)->get();
        foreach ($rawOrders as $rawOrder) {
            $rawOrder->expanded = [$rawOrder->status == 'В работе' ? $rawOrder->id : null];
            $orders[] = $rawOrder;
        }
        return Inertia::render('Orders', [
            'user' => Auth::user(),
            'orders' => $orders,
            'orderProducts' => OrderProductController::index(),
            'orderServices' => OrderServiceController::index(),
        ]);
    }

    /**
     * Делает пустой ордер
     * для каждого предмета из корзины делает предмет ордера
     * считает общую цену и сохраняет ордер
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function store(Request $request): Void {
        $order = new Order;
        $order->user_id = Auth::id();
        $order->price = 0;
        $order->status = 'В работе';
        $order->save(); //чтобы потом на его айди ссылаться
        $price = 0;
        foreach ($request->products as $product) {
            $product = (object)$product;
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'count' => $product->count
            ]);
            $price += $product->price * $product->count;
        }
        foreach ($request->services as $service) {
            $service = (object)$service;
            OrderService::create([
                'order_id' => $order->id,
                'service_id' => $service->id,
                'count' => $service->count
            ]);
            $price += $service->price * $service->count;
        }
        $order->price = $price;
        $order->save();
    }
}
