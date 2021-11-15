<?php

namespace App\Http\Controllers\Front\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\Dashboard\PasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class PasswordController extends Controller
{
    public function index()
    {
        return Inertia::render('Front/Dashboard/Password');
    }

    public function store(PasswordRequest $request)
    {
        $validated = $request->validated();

        User::findOrFail(auth()->id())->update(['password' => Hash::make($validated['new_password'])]);

        return redirect()->route('dashboard')
            ->with('message', 'Password Updated Succesfully.');
    }
}
