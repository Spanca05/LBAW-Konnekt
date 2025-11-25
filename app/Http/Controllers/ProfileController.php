<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller {
    /**
     * Display the authenticated user's profile.
     */
    public function show(Request $request) {
        $user = Auth::user();
        return view('pages.profile', ['user' => $user]);
    }

    /** Show the edit form for the authenticated user's profile. */
    public function edit(Request $request) {
        $user = Auth::user();
        return view('pages.profile_edit', ['user' => $user]);
    }

    /** Update the authenticated user's profile. */
    public function update(Request $request) {
        $user = Auth::user();
        if (! $user instanceof \App\Models\User) {
            abort(403);
        }

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

        // Unified CV handling: accept cv_file + cv_description in same form
        if ($user->role === 'JobSeeker') {
            $validatedCv = $request->validate([
                'cv_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
                'cv_description' => 'nullable|string|max:2000',
            ]);

            $cv = $user->cv;

            if ($request->hasFile('cv_file')) {
                $file = $request->file('cv_file');

                // Server-side detected mime (finfo) is more reliable than client-sent type
                $detected = $file->getMimeType();
                $allowed = [
                    'application/pdf',
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                ];
                if (! in_array($detected, $allowed)) {
                    return back()->withErrors(['cv_file' => 'Invalid file type (server detected).']);
                }

                $newPath = $file->store('cvs', 'public');
                if ($cv && $cv->file_path) {
                    Storage::disk('public')->delete($cv->file_path);
                }

                $attrs = [
                    'file_path' => $newPath,
                    'uploaded_at' => now(),
                    'description' => $validatedCv['cv_description'] ?? ($cv->description ?? null),
                    'mime_type' => $detected ?: ($file->getClientMimeType() ?: null),
                ];

                if ($cv) {
                    $cv->update(array_filter($attrs, fn($v) => $v !== null));
                } else {
                    $user->cv()->create($attrs);
                }
            } else {
                // If no new file but description provided, update description only
                if (isset($validatedCv['cv_description']) && $validatedCv['cv_description'] !== ($cv->description ?? null)) {
                    if ($cv) {
                        $cv->update(['description' => $validatedCv['cv_description']]);
                    } else {
                        $user->cv()->create([
                            'description' => $validatedCv['cv_description'],
                            'uploaded_at' => null,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }

    /**
     * Remove the authenticated user's profile photo.
     */
    public function destroyPhoto(Request $request) {
        $user = Auth::user();
        if ($user && $user->photo_path) {
            Storage::disk('public')->delete($user->photo_path);
            $user->photo_path = null;
            $user->save();
        }

        return redirect()->route('profile.edit')->with('success', 'Profile photo removed.');
    }
}
