<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        try {
            $request->authenticate(); // Attempt login
            $request->session()->regenerate(); // Prevent session fixation

            return response()->json([
                'status'  => 'success',
                'message' => 'Login successful! Redirecting...',
                'redirect_url' => route('dashboard'), // Breeze redirect
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Invalid credentials
            return response()->json([
                'status'  => 'error',
                'message' => 'Invalid email or password.',
            ], 401);
        } catch (\Throwable $e) {
            // Log actual error for debugging
            \Log::error('Login error: '.$e->getMessage());

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong. Please try again later.',
            ], 500);
        }
    }



    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
