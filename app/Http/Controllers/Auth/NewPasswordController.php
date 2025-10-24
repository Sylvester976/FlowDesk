<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        try {
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function (User $user) use ($request) {
                    $user->forceFill([
                        'password' => Hash::make($request->password),
                        'remember_token' => Str::random(60),
                    ])->save();

                    event(new PasswordReset($user));
                }
            );

            if ($status == Password::PASSWORD_RESET) {
                // SweetAlert success message
                return redirect()->route('login')->with('swal', [
                    'icon'  => 'success',
                    'title' => 'Password Reset',
                    'text'  => 'Your password has been successfully reset.'
                ]);
            } else {
                // SweetAlert error message
                return back()->withInput($request->only('email'))->with('swal', [
                    'icon'  => 'error',
                    'title' => 'Reset Failed',
                    'text'  => __($status)
                ]);
            }
        } catch (\Exception $e) {
            // Handle unexpected errors
            return back()->withInput($request->only('email'))->with('swal', [
                'icon'  => 'error',
                'title' => 'Error',
                'text'  => 'Something went wrong. Please try again later.'
            ]);
        }
    }
}
