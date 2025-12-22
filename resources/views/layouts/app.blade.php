<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/milligram.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')

    <!-- Scripts -->
    @vite(['resources/js/app.js'])
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/register.js') }}" defer></script>
    <script src="{{ asset('js/search_bar.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    @stack('scripts')
</head>

<body>
    <main>
        <header class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
            <h1 class="m-0 flex-shrink-0"><a href="{{ route('pages.jobposts.index') }}">Konnekt!</a></h1>

            @if(Route::currentRouteName() !== 'login' and Route::currentRouteName() !=='register' and Route::currentRouteName() !== 'password.request' and Route::currentRouteName() !== 'password.reset')
            <div class="search d-flex align-items-center gap-2 flex-nowrap">
                <input type="text" id="search" placeholder="Search">
                <div class="sugestions" id="sugestions" style="display: none;"></div>
                <select id="search_type">
                    <option value="search_jobpost" {{ (isset($type) && $type == 'search_jobpost') ? 'selected' : '' }}>Job Posts</option>
                    <option value="search_employer" {{ (isset($type) && $type == 'search_employer') ? 'selected' : '' }}>Employers</option>
                </select>
                <a id="search_button" class="button">Search</a>
            </div>
            @endif
            <div class="d-flex align-items-center gap-2 flex-shrink-0">

                @auth
                <a class="button button-outline" href="{{ route('notifications.index') }}"> 🔔 Notifications
                    @if($unreadNotifications > 0)
                    <span class="badge">{{ $unreadNotifications }}</span>
                    @endif
                </a>
                @if((Auth::user()->role ?? null) === 'Admin')
                <a class="button" href="{{ route('admin.index') }}">{{Auth::user()->name}}</a>
                @else
                <a class="button" href="{{ route('profile') }}">{{ Auth::user()->name }}</a>
                @endif
                <a class="button" href="{{ url('/logout') }}">Logout </a>
                @else
                <a class="button button-outline" href="{{ route('register') }}">Register</a> <a class="button" href="{{ route('login') }}">Login</a>
                @endauth
            </div>
        </header>

        <section id="content">
            @yield('content')
        </section>
        @if(Route::currentRouteName() !== 'login' and Route::currentRouteName() !=='register' and Route::currentRouteName() !== 'password.request' and Route::currentRouteName() !== 'password.reset')
        @include('partials.footer')
        @endif
    </main>
</body>

</html>