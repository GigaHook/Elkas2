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
            'title' => 'Услуги',
            'user' => Auth::user(),
        ]);
    }

}
