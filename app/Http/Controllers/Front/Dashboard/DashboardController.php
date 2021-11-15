<?php

namespace App\Http\Controllers\Front\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $address = $user->addresses()->where('default', true)->with('country')->first();

        return Inertia::render('Front/Dashboard/Index', [
            'address' => $address,
        ]);
    }
}
