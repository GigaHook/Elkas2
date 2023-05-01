<?php

namespace App\Http\Controllers;

use App\Models\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class CartServiceController extends Controller
{
    public function store(Request $request): RedirectResponse {
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

        return redirect()->back();
    }
}