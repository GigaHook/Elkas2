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
            'user' => Auth::user(),
        ]);
    }

    public function show(Int $id): InertiaResponse {
        return Inertia::render('Product', [
            'user' => Auth::user(),
            'product' => Product::find($id)
        ]);
    }

    public function store(Request $request): Void {
        $image = $request->file('image')[0];
        $imageName = time().'.'.$image->getClientOriginalExtension();
        $path = $image->storeAs('public/assets/images', $imageName);
        Product::create([
            'name' => $request->name,
            'image' => str_replace('public/', '', $path),
            'price' => $request->price,
            'description' => $request->description,
            'available' => true,
        ]);
    }
    
    public function update(Request $request, Int $id): Void {
        if ($request->file('image')) {
            $image = $request->file('image')[0];
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $path = $image->storeAs('public/assets/images', $imageName);
        }
        Product::find($id)->update([
            'name' => $request->name,
            'image' => isset($path) ? str_replace('public/', '', $path) : Product::find($id)->image,
            'description' => $request->description,
            'price' => $request->price,
        ]);
    }

    public function delete(Int $id): Void {
        Product::find($id)->delete();
    }
    
}
