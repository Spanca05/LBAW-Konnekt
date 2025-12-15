<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<style>
    /* Contentor da pesquisa */
    .search {
        position: relative; /* Importante para a lista flutuar relativa a isto */
        display: block;
        width: 100%;
    }

    /* Caixa de sugestões */
    #sugestions {
        display: none; /* Escondido por defeito */
        position: absolute;
        top: 100%;       /* Logo abaixo do input */
        left: 0;
        width: 100%;     /* Largura igual ao input */
        
        background-color: #ffffff;
        border: 1px solid #d2afe7; /* Cor da borda igual ao teu tema */
        border-radius: 0 0 4px 4px;
        
        z-index: 10000;  /* Muito alto para ficar por cima do resto */
        box-shadow: 0 4px 8px rgba(0,0,0,0.1); /* Sombra para dar profundidade */
        
        max-height: 300px; /* Se houver muitos, ganha scroll, não cresce infinito */
        overflow-y: auto;  /* Scroll vertical */
    }

    /* Estilo da lista */
    #sugestions ul { 
        list-style: none; 
        padding: 0; 
        margin: 0; 
    }
    
    #sugestions li { 
        border-bottom: 1px solid #eee; 
        margin: 0; /* Override do Milligram */
    }
    
    #sugestions li:last-child {
        border-bottom: none;
    }

    #sugestions a { 
        text-decoration: none; 
        color: #9b4dca; /* Tua cor roxa */
        display: block;
        padding: 10px;
        transition: background 0.2s;
    }
    
    #sugestions li:hover { 
        background-color: #f4eef9; /* Roxo muito clarinho ao passar o rato */
    }
</style>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Laravel'))</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/milligram.css') }}">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        @stack('styles')

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="{{ asset('js/register.js') }}" defer></script>
        <script src="{{ asset('js/search_bar.js') }}"defer ></script>
        @stack('scripts')
    </head>
    <body>
        <main>
            <header>
                <h1><a href="{{ route('pages.jobposts.index') }}">Konnekt!</a></h1>
                @auth
                    <a class="button" href="{{ url('/logout') }}">Logout </a>
                    @if((Auth::user()->role ?? null) === 'Admin')
                        <a class="button" href="{{ route('admin.index') }}">{{Auth::user()->name}}</a>
                    @else
                        <a class="button" href="{{ route('profile') }}">{{ Auth::user()->name }}</a>
                    @endif
                @else
                    <a class="button button-outline" href="{{ route('register') }}">Register</a> <a class="button" href="{{ route('login') }}">Login</a>
                @endauth
                @if(Route::currentRouteName() !== 'login' and Route::currentRouteName() !=='register' and Route::currentRouteName() !== 'password.request' and Route::currentRouteName() !== 'password.reset')
                <div class="search">
                    <input type="text" id="search" class="search" placeholder="Search jobposts...">
                    <div class="sugestions" id="sugestions" style="display: none;"></div>
                    <select class="search_type" id="search_type">
                        <option value="search_jobpost"{{ (isset($type) && $type == 'search_jobpost') ? 'selected' : '' }}>Job Posts</option>
                        <option value="search_employer"{{ (isset($type) && $type == 'search_employer') ? 'selected' : '' }}>Employers</option>
                    </select>
                        
                    <button id="search_button" class="search_button">Search</button>
                </div>

                @endif
            </header>

            <section id="content">
                @yield('content')
            </section>
        </main>
    </body>
@if(Route::currentRouteName() !== 'login' and Route::currentRouteName() !=='register' and Route::currentRouteName() !== 'password.request' and Route::currentRouteName() !== 'password.reset')
    @include('partials.footer')
@endif
</html>