<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display the authenticated user's profile.
     */
    public function show(Request $request)
    {
        $user = Auth::user();
        // If the user is a job seeker, load their applications (legacy schema uses jobseeker_id)
        $applications = collect();
        if ($user && isset($user->role) && $user->role === 'JobSeeker') {
            $applications = $user->applications()->with('jobPost')->orderByDesc('date')->get();
        }

        return view('pages.profile', ['user' => $user, 'applications' => $applications]);
    }

    /** Show the edit form for the authenticated user's profile. */
    public function edit(Request $request)
    {
        $user = Auth::user();
        return view('pages.profile_edit', ['user' => $user]);
    }

    /** Update the authenticated user's profile. */
    public function update(Request $request)
    {
        $user = Auth::user();
        if (! $user instanceof \App\Models\User) {abort(403);}

        $data = $request->validate([
            'name' => ['required', 'string', 'max:250'],
            'email' => ['required', 'email', 'max:250', Rule::unique('users')->ignore($user->id)],
            'phone_number' => ['required', 'string', 'max:20'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->phone_number = $data['phone_number'] ?? $user->phone_number;

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        // Persist the updated user model
        $user->save();

        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }
}
