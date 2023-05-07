<?php

namespace App\Http\Controllers;

use App\Models\CartService;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class CartServiceController extends Controller
{
    public static function index(): Array {
        $services = [];
        $cartservices = CartService::where('user_id', Auth::id())->get();
        foreach ($cartservices as $cartservice) {
            $service = Service::find($cartservice->service_id);
            $service->count = $cartservice->count;
            $services[] = $service;
        }
        return $services;
    }
    public function store(Request $request): Void {
        $service = CartService::firstOrCreate([
            'service_id' => $request->id,
            'user_id' => Auth::id(),
        ], [
            'count' => 1
        ]);
        if ($service->wasRecentlyCreated) return;
        $service->count++;
        $service->save();
    }
    public function update(Int $id): Void {
        $service = CartService::where(['service_id' => $id, 'user_id' => Auth::id()])->first();
        $service->count--;
        $service->save();
    }
    public function delete(Request $request): Void {
        CartService::where(['service_id' => $request->id, 'user_id' => Auth::id()])->delete();
    }
}
