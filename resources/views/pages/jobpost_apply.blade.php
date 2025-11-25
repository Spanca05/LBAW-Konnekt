@extends('layouts.app')

@section('title', 'Apply to Job')

@section('content')
<section class="container">
    <h2>Apply to: {{ $jobPost->title }}</h2>

    @if($errors->any())
        <div class="message error">
            <ul>
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="meta">
        <span class="salary">Salary:{{ $jobPost->salary }}€</span>
        <br>
        <span class="employer">Employer ID: {{ $jobPost->employer_id }}</span>
        <br>
        <span class="work_model">Work Model: {{ $jobPost->work_model }}</span>
        <br>
        <span class="category">Category ID: {{ $jobPost->category_id }}</span>
    </div>
    <p class="description">Description: {{ $jobPost->description }} </p>
    
    <form method="POST" action="{{ route('jobpost.apply', ['jobpost' => $jobPost->id]) }}" enctype="multipart/form-data">
        @csrf

        <label for="motivation">Cover Letter (optional)</label>
        <textarea id="motivation" name="motivation" rows="6">{{ old('motivation') }}</textarea>

        <p>
            <button type="submit" class="button">Submit Application</button>
            <a class="button" href="{{ route('jobpost.show', ['jobpost' => $jobPost->id]) }}">Cancel</a>
        </p>
    </form>
</section>
@endsection
