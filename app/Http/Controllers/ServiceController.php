<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class ServiceController extends Controller
{
    public function index(): InertiaResponse {
        return Inertia::render('Services', [
            'page' => 'Services',
            'user' => Auth::user(),
        ]);
    }

    public function show(Int $id): InertiaResponse {
        return Inertia::render('Service', [
            'page' => 'Service',
            'user' => Auth::user(),
            'service' => Service::find($id),
        ]);
    }

}
