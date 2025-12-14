<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\JobPost;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Policies\AdminPolicy;

class AdminController extends Controller
{

    public function index()
    {
        Gate::policy(Admin::class, AdminPolicy::class);
        Gate::authorize('view', Admin::class);

        $user = Auth::user();
        $userCount = User::count();
        $jobpostCount = JobPost::count();
        $applicationCount = Application::count();

        return view('pages.admin', [
            'admin' => $user,
            'userCount' => $userCount,
            'jobpostCount' => $jobpostCount,
            'applicationCount' => $applicationCount,
        ]);
    }

    public function showCreateAdminForm()
    {
        Gate::policy(Admin::class, AdminPolicy::class);
        Gate::authorize('showCreateAdminForm', Admin::class);

        return view('pages.admin.create_admin');
    }

    public function createAdmin(Request $request)
    {
        Gate::policy(Admin::class, AdminPolicy::class);
        Gate::authorize('createAdmin', Admin::class);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users,name'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone_number' => ['required', 'string', 'max:32'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'password' => Hash::make($data['password']),
            'role' => 'Admin',
        ]);

        return redirect()->route('admin.index')->with('success', 'Admin account created.');
    }

    public function listUsers()
    {
        Gate::policy(Admin::class, AdminPolicy::class);
        Gate::authorize('listUsers', Admin::class);

        $users = User::paginate(10);
        $userCount = User::count();
        return view('pages.admin.admin_users', ['users' => $users, 'userCount' => $userCount,]);
    }

    public function deleteUser($userId)
    {
        Gate::policy(Admin::class, AdminPolicy::class);
        Gate::authorize('deleteUser', Admin::class);

        $user = User::findOrFail($userId);
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }

    public function listJobPosts()
    {
        Gate::policy(Admin::class, AdminPolicy::class);
        Gate::authorize('listJobPosts', Admin::class);

        $jobposts = JobPost::paginate(10);
        $jobpostCount = JobPost::count();
        return view('pages.admin.admin_jobposts', ['jobposts' => $jobposts, 'jobpostCount' => $jobpostCount,]);
    }

    public function deleteJobPost($jobpostId)
    {
        Gate::policy(Admin::class, AdminPolicy::class);
        Gate::authorize('deleteJobPost', Admin::class);

        $jobpost = JobPost::findOrFail($jobpostId);
        $jobpost->delete();

        return redirect()->route('admin.jobposts')->with('success', 'JobPost deleted successfully.');
    }

    public function listApplications()
    {
        Gate::policy(Admin::class, AdminPolicy::class);
        Gate::authorize('listApplications', Admin::class);

        $applications = Application::with(['user', 'jobPost'])->paginate(10);
        $applicationCount = Application::count();
        return view('pages.admin.admin_applications', ['applications' => $applications, 'applicationCount' => $applicationCount,]);
    }

    public function listJobpostApplications($jobpostId)
    {
        Gate::policy(Admin::class, AdminPolicy::class);
        Gate::authorize('listApplications', Admin::class);

        $jobpost = JobPost::findOrFail($jobpostId);
        $applications = Application::where('jobpost_id', $jobpostId)->with(['user', 'jobPost'])->paginate(10);
        $applicationCount = Application::where('jobpost_id', $jobpostId)->count();
        return view('pages.admin.admin_applications', [
            'applications' => $applications,
            'applicationCount' => $applicationCount,
            'jobpost' => $jobpost,
        ]);
    }

    public function deleteApplication($applicationId)
    {
        Gate::policy(Admin::class, AdminPolicy::class);
        Gate::authorize('deleteApplication', Admin::class);

        $application = Application::findOrFail($applicationId);
        $application->delete();

        return redirect()->route('admin.applications')->with('success', 'Application deleted successfully.');
    }

    public function showApplication($applicationId)
    {
        Gate::policy(Admin::class, AdminPolicy::class);
        Gate::authorize('viewApplication', Admin::class);

        $application = Application::with(['user', 'jobPost'])->findOrFail($applicationId);

        return view('pages.admin.admin_application_show', [
            'application' => $application,
        ]);
    }
}
