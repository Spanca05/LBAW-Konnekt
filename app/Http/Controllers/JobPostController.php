<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\JobPost;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class JobPostController extends Controller {

    /**
     * Display a listing of the user's cards.
     */
    public function index(Request $request)
    {
        // vai buscar todos os jobposts ordenados do mais recente para o mais antigo
        //$jobPosts = JobPost::orderBy('created_at', 'desc')->get();

        $jobPosts = JobPost::with('employer')
            ->get()
            ->filter(fn($jobPost) => ! $jobPost->isOwnerDeleted()) // só mantém os válidos
            ->sortByDesc('created_at');

        // Render the 'pages.cards' view with the user's cards.
        return view('pages.jobposts', [
            'jobPosts' => $jobPosts
        ]);
    }

    public function show($id){
        $jobPost = JobPost::with('jobUser')->findOrFail($id);

       // $name = $jobPost->jobUser->name;

        if ($jobPost->isOwnerDeleted()) {
            abort(404);
        }

        return view('pages.jobpost', [
            'jobPost' => $jobPost
            //'name' =>$name
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

        $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'salary' => 'required|integer|min:0', // evita salários negativos
        'category_id' => 'required|integer',
        'work_model' => 'required|in:Remote,On-site,Hybrid',
        'location' => 'nullable|string|required_unless:work_model,Remote'
    ], [
        'salary.min' => 'Salary cannot be negative.',
        'location.required_unless' => 'Location is required unless the job is Remote.'
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
        

        // Validação
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'salary' => 'required|numeric|min:0', // evita salários negativos
            'category_id' => 'required|integer|exists:category,id',
            'work_model' => 'required|in:Remote,On-site,Hybrid',
            'location' => 'nullable|string|required_unless:work_model,Remote'
        ], [
            'salary.min' => 'Salary cannot be negative.',
            'location.required_unless' => 'Location is required unless the job is Remote.'
        ]);

        // Atualiza os campos
        $jobPost->title = $validated['title'];
        $jobPost->description = $validated['description'];
        $jobPost->salary = $validated['salary'];
        $jobPost->work_model = $validated['work_model'];
        $jobPost->category_id = $validated['category_id'];
        $jobPost->location = $validated['location'] ?? null;


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


    public function search(Request $request)
    {
        $pesquisa = $request->input('q');
        $categoryId = $request->input('category_id');
        $type = $request->input('type');

        $jobPosts = JobPost::query();
        $employers = User::where('role','Employer');

        if ($type === 'search_jobpost') {

            // filtrar por jobpost apenas
            if ($pesquisa) {
                $jobPosts->whereRaw(
                    "tsvectors @@ plainto_tsquery('english', ?)",
                    [$pesquisa]
                )
                ->orderByRaw(
                    "ts_rank(tsvectors, plainto_tsquery('english', ?)) DESC",
                    [$pesquisa]
                );
            }

            // FILTRO DE CATEGORIA
            if ($categoryId && $categoryId !== 'all') {
                $jobPosts->where('category_id', $categoryId);
            }

             // Aqui aplicas a filtragem de employers deletados
            $jobPosts = $jobPosts->with('employer')->get()
                                ->filter(fn($jp) => ! $jp->isOwnerDeleted());

            return view('pages.search_results', [
                'type' => $type,
                'jobPosts' => $jobPosts,
                'employers' => collect(),
                'query' => $pesquisa,
                'selectedCategory' => $categoryId,
                'categories' => Category::all(),
            ]);
        }

        // procurar employers apenas
        if ($pesquisa) {
            $employers->whereRaw(
                "tsvectors @@ plainto_tsquery('english', ?)",
                [$pesquisa]
            )
            ->orderByRaw(
                "ts_rank(tsvectors, plainto_tsquery('english', ?)) DESC",
                [$pesquisa]
            );
        }

        $employers = $employers->get() // transforma em Collection
                       ->filter(fn($user) => ! $user->isDeleted());

        return view('pages.search_results', [
            'type' => $type,
            'jobPosts' => collect(),
            'employers' => $employers,
            'query' => $pesquisa,
            'selectedCategory' => null,
            'categories' => Category::all(),
        ]);
    }

    public function suggestions(Request $request){
        $pesquisa = $request->input('q');
        $type = $request->input('type');


        if(!$pesquisa || strlen($pesquisa)<2 ){   // se n tiver nd ou tiver tamanho inf 2 n vai mostrar nd, o json vai ser vazio
            return response()->json([]);
        }
        
        if($type == 'search_jobpost'){       // procurar por jobposts
            $jobPosts = JobPost::query()
                ->whereRaw("tsvectors @@ plainto_tsquery('english', ?)", [$pesquisa])
                ->orderByRaw("ts_rank(tsvectors, plainto_tsquery('english', ?)) DESC", [$pesquisa])
                ->with('employer') 
                ->limit(5)
                ->get(); //pego em 5 jobposts apenas
        
        
        
            $resultados= $jobPosts
                ->filter(fn($jp) => !$jp->isOwnerDeleted()) 
                ->map(function ($job) {
                    return [
                        'name' => $job->title,
                        'url' => route('jobpost.show', $job->id)
                    ];
                })
                ->values();


            return response()->json($resultados);       // devolve resultados em formato json
        }
        else if($type == 'search_employer'){
            $employers = User::query()
                ->whereRaw("tsvectors @@ plainto_tsquery('english', ?)", [$pesquisa])
                ->orderByRaw("ts_rank(tsvectors, plainto_tsquery('english', ?)) DESC", [$pesquisa])
                ->limit(5)
                ->get();  // pego so em 5 no max


            $resultados= $employers
                ->filter(fn($emp) => !$emp->isDeleted()) 
                ->map(function ($employer) {
                    return [
                        'name' => $employer->name,
                        'url' => route('employer.show', $employer->id)
                    ];
                })
                ->values();

            return response()->json($resultados);       // devolve resultados em formato json
        }
    }

}
