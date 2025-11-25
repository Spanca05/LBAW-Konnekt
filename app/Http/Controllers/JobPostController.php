<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPost;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class JobPostController extends Controller
{

    /**
     * Display a listing of the user's cards.
     */
    public function index(Request $request)
    {
        // vai buscar todos os jobposts ordenados do mais recente para o mais antigo
        $jobPosts =JobPost::orderBy('created_at', 'desc')->get();

        // Render the 'pages.cards' view with the user's cards.
        return view('pages.jobposts', [
            'jobPosts' => $jobPosts
        ]);
    }

    public function show($id){
        $jobPost = JobPost::with('jobUser')->findOrFail($id);

       // $name = $jobPost->jobUser->name;

        return view('pages.jobpost', [
            'jobPost' => $jobPost
            //'name' =>$name
        ]);
    }

    public function edit($id){
        //$jobPost = JobPost::with('jobLocation')->findOrFail($id);
        $jobPost = JobPost::with('jobCategory')->findOrFail($id);


        $categories = Category::all();


        return view('pages.edit_jobpost', [
            'jobPost' => $jobPost,
            'categories' => $categories
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
    public function delete($id){
        $jobPost = JobPost::findOrFail($id);
        $jobPost->notifications()->delete();
        DB::table('jobpost_category')->where('jobpost_id', $jobPost->id)->delete(); // remove dependency
        $nome = $jobPost->title;
        $jobPost->delete();
        return redirect()->route('pages.jobposts.index')->with('success', "JobPost {$nome} Deleted!");
    }


    public function search(Request $request){
        $pesquisa = $request->input('q');
        $jobPosts = JobPost::whereRaw(
                "tsvectors @@ plainto_tsquery('english', ? )",   // n suporta buscas por sufixo, por exemplo "se" n dará "senior"
                [$pesquisa]
            )
            ->orderByRaw(
                "ts_rank(tsvectors, plainto_tsquery('english', ?)) DESC",
                [$pesquisa]
            )
            ->get();

        /*$jobPosts = JobPost::where('title', 'ILIKE', "%{$query}%")   ## usar ILIKE em vez de LIKE por causa da maiuscula e miniscula
            ->orderBy('created_at', 'desc')  ## ordenado do mais recente para o mais antigo 
            ->get();*/

        return view('pages.search_results', [
            'jobPosts' => $jobPosts,
            'query' => $pesquisa
        ]);
    }
}

