<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;

class PublicProfileController extends Controller
{
    public function show(User $user)
    {
        $invoices = $user->invoices()->with('plan')->latest()->get();
        $reviews = $user->reviews()->approved()->latest()->get();

        return view('profile.show', compact('user', 'invoices', 'reviews'));
    }
}
