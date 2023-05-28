<?php

namespace App\Http\Controllers;

use App\Models\CartService;
use App\Models\Service;

use Error;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class CartServiceController extends Controller
{
    public static function index(): Array {
        $services = [];
        $cartServices = CartService::where('user_id', Auth::id())->get();
        foreach ($cartServices as $cartService) {
            try {
                $service = Service::find($cartService->service_id);
                $service->count = $cartService->count;
                $services[] = $service;
            } catch (Error) {
                continue; //вижу цель не вижу препятствий
            }
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
    public function clear(): Void {
        CartService::where(['user_id' => Auth::id()])->delete();
    }
}
