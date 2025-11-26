@extends('layouts.app')

@section('Results')

@section('content')
    <h2>Results for: "{{$query }}"</h2>

    @if($jobPosts->isEmpty() && $employers->isEmpty())
        @if($type=='search_jobpost')
            <h2>Filtrar por:</h2>
            <select name="Categories" id=""Categories>
                <option value='all'>All</option>
                @foreach($categories as $category)  
                    <option value="{{ $category->id }}" {{ $selectedCategory == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            <button id="filter_button" class="filter_button">Filter</button>
        @endif
        <p>No results.</p>
    @else
        @if($type=='search_jobpost')
            <h2>Filtrar por:</h2>
            <select name="Categories" id=""Categories>
                <option value='all'>All</option>
                @foreach($categories as $category)  
                    <option value="{{ $category->id }}" {{ $selectedCategory == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            <button id="filter_button" class="filter_button">Filter</button>
            <ul>
            @foreach ($jobPosts as $jobpost)
                <a href="{{ route('jobpost.show', $jobpost->id) }}">
                    @include('partials.jobpost', ['jobPost' => $jobpost])  
                </a>
            @endforeach
            </ul>
        @else
            @foreach ($employers as $employer)

                {{--<a href="{{ route('profile.show', $employer->id) }}">--}}

                <h2>{{$employer->name}} </h2>
                <p>Email: {{$employer->email}}</p>
            @endforeach
        @endif

    @endif
@endsection
