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

        return redirect()->back();
    }

    
}
