<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPost;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class JobPostController extends Controller {

    /**
     * Display a listing of the user's cards.
     */
    public function index() {

        // vai buscar todos os jobposts ordenados do mais recente para o mais antigo
        $jobPosts = JobPost::orderBy('created_at', 'desc')->get();

        // Render the 'pages.cards' view with the user's cards.
        return view('pages.jobposts', [
            'jobPosts' => $jobPosts
        ]);
    }

    public function show($id) {
        $jobPost = JobPost::findOrFail($id);

        return view('pages.jobpost', [
            'jobPost' => $jobPost
        ]);
    }

    public function edit($id) {
        //$jobPost = JobPost::with('jobLocation')->findOrFail($id);
        $jobPost = JobPost::with('jobCategory')->findOrFail($id);

        Gate::authorize('update', $jobPost);

        $categories = Category::all();


        return view('pages.edit_jobpost', [
            'jobPost' => $jobPost,
            'categories' => $categories
        ]);
    }

    public function create() {
        Gate::authorize('create', JobPost::class);
        return view('pages.create_jobpost');
    }

    public function store(Request $request) {
        Gate::authorize('create', JobPost::class);

        // Validate input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'salary' => 'required|numeric|min:0',
            'work_model' => 'required|string',
            'category_id' => 'required|integer',
            'location' => 'nullable|string|max:255',
        ]);

        $jobPost = new JobPost();

        $jobPost->title = $validated['title'];
        $jobPost->description = $validated['description'];
        $jobPost->salary = $validated['salary'];
        $jobPost->work_model = $validated['work_model'];
        $jobPost->category_id = $validated['category_id'];
        $jobPost->employer_id = Auth::id();
        // Explicitly assign location
        $jobPost->location = array_key_exists('location', $validated) ? $validated['location'] : $jobPost->location;


        $jobPost->save();

        return redirect()->route('jobpost.show', ['jobpost' => $jobPost->id]);
    }


    public function update(Request $request, $id) {

        $jobPost = JobPost::findOrFail($id);
        Gate::authorize('update', $jobPost);

        $jobPost->title = $request->input('title');
        $jobPost->description = $request->input('description');
        $jobPost->salary = $request->input('salary');
        $jobPost->work_model = $request->input('work_model');
        $jobPost->location = $request->input('location');

        $jobPost->save();

        return redirect()->route('jobpost.show', ['jobpost' => $jobPost->id]);
    }
    public function delete($id) {

        $jobPost = JobPost::findOrFail($id);
        Gate::authorize('delete', $jobPost);
        $jobPost->notifications()->delete();
        DB::table('jobpost_category')->where('jobpost_id', $jobPost->id)->delete(); // remove dependency
        $nome = $jobPost->title;
        $jobPost->delete();
        return redirect()->route('pages.jobposts.index')->with('success', "JobPost {$nome} Deleted!");
    }
}
