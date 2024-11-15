<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        Log::info('Login form route reached'); // Log to ensure this route is reached
        return view('auth.login');
    }

    // Process the login request
    public function login(Request $request)
    {
        // Log the login attempt
        Log::info('Login attempt', ['username' => $request->username, 'password' => $request->password]);

        // Validate the login credentials
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Retrieve the user from the database
        $user = User::where('username', $request->username)->first();

        if ($user && $user->password === $request->password) {  // Direct password comparison
            // Log the user in
            Auth::login($user);
            // Redirect to the dashboard
            return redirect()->route('dashboard');
        }

        // Log the failed login attempt
        Log::warning('Failed login attempt:', ['username' => $request->username, 'timestamp' => now()]);
        return back()->withErrors(['username' => 'Invalid credentials.']);
    }



    // Show the registration form
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Process the registration request
    public function register(Request $request)
{
    // Validate the registration form data
    $request->validate([
        'username' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|confirmed', // Ensure password confirmation is correct
        'role_status' => 'required|string',
    ]);

    // Create a new user using the User model with plain text password
    $user = User::create([
        'username' => $request->username,
        'email' => $request->email,
        'password' => $request->password,  // Store plain password
        'id_role' => $request->role_status == 'Administrasion' ? 1 : 2, // Adjust role_id based on role_status
    ]);

    // Redirect to the login page after successful registration
        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }

}
