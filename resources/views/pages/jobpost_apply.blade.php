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
