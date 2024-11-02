<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Department; 
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        // Fetch all departments from the database
        $departments = Department::all();
        
        // Pass departments to the registration view
        return view('auth.register', compact('departments'));
    }
}

public function register(Request $request)
{
    // Validate the request data
    $this->validate($request, [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'department_id' => 'required|exists:departments,id', // Validate department_id
    ]);

    // Create a new user
    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'department_id' => $request->department_id, // Store department_id
    ]);

    // Redirect after successful registration
    return redirect()->route('home')->with('success', 'Registration successful!');
}