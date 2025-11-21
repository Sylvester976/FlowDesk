<?php

use Illuminate\Support\Facades\Auth;

function checkLegitUser($allowedRole = 1)
{
    $legit_user = Auth::user()->role ?? null;

    if ($legit_user != $allowedRole) {
        // Logout the user
        Auth::logout();

        // Redirect to login or home
        return redirect()->route('login')->with('error', 'Unauthorized access.');
    }

    return null; // allowed
}


