<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use App\Models\JobPost;

class JobPostController extends Controller
{
    /**
     * Display a listing of the user's job posts.
     */
    public function index(): View
    {
        Gate::authorize('viewAny', JobPost::class);

        $jobposts = Auth::user()
            ->jobposts()
            ->orderBy('id')
            ->get();

        return view('pages.jobposts', [
            'jobposts' => $jobposts,
        ]);
    }

    /**
     * Display the details of a specific job post.
     */
    public function show(JobPost $jobpost): View
    {
        Gate::authorize('view', $jobpost);

        $jobpost->load('items');

        return view('pages.jobpost', [
            'jobpost' => $jobpost,
        ]);
    }

    /**
     * Store a newly created job post in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', JobPost::class);

        $jobpost = new JobPost();
        $jobpost->title = $request->input('title');
        $jobpost->description = $request->input('description', '');
        $jobpost->user_id = Auth::id();

        if ($request->filled('salary')) {
            $jobpost->salary = $request->input('salary');
        }
        if ($request->filled('location')) {
            $jobpost->location = $request->input('location');
        }

        $jobpost->save();

        return response()->json($jobpost);
    }

    /**
     * Remove the specified job post from storage.
     */
    public function destroy(JobPost $jobpost)
    {
        Gate::authorize('delete', $jobpost);

        $jobpost->delete();

        return response()->json($jobpost);
    }
}
