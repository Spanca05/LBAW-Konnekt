@extends('layouts.app')

@section('title', 'Edit Application')

@section('content')
<section class="container">
    <h2>Edit Application for: {{ $application->jobPost->title ?? ('Job #' . ($application->jobpost_id ?? '')) }}</h2>

    @if($errors->any())
        <div class="message error">
            <ul>
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div>
        <span class="salary">Salary:{{ $application->jobPost->salary }}€</span>
        <br>
        <span class="employer">Employer ID: {{ $application->jobPost->employer_id }}</span>
        <br>
        <span class="work_model">Work Model: {{ $application->jobPost->work_model }}</span>
        <br>
        <span class="category">Category ID: {{ $application->jobPost->category_id }}</span>
    </div>
    <p class="description">Description: {{ $application->jobPost->description }} </p>

    <form method="POST" action="{{ route('applications.update', ['application' => $application->id]) }}">
        @csrf
        @method('PUT')

        <label for="motivation">Cover Letter / Motivation</label>
        <textarea id="motivation" name="motivation" rows="8">{{ old('motivation', $application->motivation) }}</textarea>

        <p>
            <button type="submit" class="button">Save</button>
            <a class="button" href="{{ route('profile') }}">Cancel</a>
        </p>
    </form>

    <form method="POST" action="{{ route('applications.destroy', ['application' => $application->id]) }}" onsubmit="return confirm('Withdraw this application?');">
        @csrf
        @method('DELETE')
        <button class="button" type="submit">Withdraw application</button>
    </form>
</section>
@endsection
