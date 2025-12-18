<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CV;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

class CVController extends Controller {
    /**
     * Store or update the authenticated user's CV (file + description).
     */
    public function store(Request $request) {
        $user = $request->user();

        // Only JobSeekers are allowed to upload a CV
        Gate::authorize('create', $user);
        //if (($user->role ?? null) !== 'JobSeeker') { abort(403);}

        $validated = $request->validate([
            'cv_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $cv = $user->cv;

        $newPath = null;

        $attrs = [
            'uploaded_at' => $cv->uploaded_at ?? null,
        ];

        if ($request->hasFile('cv_file')) {
            $file = $request->file('cv_file');
            $newPath = $file->store('cvs', 'public');
            if ($cv && $cv->file_path) {
                Storage::disk('public')->delete($cv->file_path);
            }

            $attrs['file_path'] = $newPath;
            $attrs['uploaded_at'] = now();

            // Persist mime_type (table has the column).
            // Prefer server-detected MIME (finfo), fallback to client-reported value.
            $mime = $file->getMimeType() ?: ($file->getClientMimeType() ?: null);
            if ($mime) {
                $attrs['mime_type'] = $mime;
            }
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

        // Serve using the filesystem path and provide a friendly filename: <UserName>_CV.<ext>
        $fullPath = storage_path('app/public/' . ltrim($path, '/'));

        // Determine extension from stored path
        $ext = pathinfo($path, PATHINFO_EXTENSION) ?: 'bin';

        // Build a safe username portion: replace non-alphanum with underscore, collapse underscores
        $rawName = $user->name ?? 'user';
        $safeName = preg_replace('/[^A-Za-z0-9]+/', '_', $rawName);
        $safeName = trim($safeName, '_');
        if ($safeName === '') {
            $safeName = 'user';
        }

        $downloadName = $safeName . '_CV.' . $ext;

        // Determine MIME type (prefer DB-stored value if available)
        $mime = $cv->mime_type ?? mime_content_type($fullPath) ?? 'application/octet-stream';

        return response()->download($fullPath, $downloadName, ['Content-Type' => $mime]);
    }

    public function downloadOther(Request $request, \App\Models\User $user) {
        $requester = $request->user();
        $cv = $user->cv;

        if (!$cv || !$cv->file_path) {
            return redirect()->back()->with('error', 'CV not found.');
        }

        if ($requester->id !==$user->id) {
            Gate::authorize('view', $cv);
            //if (($user->role ?? null) !== 'JobSeeker') { abort(403);}
        }

        $disk = Storage::disk('public');
        if (! $disk->exists($cv->file_path)) {
            return redirect()->back()->with('error', 'CV file missing.');
        }

        $fullPath = storage_path('app/public/' . ltrim($cv->file_path, '/'));

        // Determine extension from stored path
        $ext = pathinfo($cv->file_path, PATHINFO_EXTENSION) ?: 'bin';

        // Build a safe username portion: replace non-alphanum with underscore, collapse underscores
        $rawName = $user->name ?? 'user';
        $safeName = preg_replace('/[^A-Za-z0-9]+/', '_', $rawName);
        $safeName = trim($safeName, '_');
        if ($safeName === '') {
            $safeName = 'user';
        }

        $downloadName = $safeName . '_CV.' . $ext;

        // Determine MIME type (prefer DB-stored value if available)
        $mime = $cv->mime_type ?? mime_content_type($fullPath) ?? 'application/octet-stream';


        return response()->download($fullPath, $downloadName, ['Content-Type' => $mime]);
    }

    /**
     * Delete the authenticated user's CV (file + DB row).
     */
    public function destroy(Request $request) {
        $user = $request->user();
        //if (($user->role ?? null) !== 'JobSeeker') {abort(403);}

        $cv = $user->cv;
        Gate::authorize('delete', $cv);
        if (! $cv) {
            return redirect()->route('profile.edit')->with('error', 'No CV to delete.');
        }

        if ($cv->file_path) {
            Storage::disk('public')->delete($cv->file_path);
        }

        $cv->delete();

        return redirect()->route('profile.edit')->with('success', 'CV removed.');
    }
}
