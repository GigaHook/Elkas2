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
    public function store(Request $request): RedirectResponse {
        if ($request->action == 'add') { //ADD OR CREATE
            $product = CartProduct::firstOrCreate([
                'product_id' => $request->id,
                'user_id' => Auth::id(),
            ], [
                'count' => 1
            ]);
            if (!$product->wasRecentlyCreated) {
                $product->count++;
                $product->save();
            }
        } else { //DECREASE OR DELETE
            $product = CartProduct::find($request->id);
            if ($product->count == 1) {
                $product->delete();
            } else {
                $product->count--;
                $product->save();
            }
        }

        return redirect()->back();
    }

    public function delete(Request $request): RedirectResponse {
        CartProduct::where(['product_id' => $request->id, 'user_id' => Auth::id()])->delete();
        return redirect()->back();
    }



}
