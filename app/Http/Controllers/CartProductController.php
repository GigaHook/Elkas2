<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\CartProduct;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class CartProductController extends Controller
{
    public static function index(): Array {
        $products = [];
        $cartProducts = CartProduct::where('user_id', Auth::id())->get();
        foreach ($cartProducts as $cartProduct) {
            $product = Product::find($cartProduct->product_id);
            $product->count = $cartProduct->count;
            $products[] = $product;
        }
        return $products;
    }
    public function store(Request $request): Void {
        $product = CartProduct::firstOrCreate([
            'product_id' => $request->id,
            'user_id' => Auth::id(),
        ], [
            'count' => 1
        ]);
        if ($product->wasRecentlyCreated) return;
        $product->count++;
        $product->save();
    }
    public function update(Int $id): Void {
        $product = CartProduct::where(['product_id' => $id, 'user_id' => Auth::id()])->first();
        $product->count--;
        $product->save();
    }
    public function delete(Int $id): Void {
        CartProduct::where(['product_id' => $id, 'user_id' => Auth::id()])->delete();
    }
    public function clear(): Void {
        CartProduct::where(['user_id' => Auth::id()])->delete();
    }
}
