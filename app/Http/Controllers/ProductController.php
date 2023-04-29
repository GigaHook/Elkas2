<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public static function index(): Response {
        return Inertia::render('Catalogue', [
            'page' => 'Catalogue',
            'title' => 'Каталог',
            'user' => Auth::user(),
        ]);
    }

    
}
