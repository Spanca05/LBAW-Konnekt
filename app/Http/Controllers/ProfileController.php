<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the authenticated user's profile.
     */
    public function show(Request $request)
    {
        $user = Auth::user();
        return view('pages.profile', ['user' => $user]);
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
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->phone_number = $data['phone_number'] ?? $user->phone_number;

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        if ($request->hasFile('photo')) {
            // Delete previous photo (if it exists)
            if ($user->photo_path) {
                Storage::disk('public')->delete($user->photo_path);
            }

            // Save new photo in storage/app/public/photos
            $path = $request->file('photo')->store('photos', 'public');
            $user->photo_path = $path;
        }

        // Persist the updated user model
        $user->save();

        // CV handling moved to CVController::store

        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }
}
