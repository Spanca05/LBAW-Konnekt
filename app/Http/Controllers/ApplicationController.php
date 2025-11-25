<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use App\Models\Application;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function create(JobPost $jobpost)
    {
        $user = Auth::user();

        // If the current user already applied, don't allow entering the apply form.
        if ($user && $user->role === 'JobSeeker') {
            $already = Application::where('jobpost_id', $jobpost->id)
                ->where('jobseeker_id', $user->id)
                ->exists();

            if ($already) {
                return redirect()->route('jobpost.show', ['jobpost' => $jobpost->id])
                    ->with('error', 'You have already applied to this job.');
            }
        }

        return view('pages.jobpost_apply', ['jobPost' => $jobpost]);
    }

    public function store(Request $request, JobPost $jobpost)
    {
        $user = Auth::user();
        // optional: check role if you have roles
        //this->authorize('apply', $jobpost); // optional Policy

        $data = $request->validate([
            'motivation' => ['nullable', 'string', 'max:2000'],
        ]);

        // Prevent duplicate
        if (Application::where('jobpost_id', $jobpost->id)->where('jobseeker_id', $user->id)->exists()) {
            return back()->withErrors(['You have already applied to this job.']);
        }


        $application = Application::create([
            'jobseeker_id' => $user->id,
            'jobpost_id' => $jobpost->id,
            'motivation' => $data['motivation'] ?? " ",
            'date' => now(),
            'status' => 'Pending'
        ]);

        return redirect()->route('jobpost.show', $jobpost)->with('success', 'Application submitted.');
    }

    public function index(JobPost $jobpost)
    {
        // ensure the current user owns the job or is employer
        $this->authorize('viewApplications', $jobpost);
        $applications = $jobpost->applications()->with('user')->orderByDesc('date')->get();
        return view('pages.jobpost_applications', compact('jobpost', 'applications'));
    }

    /**
     * Show the form to edit an application (jobseeker only).
     */
    public function edit(Application $application)
    {
        $user = Auth::user();
        if (!$user || $user->id !== $application->jobseeker_id) {
            abort(403);
        }

        return view('pages.application_edit', ['application' => $application]);
    }

    /**
     * Update an application (jobseeker only).
     */
    public function update(Request $request, Application $application)
    {
        $user = Auth::user();
        if (!$user || $user->id !== $application->jobseeker_id) {
            abort(403);
        }

        $data = $request->validate([
            'motivation' => ['nullable', 'string', 'max:2000'],
        ]);

        $application->motivation = $data['motivation'] ?? $application->motivation;
        $application->save();

        return redirect()->route('profile')->with('success', 'Application updated.');
    }

    /**
     * Delete an application (jobseeker only).
     */
    public function destroy(Application $application)
    {
        $user = Auth::user();
        if (!$user || $user->id !== $application->jobseeker_id) {
            abort(403);
        }
        // Delete dependent notifications that reference this application to avoid
        // foreign-key constraint violations (legacy schema references application.id).
        Notification::where('application_id', $application->id)->delete();

        $application->delete();
        return redirect()->route('profile')->with('success', 'Application withdrawn.');
    }
}
