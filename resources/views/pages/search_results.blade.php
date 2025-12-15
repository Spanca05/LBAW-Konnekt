@extends('layouts.app')

@section('Results')

@section('content')
    @if($query!="")
        <h2>Results for: "{{$query }}"</h2>
    @endif
    

    @if($jobPosts->isEmpty() && $employers->isEmpty())
        @if($type=='search_jobpost')
            <h2>Filter by:</h2>
            <h3>Category</h3>
            <select name="Categories" id="Categories">
                <option value='all'>All</option>
                @foreach($categories as $category)  
                    <option value="{{ $category->id }}" {{ $selectedCategory == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            <h3>Location</h3>
            <select name="location" id="location">
                <option value='all'>All</option>
                @if(empty($location))
                    <option value="no_location" {{ $selectedLocation == 'no_location' ? 'selected' : '' }}>
                    Not specified
                    </option>
                @endif
                @foreach($locations as $location)  
                    <option value="{{ $location }}" {{ $selectedLocation == $location ? 'selected' : '' }}>{{ $location }}</option>
                @endforeach
            </select>
            <h3>Sort by </h3>
            <select name="ordem" id="ordem">
                <option value="relevance" {{ $ordem == 'relevance' ? 'selected' : '' }}>Relevance</option>
                <option value="name_a_z" {{ $ordem == 'Name_A_Z' ? 'selected' : '' }}>Name (A-Z)</option>
                <option value="name_z_a" {{ $ordem == 'Name_Z_A' ? 'selected' : '' }}>Name (Z-A)</option>
                <option value="date_newest" {{ $ordem == 'Newest' ? 'selected' : '' }}>Date (Newest)</option>
                <option value="date_oldest" {{ $ordem == 'Oldest' ? 'selected' : '' }}>Date (Oldest)</option>
            </select>
        @endif
        <p>No results.</p>
    @else
        @if($type=='search_jobpost')
            <h2>Filter by:</h2>
            <h3>Category</h3>
            <select name="Categories" id="Categories">
                <option value='all'>All</option>
                @foreach($categories as $category)  
                    <option value="{{ $category->id }}" {{ $selectedCategory == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            <h3>Location</h3>
            <select name="location" id="location">
                <option value='all'>All</option>
                @if(empty($location))
                    <option value="no_location" {{ $selectedLocation == 'no_location' ? 'selected' : '' }}>
                    Not specified
                    </option>
                @endif
                @foreach($locations as $location)  
                    <option value="{{ $location }}" {{ $selectedLocation == $location ? 'selected' : '' }}>{{ $location }}</option>
                @endforeach
            </select>
            <h3>Sort by:</h3>
            <select name="ordem" id="ordem">
                <option value="relevance" {{ $ordem == 'relevance' ? 'selected' : '' }}>Relevance</option>
                <option value="Name_A_Z" {{ $ordem == 'Name_A_Z' ? 'selected' : '' }}>Name (A-Z)</option>
                <option value="Name_Z_A" {{ $ordem == 'Name_Z_A' ? 'selected' : '' }}>Name (Z-A)</option>
                <option value="Newest" {{ $ordem == 'Newest' ? 'selected' : '' }}>Date (Newest)</option>
                <option value="Oldest" {{ $ordem == 'Oldest' ? 'selected' : '' }}>Date (Oldest)</option>
            </select>
            
            <ul>
            @foreach ($jobPosts as $jobpost)
                <a href="{{ route('jobpost.show', $jobpost->id) }}">
                    @include('partials.jobpost', ['jobPost' => $jobpost])  
                </a>
            @endforeach
            </ul>
        @else
            <h2>Filter by:</h2>
            <h3>Location</h3>
            <select name="location" id="location">
                <option value='all'>All</option>
                @if(empty($location))
                    <option value="no_location" {{ $selectedLocation == 'no_location' ? 'selected' : '' }}>
                    Not specified
                    </option>
                @endif
                @foreach($locations as $location)  
                    <option value="{{ $location }}" {{ $selectedLocation == $location ? 'selected' : '' }}>{{ $location }}</option>
                @endforeach
            </select>
            <h3>Sort by:</h3>
            <select name="ordem" id="ordem">
                <option value="relevance" {{ $ordem == 'relevance' ? 'selected' : '' }}>Relevance</option>
                <option value="Name_A_Z" {{ $ordem == 'Name_A_Z' ? 'selected' : '' }}>Name (A-Z)</option>
                <option value="Name_Z_A" {{ $ordem == 'Name_Z_A' ? 'selected' : '' }}>Name (Z-A)</option>
            </select>
            @foreach ($employers as $employer)
                <a href="{{ route('employer.show', $employer->id) }}">

                <h2>{{$employer->name}} </h2> </a>
                <p>Location: {{$employer->location ?? 'No Location' }}</p>
                <p>Email: {{$employer->email}}</p>
            @endforeach
        @endif

    @endif
@endsection
