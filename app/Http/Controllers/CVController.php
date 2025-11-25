<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CV;
use Illuminate\Support\Facades\Storage;

class CVController extends Controller 
{
    /**
     * Store or update the authenticated user's CV (file + description).
     */
    public function store(Request $request) 
    {
        $user = $request->user();

        $validated = $request->validate([
            'cv_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'cv_description' => 'nullable|string|max:2000',
        ]);

        $cv = $user->cv;

        $newPath = null;
        if ($request->hasFile('cv_file')) {
            $file = $request->file('cv_file');
            $newPath = $file->store('cvs', 'public');
            if ($cv && $cv->file_path) {
                Storage::disk('public')->delete($cv->file_path);
            }
        }

        $attrs = [
            'description' => $validated['cv_description'] ?? ($cv->description ?? null),
            'uploaded_at' => $request->hasFile('cv_file') ? now() : ($cv->uploaded_at ?? null),
        ];
        if ($newPath !== null) {
            $attrs['file_path'] = $newPath;
        }

        if ($cv) {
            $cv->update(array_filter($attrs, function ($v) {
                return $v !== null;
            }));
        } else {
            $user->cv()->create($attrs);
        }

        return redirect()->route('profile.edit')->with('success', 'CV updated.');
    }

    /**
     * Download the authenticated user's CV file.
     */
    public function download(Request $request) {
        $user = $request->user();
        $cv = $user->cv;

        if (!$cv || !$cv->file_path) {
            return redirect()->route('profile')->with('error', 'CV not found.');
        }

        $path = $cv->file_path;
        $disk = Storage::disk('public');

        if (! $disk->exists($path)) {
            return redirect()->route('profile')->with('error', 'CV file missing.');
        }

        // Serve using the filesystem path to avoid the Storage::download linter/runtime differences
        $fullPath = storage_path('app/public/' . ltrim($path, '/'));
        return response()->download($fullPath);
    }
}
