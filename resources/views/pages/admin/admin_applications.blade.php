@extends('layouts.app')

@section('title', 'Admin - Applications Management')

@section('content')
<div>
    <h2>Applications</h2>
    <a href="{{ route('admin.jobposts') }}" class="button button-outline">Back to JobPosts Management</a>
    <p><strong>Total Applications:</strong> {{$applicationCount}}</p>
    @if($applicationCount > 0)
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Jobseeker</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applications as $application)
                    <tr>
                        <td>{{ $application->id }}</td>
                        <td>{{ $application->user->name ?? 'N/A' }}</td>
                        <td>{{ $application->status }}</td>
                        <td>{{ $application->date }}</td>
                        <td>
                            <a href="{{ route('admin.application.show', $application->id) }}" class="button button-outline" style="font-size: 0.8rem;">View Application</a>
                            <a href="{{ route('profile.other', $application->jobseeker_id) }}" class="button button-outline" style="font-size: 0.8rem;">View Jobseeker</a>
                            <a href="{{ route('jobpost.show', $application->jobpost_id) }}" class="button button-outline" style="font-size: 0.8rem;">View JobPost</a>
                            <form method="POST" action="{{ route('admin.deleteApplication', $application->id) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this application?');">
                                @csrf
                                @method('DELETE')
                                <button>Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination Links -->
        <div style="margin-top: 2rem; text-align: center;">
            {{ $applications->links() }}
        </div>
    @else
        <p>No applications found.</p>
    @endif
</div>
@endsection
