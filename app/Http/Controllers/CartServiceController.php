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
    public function store(Request $request): RedirectResponse {
        if ($request->action == 'add') { //ADD OR CREATE
            $service = CartService::firstOrCreate([
                'service_id' => $request->id,
                'user_id' => Auth::id(),
            ], [
                'count' => 1
            ]);
            if (!$service->wasRecentlyCreated) {
                $service->count++;
                $service->save();
            }
        } else { //DECREASE OR DELETE
            $service = CartService::find($request->id);
            if ($service->count == 1) {
                $service->delete();
            } else {
                $service->count--;
                $service->save();
            }
        }

        return redirect()->back();
    }

    public static function get(): Array {
        $services = [];
        $cartservices = CartService::where('user_id', Auth::id())->get();
        foreach ($cartservices as $cartservice) {
            $service = Service::find($cartservice->service_id);
            $service->count = $cartservice->count;
            $services[] = $service;
        }
        return $services;
    }

    public function delete(Request $request): RedirectResponse {
        CartService::where(['service_id' => $request->id, 'user_id' => Auth::id()])->delete();
        return redirect()->back();
    }
}