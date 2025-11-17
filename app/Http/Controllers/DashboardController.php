<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\StaffRegistered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.dashboard');
    }
    public function save_staff(Request $request)
    {
        // Validate inputs
        $request->validate([
            'first_name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'idno' => 'required|string|max:50|unique:users,idNumber',
            'email' => 'required|email|unique:users,email',
            'upn' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:20',
            'designation' => 'nullable|string|max:100',
            'date_of_birth' => 'nullable|date',
            'date_of_appointment' => 'nullable|date',
        ]);

        $password = generateRandomStrongPassword(12);

        // Save in User model
        $user = User::create([
            'name' => $request->first_name,
            'surname' => $request->surname,
            'other_names' => $request->last_name,
            'idNumber' => $request->idno,
            'email' => $request->email,
            'phone' => $request->phone,
            'pfNumber' => $request->upn,
            'designation' => $request->designation,
            'date_of_birth' => $request->date_of_birth,
            'date_of_appointment' => $request->date_of_appointment,
            'password' => Hash::make($password),
            'role' => 2,
        ]);

        try {
            // Send Markdown email with automatic vendor layout
            Mail::to($user->email)
                ->send(new StaffRegistered($user->name, $user->email, $password));
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Staff saved, but failed to send email: ' . $e->getMessage()
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Staff registered successfully and email sent!',
            'user_id' => $user->id
        ]);
    }

}
