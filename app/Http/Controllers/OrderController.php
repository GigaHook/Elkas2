<?php

namespace App\Http\Controllers;

use App\Http\Controllers\OrderProductController;
use App\Http\Controllers\OrderServiceController;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderService;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

/**
 * Summary of OrderController
 */
class OrderController extends Controller
{
    /**
     * Для пользователя: Представление всех его ордеров с их товарами и услугами
     * Для админа: Все ордера, их заказы и услуги
     * @return InertiaResponse
     */
    public function index(): InertiaResponse {
        return Inertia::render('Orders', [
            'user' => Auth::user(),
            'orders' => Auth::user()->admin
                ? Order::all()
                : Order::where('user_id', Auth::id())->get(),
            'orderProducts' => OrderProductController::index(),
            'orderServices' => OrderServiceController::index(),
            'users' => Auth::user()->admin ? User::all() : null,
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
        $order->save();
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

    public function update(Request $request, Int $id): Void {
        Order::find($id)->update(['status' => $request->status]);
    }

    public function cancel(Int $id): Void {
        Order::find($id)->update(['status' => 'Отменён']);
    }
}
