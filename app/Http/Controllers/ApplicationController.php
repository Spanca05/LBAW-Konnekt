<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use App\Models\Application;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ApplicationController extends Controller
{
    use AuthorizesRequests;
    public function create(JobPost $jobpost)
    {
        $user = Auth::user();
        $this->authorize('create', Application::class);

        // If the current user already applied, don't allow entering the apply form.
        $already = Application::where('jobpost_id', $jobpost->id)
            ->where('jobseeker_id', $user->id)
            ->exists();

        if ($already) {
            return redirect()->route('jobpost.show', ['jobpost' => $jobpost->id])
                ->with('error', 'You have already applied to this job.');
        }

        return view('pages.jobpost_apply', ['jobPost' => $jobpost]);
    }

    public function store(Request $request, JobPost $jobpost)
    {
        $user = Auth::user();

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
        $this->authorize('view', $jobpost);
        $applications = $jobpost->applications()->with('user')->orderByDesc('date')->get();
        return view('pages.jobpost_applications', compact('jobpost', 'applications'));
    }

    
    public function edit(Application $application)
    {
        $this->authorize('edit', $application);
        return view('pages.application_edit', ['application' => $application]);
    }

    
    public function update(Request $request, Application $application)
    {
        $this->authorize('update', $application);

        $data = $request->validate([
            'motivation' => ['nullable', 'string', 'max:2000'],
        ]);

        $application->motivation = $data['motivation'] ?? $application->motivation;
        $application->status = 'Pending';
        $application->date = now();
        $application->save();

        return redirect()->route('profile')->with('success', 'Application updated.');
    }

    
    public function delete(Request $request, Application $application)
    {
        $this->authorize('delete', $application);

        Notification::where('application_id', $application->id)->delete();

        $application->delete();

        $validated = $request->validate([
            'redirect_to' => ['nullable', 'string', Rule::in([
                route('profile'),
                route('jobpost.show', $application->jobPost->id)
            ])],
        ]);

        $redirectTo = $validated['redirect_to'] ?? route('jobpost.show', $application->jobPost->id);

        return redirect($redirectTo)->with('success', 'Application withdrawn.');
    }

    public function status_update(Request $request, Application $application) 
    {   
        $this->authorize('status_update',$application);

        $data = $request->validate([
            'status' => ['required', 'in:Accepted,Rejected']
        ]);

        $application->status = $data['status'];
        $application->date = now();
        $application->save();

        return back()->with('success', 'Application status updated.');
    }
}
