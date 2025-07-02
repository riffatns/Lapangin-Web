<?php
// filepath: app/Http/Controllers/AuthController.php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'phone' => 'required|string|max:20',
                'birthdate' => 'required|date|before:today',
                'city' => 'required|string|max:100',
                'favorite_sport' => 'required|string|max:100',
                'password' => 'required|string|min:8',
                'confirm_password' => 'required|same:password',
                'bio' => 'nullable|string|max:1000',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // Create user account
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'role' => 'user',
                'is_active' => true,
            ]);

            // Create user profile
            $user->profile()->create([
                'birthdate' => $request->birthdate,
                'city' => $request->city,
                'bio' => $request->bio,
                'favorite_sport' => $request->favorite_sport,
                'total_bookings' => 0,
                'total_points' => 0,
            ]);

            // For web requests, show success message and redirect back to register
            return redirect()->back()->with('success', 'Registration successful! Please login with your new account.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Registration failed: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            if (!Auth::attempt($request->only('email', 'password'))) {
                return redirect()->back()
                    ->with('error', 'Invalid credentials')
                    ->withInput();
            }

            return redirect()->route('dashboard')->with('success', 'Login successful!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Login failed. Please try again.')
                ->withInput();
        }
    }

    public function logout(Request $request)
    {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('success', 'Logged out successfully!');

        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Logout failed.');
        }
    }
}