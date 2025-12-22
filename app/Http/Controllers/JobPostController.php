<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\JobPost;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class JobPostController extends Controller
{

    public function index(Request $request)
    {
        // vai buscar todos os jobposts ordenados do mais recente para o mais antigo
        //$jobPosts = JobPost::orderBy('created_at', 'desc')->get();

        $jobPosts = JobPost::with('employer')
            ->where(function ($q) {
                $q->whereNull('deadline')
                    ->orWhere('deadline', '>', now());
            })
            ->where('blocked', false)
            ->get()
            ->filter(fn($jobPost) => ! $jobPost->isOwnerDeleted())
            ->sortByDesc('created_at');

        return view('pages.jobposts', [
            'jobPosts' => $jobPosts,
        ]);
    }

    public function show($id)
    {
        $jobPost = JobPost::with('jobUser')
            ->findOrFail($id);

        // Preload applications for this job post for the employer view, excluding blocked ones
        $applications = $jobPost->applications()
            ->where('blocked', false)
            ->orderByDesc('date')
            ->get();

        // $name = $jobPost->jobUser->name;

        Gate::authorize('view', $jobPost);

        return view('pages.jobpost', [
            'jobPost' => $jobPost,
            'applications' => $applications,
        ]);
    }

    public function edit($id)
    {
        //$jobPost = JobPost::with('jobLocation')->findOrFail($id);
        $jobPost = JobPost::with('jobCategory')->findOrFail($id);

        Gate::authorize('update', $jobPost);

        $categories = Category::all();


        return view('pages.edit_jobpost', [
            'jobPost' => $jobPost,
            'categories' => $categories
        ]);
    }

    public function create()
    {
        Gate::authorize('create', JobPost::class);
        return view('pages.create_jobpost');
    }

    public function store(Request $request)
    {
        Gate::authorize('create', JobPost::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'salary' => 'required|integer|min:0', // evita salários negativos
            'category_id' => 'required|integer|exists:category,id',
            'work_model' => 'required|in:Remote,On-site,Hybrid',
            'location' => 'nullable|string|required_unless:work_model,Remote',
            'deadline' => 'nullable|date|after:now',
            'contract_type' => 'required|in:Internship,Full-time,Part-time'
        ], [
            'salary.min' => 'Salary cannot be negative.',
            'location.required_unless' => 'Location is required unless the job is Remote.'
        ]);

        $jobPost = new JobPost();

        $jobPost->title = $validated['title'];
        $jobPost->description = $validated['description'];
        $jobPost->salary = $validated['salary'];
        $jobPost->work_model = $validated['work_model'];
        $jobPost->contract_type = $validated['contract_type'];
        $jobPost->category_id = $validated['category_id'];
        $jobPost->deadline = $validated['deadline'];
        $jobPost->employer_id = Auth::id();
        // Explicitly assign location

        //limpar o input da location tirar espaços nas pontas, meter capslock e tirar simbolos estranhos

        $location_ = preg_replace('/[^a-zA-ZÀ-ÿ0-9\s,-]/', '', $validated['location'] ?? '');
        $jobPost->location = Str::title(trim($location_)) ?: null;
        //$jobPost->location = array_key_exists('location', $validated) ? $validated['location'] : $jobPost->location;


        $jobPost->save();

        return redirect()->route('jobpost.show', ['jobpost' => $jobPost->id]);
    }


    public function update(Request $request, $id)
    {

        $jobPost = JobPost::findOrFail($id);
        Gate::authorize('update', $jobPost);


        // Validação
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'salary' => 'required|numeric|min:0', // evita salários negativos
            'category_id' => 'required|integer|exists:category,id',
            'work_model' => 'required|in:Remote,On-site,Hybrid',
            'location' => 'nullable|string|required_unless:work_model,Remote',
            'deadline' => 'nullable|date|after:now',
            'contract_type' => 'required|in:Internship,Full-time,Part-time'
        ], [
            'salary.min' => 'Salary cannot be negative.',
            'location.required_unless' => 'Location is required unless the job is Remote.'
        ]);

        // Atualiza os campos
        $jobPost->title = $validated['title'];
        $jobPost->description = $validated['description'];
        $jobPost->salary = $validated['salary'];
        $jobPost->work_model = $validated['work_model'];
        $jobPost->contract_type = $validated['contract_type'];
        $jobPost->category_id = $validated['category_id'];
        $jobPost->deadline = $validated['deadline'];
        $location_ = preg_replace('/[^a-zA-ZÀ-ÿ0-9\s,-]/', '', $validated['location'] ?? '');
        $jobPost->location = Str::title(trim($location_)) ?: null;
        //$jobPost->location = $validated['location'] ?? null;


        $jobPost->save();

        return redirect()->route('jobpost.show', ['jobpost' => $jobPost->id]);
    }

    public function delete($id)
    {

        $jobPost = JobPost::findOrFail($id);
        Gate::authorize('update', $jobPost);
        $jobPost->notifications()->delete();
        DB::table('jobpost_category')->where('jobpost_id', $jobPost->id)->delete(); // remove dependency
        $nome = $jobPost->title;
        $jobPost->delete();
        return redirect()->route('pages.jobposts.index')->with('success', "JobPost {$nome} Deleted!");
    }


    public function search(Request $request)
    {
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:255'],
            'category_id' => ['nullable', 'integer', 'exists:category,id'],
            'work_model' => ['nullable', Rule::in(['Remote', 'On-site', 'Hybrid', 'all_'])],
            'contract_type' => ['nullable', Rule::in(['Internship', 'Full-time', 'Part-time', 'all'])],
            'type' => ['required', Rule::in(['search_jobpost', 'search_employer'])],
            'ordem' => ['nullable', Rule::in(['relevance', 'Name_A_Z', 'Name_Z_A', 'high', 'low'])],
            'location' => ['nullable', 'string', 'max:255'],
            'min_salary' => ['nullable', 'numeric', 'min:0'],
            'max_salary' => ['nullable', 'numeric', 'min:0'],
        ]);

        $pesquisa = $validated['q'] ?? null;
        $categoryId = $validated['category_id'] ?? null;
        $work_model = $validated['work_model'] ?? null;
        $contract = $validated['contract_type'] ?? null;
        $type = $validated['type'];
        $ordem = $validated['ordem'] ?? null;
        $location = $validated['location'] ?? null;
        $min_salary = $validated['min_salary'] ?? null;
        $max_salary = $validated['max_salary'] ?? null;

        $jobPosts = JobPost::query();
        $employers = User::where('role', 'Employer');

        if ($type === 'search_jobpost') {

            // filtrar por jobpost apenas
            if ($pesquisa) {
                $jobPosts->where(function ($query) use ($pesquisa) {
                    $query->whereRaw("tsvectors @@ plainto_tsquery('english', ?)", [$pesquisa])
                        ->orWhere('title', 'ILIKE', '%' . $pesquisa . '%');
                });

                if (!$ordem || $ordem === 'relevance') {
                    $jobPosts->orderByRaw("ts_rank(tsvectors, plainto_tsquery('english', ?)) DESC", [$pesquisa]);
                }
            }
            // FILTRO DE CATEGORIA
            if ($categoryId && $categoryId !== 'all') {
                $jobPosts->where('category_id', $categoryId);
            }

            //filtrar work model
            if ($work_model && $work_model !== 'all_') {
                $jobPosts->where('work_model', $work_model);
            }

            //filtrar contrato
            if ($contract && $contract !== 'all') {
                $jobPosts->where('contract_type', $contract);
            }

            //filtrar por salario
            if ($max_salary) {
                $jobPosts->where('salary', '<=', $max_salary);
            }

            if ($min_salary) {
                $jobPosts->where('salary', '>=', $min_salary);
            }

            if ($location && $location !== 'all') {
                if ($location === 'no_location') {  // queremos procurar por locations null ou vazio
                    $jobPosts->where(function ($query) {
                        $query->whereNull('location')
                            ->orWhere('location', '');
                    });
                } else $jobPosts->where('location', $location);
            }

            //ordenar por nome ou data
            switch ($ordem) {
                case 'Name_A_Z':
                    $jobPosts->orderby('title', 'asc');
                    break;
                case 'Name_Z_A':
                    $jobPosts->orderby('title', 'desc');
                    break;
                case 'high':
                    $jobPosts->orderBy('salary', 'desc');
                    break;
                case 'low':
                    $jobPosts->orderBy('salary', 'asc');
                    break;
                default:
                    break;
            }

            $locations = JobPost::select('location')
                ->whereNotNull('location')
                ->where('location', '!=', '') // n queremos locations vazias nem null
                ->distinct()    // quer só diferentes
                ->orderBy('location', 'asc')
                ->pluck('location');

            $work_models = JobPost::select('work_model')->orderBy('work_model', 'asc')
                ->distinct()
                ->pluck('work_model');  // buscar tds works da bd

            $contract_type = JobPost::select('contract_type')
                ->distinct()
                ->pluck('contract_type');  // buscar tds contratos da bd são 3    

            // Aqui aplicas a filtragem de employers deletados e jobposts bloqueados
            $jobPosts = $jobPosts->where('blocked', false)
                ->with('employer')
                ->where(function ($q) {
                    $q->whereNull('deadline')
                        ->orWhere('deadline', '>', now());
                })
                ->get()
                ->filter(fn($jp) => ! $jp->isOwnerDeleted());




            return view('pages.search_results', [
                'type' => $type,
                'jobPosts' => $jobPosts,
                'employers' => collect(),
                'query' => $pesquisa,
                'selectedCategory' => $categoryId,
                'ordem' => $ordem,
                'minSalary' => $min_salary,     // salario minimo que o user decidiu
                'maxSalary' => $max_salary,     // salario maximo que o user decidiu
                'selectedLocation' => $location, // a location selecionada no filter
                'selectedWork' => $work_model, // a location selecionada no filter
                'work_models' => $work_models,
                'contract_type' => $contract_type,
                'selectedContract' => $contract,
                'locations' => $locations,      //lista de tds as locations que existem na BD
                'categories' => Category::all(),
            ]);
        }

        // procurar employers apenas
        if ($pesquisa) {
            $employers->where(function ($query) use ($pesquisa) {
                $query->whereRaw("tsvectors @@ plainto_tsquery('english', ?)")
                    ->orWhere('name', 'ILIKE', '%' . $pesquisa . '%');
            });

            if (!$ordem || $ordem === 'relevance') {
                $employers->orderByRaw("ts_rank(tsvectors, plainto_tsquery('english', ?)) DESC", [$pesquisa]);
            }
        }

        if ($location && $location !== 'all') {
            if ($location === 'no_location') {  // queremos procurar por locations null ou vazio
                $employers->where(function ($query) {
                    $query->whereNull('location')
                        ->orWhere('location', '');
                });
            } else $employers->where('location', $location);
        }
        //ordena por nome os employers
        switch ($ordem) {
            case 'Name_A_Z':
                $employers->orderby('name', 'asc');
                break;
            case 'Name_Z_A':
                $employers->orderby('name', 'desc');
                break;
            default:
                break;
        }

        $locations = User::where('role', 'Employer')
            ->whereNotNull('location')
            ->where('location', '!=', '') // n queremos locations vazias nem null
            ->select('location')
            ->distinct()                    // só os diferentes
            ->orderBy('location', 'asc')
            ->pluck('location');


        $employers = $employers->get() // transforma em Collection
            ->filter(fn($user) => ! $user->isDeleted())
            ->filter(fn($user) => ! $user->isBlocked());

        return view('pages.search_results', [
            'type' => $type,
            'jobPosts' => collect(),
            'employers' => $employers,
            'query' => $pesquisa,
            'selectedCategory' => null,
            'ordem' => $ordem,
            'selectedLocation' => $location, // location a filtrar
            'locations' => $locations,          // lista de tds locations da BD
            'categories' => Category::all(),
        ]);
    }

    public function suggestions(Request $request)
    {
        $validated = $request->validate([
            'q' => ['required', 'string', 'min:2', 'max:255'],
            'type' => ['required', Rule::in(['search_jobpost', 'search_employer'])],
        ]);

        $pesquisa = $validated['q'];
        $type = $validated['type'];


        if (!$pesquisa || strlen($pesquisa) < 2) {   // se n tiver nd ou tiver tamanho inf 2 n vai mostrar nd, o json vai ser vazio
            return response()->json([]);
        }

        if ($type == 'search_jobpost') {       // procurar por jobposts
            $jobPosts = JobPost::query()
                ->whereRaw("tsvectors @@ plainto_tsquery('english', ?)", [$pesquisa])
                ->orWhere('title', 'ILIKE', '%' . $pesquisa . '%')
                ->orderByRaw("ts_rank(tsvectors, plainto_tsquery('english', ?)) DESC", [$pesquisa])
                ->with('employer')
                ->limit(5)
                ->get(); //pego em 5 jobposts apenas



            $resultados = $jobPosts
                ->filter(fn($jp) => !$jp->isOwnerDeleted() && !$jp->blocked)
                ->map(function ($job) {
                    return [
                        'name' => $job->title,
                        'url' => route('jobpost.show', $job->id)
                    ];
                })
                ->values();


            return response()->json($resultados);       // devolve resultados em formato json
        } else if ($type == 'search_employer') {
            $employers = User::query()
                ->whereRaw("tsvectors @@ plainto_tsquery('english', ?)", [$pesquisa])
                ->orWhere('name', 'ILIKE', '%' . $pesquisa . '%')   //direct match
                ->orderByRaw("ts_rank(tsvectors, plainto_tsquery('english', ?)) DESC", [$pesquisa])
                ->limit(5)
                ->get();  // pego so em 5 no max


            $resultados = $employers
                ->filter(fn($emp) => !$emp->isDeleted() && !$emp->isBlocked())
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

    public function changeFavourite($jobpostId)
    {
        $user = Auth::user();
        $job = JobPost::findOrFail($jobpostId);

        Gate::authorize('canFavourite', $job);

        // check if it is already favourite
        if ($user->favouriteJobs()->where('jobpost_id', $jobpostId)->exists()) {
            $user->favouriteJobs()->detach($jobpostId);  //remove favourite
            return back()->with('success', 'Removed from favourites.');
        }

        $user->favouriteJobs()->attach($jobpostId);
        return back()->with('success', 'Added to favourites.');
    }
}
