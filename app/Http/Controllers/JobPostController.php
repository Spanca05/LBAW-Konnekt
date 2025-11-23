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
     * Display a listing of the user's cards.
     */
    public function index()
    {

        // vai buscar todos os jobposts ordenados do mais recente para o mais antigo
        $jobPosts =JobPost::orderBy('created_at', 'desc')->get();

        // Render the 'pages.cards' view with the user's cards.
        return view('pages.jobposts', [
            'jobPosts' => $jobPosts
        ]);
    }

    public function show($id){
        $jobPost = JobPost::findOrFail($id);

        return view('pages.jobpost', [
            'jobPost' => $jobPost
        ]);
    }

    public function edit($id){
        $jobPost = JobPost::findOrFail($id);

        return view('pages.edit_jobpost', [
            'jobPost' => $jobPost
        ]);
    }

    public function create(){
        return view('pages.create_jobpost');
    }

    public function store(Request $request){
        $jobPost = new JobPost();

        $jobPost->title = $request->title;
        $jobPost->description = $request->description;
        $jobPost->salary = $request->salary;
        $jobPost->work_model = $request->work_model;
        $jobPost->category_id = $request->category_id;

        //$jobPost->employer_id = Auth::id();
        $jobPost->employer_id = 2; // default value
        $jobPost->location_id = 1; // defaukt value

        $jobPost->save();

        return redirect()->route('jobpost.show', ['jobpost' => $jobPost->id]);
    }


    public function update(Request $request, $id){
        $jobPost = JobPost::findOrFail($id);

        $jobPost->title = $request->input('title');
        $jobPost->description = $request->input('description');
        $jobPost->salary = $request->input('salary');
        $jobPost->work_model = $request->input('work_model');

        $jobPost->save();

        return redirect()->route('jobpost.show', ['jobpost' => $jobPost->id]);
    }


}
