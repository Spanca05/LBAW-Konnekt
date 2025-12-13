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
            
            <ul>
            @foreach ($jobPosts as $jobpost)
                <a href="{{ route('jobpost.show', $jobpost->id) }}">
                    @include('partials.jobpost', ['jobPost' => $jobpost])  
                </a>
            @endforeach
            </ul>
        @else
            @foreach ($employers as $employer)
                <a href="{{ route('employer.show', $employer->id) }}">

                <h2>{{$employer->name}} </h2> </a>
                <p>Location: {{$employer->location}}</p>
                <p>Email: {{$employer->email}}</p>
            @endforeach
        @endif

    @endif
@endsection
