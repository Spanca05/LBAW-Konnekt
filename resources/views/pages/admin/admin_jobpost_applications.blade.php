@extends('layouts.app')

@section('title', 'Admin - Applications Management')

@section('content')
<div>
    <h2>Applications Management</h2>
    <a href="{{ route('admin.index') }}" class="button button-outline">Back to Admin Dashboard</a>
    <p><strong>Total Applications:</strong> {{$applicationCount}}</p>

    @if($applicationCount > 0)
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Jobseeker</th>
                    <th>JobPost</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Blocked</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applications as $application)
                    <tr>
                        <td>{{ $application->id }}</td>
                        <td>{{ $application->user->name }}</td>
                        <td>{{ $application->jobPost->title }}</td>
                        <td>{{ $application->status }}</td>
                        <td>{{ $application->date }}</td>
                        <td>
                            @if($application->isBlocked()) Yes
                            @else No
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.application.show', $application->id) }}" class="button button-outline" style="font-size: 0.8rem;">View Application</a>
                            <a href="{{ route('profile.other', $application->jobseeker_id) }}" class="button button-outline" style="font-size: 0.8rem;">View Jobseeker</a>
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
