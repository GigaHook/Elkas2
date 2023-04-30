<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class ProductController extends Controller
{
    public function index(): InertiaResponse {
        return Inertia::render('Products', [
            'page' => 'Products',
            'title' => 'Каталог',
            'user' => Auth::user(),
        ]);
    }

    public function show(Int $id): InertiaResponse {
        return Inertia::render('Product', [
            'page' => 'Product',
            'title' => Product::find($id)->name,
            'user' => Auth::user(),
            'product' => Product::find($id)
        ]);
    }

}
