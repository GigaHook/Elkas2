<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderProductController extends Controller
{
    public static function index(): Array {
        $products = [];
        foreach (Order::where('user_id', Auth::id())->get() as $order) 
        foreach (OrderProduct::where('order_id', $order->id)->get() as $orderProduct) {
            $product = Product::find($orderProduct->product_id);
            $product->count = $orderProduct->count;
            $product->order_id = $orderProduct->order_id;
            $products[] = $product;
        }
        return $products;
    }
}
