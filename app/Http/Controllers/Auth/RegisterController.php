<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\View\View;

use App\Models\User;

class RegisterController extends Controller
{
    /**
     * Show the user registration form.
     */
    public function showRegistrationForm(): View
    {
        // Render the registration view.
        return view('auth.register');
    }

    /**
     * Handle a new user registration request.
     *
     * This method:
     * - Validates the registration input data.
     * - Creates a new user with a hashed password.
     * - Logs the user in automatically after registration.
     * - Regenerates the session to prevent fixation attacks.
     * - Redirects the user to the cards page with a success message.
     */
    public function register(Request $request)
    {
        // Validate registration input.
        $request->validate([
            'name' => 'required|string|max:250',
            'role' => 'required|in:JobSeeker,Employer',
            'phone_number' => 'required|string|max:20',
            'location' => 'nullable|string|max:255',
            'email' => 'required|email|max:250|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);

        // Create the new user.
        User::create([
            'name' => $request->name,
            'role' => $request->role,
            'phone_number' => $request->phone_number,
            'location' => $request->location ?? null,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // Attempt login for the newly registered user.
        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);

        // Regenerate session for security (protection against session fixation).
        $request->session()->regenerate();

        // Redirect to cards page with a success message.
        return redirect()->route('pages.jobposts.index')
            ->withSuccess('You have successfully registered & logged in!');
    }
}
