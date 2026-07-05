<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $trialPlan = Plan::where('name', 'Deneme')->first();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
            'plan_id' => $trialPlan?->id,
            'subscription_start' => now(),
            'subscription_end' => now()->addDays(3),
            'subscription_status' => User::STATUS_ACTIVE,
        ]);

        Auth::login($user);

        if ($request->session()->has('redirect_to')) {
            return redirect($request->session()->pull('redirect_to'));
        }

        return redirect(RouteServiceProvider::HOME);
    }
}
