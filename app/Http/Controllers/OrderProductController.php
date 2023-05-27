<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Summary of OrderProductController
 */
class OrderProductController extends Controller
{
    /**
     * Для пользователя: возвращает все продукты всех ордеров + их кол-во + id их ордера
     * Для админа: все продукты всех ордеров + их кол-во + id их ордера
     * @return array
     */
    public static function index(): Array {
        $products = [];
        if (!Auth::user()->admin)
        foreach (Order::where('user_id', Auth::id())->get() as $order) 
        foreach (OrderProduct::where('order_id', $order->id)->get() as $orderProduct) {
            try {
                $product = Product::find($orderProduct->product_id);
                $product->count = $orderProduct->count;
                $product->order_id = $orderProduct->order_id;
                $products[] = $product;
            } catch (Error) {
                continue;
            }
        }
        else foreach (OrderProduct::all() as $orderProduct) {
            try {
                $product = Product::find($orderProduct->product_id);
                $product->count = $orderProduct->count;
                $product->order_id = $orderProduct->order_id;
                $products[] = $product;
            } catch (Error) {
                continue;
            }
        }
        return $products;
    }
}
