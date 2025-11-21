<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function showAllEmployees(){
        // Check the user role
        if ($redirect = checkLegitUser()) {
            return $redirect; // redirect if not allowed
        }
        $allUsers = User::all();
        return view('employees.all_employees',compact('allUsers'));
    }

    public function addEmployee(){
        return view('employees.add_employee');
    }
}
