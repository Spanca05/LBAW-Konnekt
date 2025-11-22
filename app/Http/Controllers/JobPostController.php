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


}
