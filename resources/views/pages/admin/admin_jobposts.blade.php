@extends('layouts.app')

@section('title', 'Admin - JobPosts Management')

@section('content')
<div>
    <h2>JobPosts Management</h2>
    <a href="{{ route('admin.index') }}" class="button button-outline">Back to Admin Dashboard</a>
    <p><strong>Total JobPosts:</strong> {{$jobpostCount}}</p>
    @if($jobpostCount > 0)
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Employer</th>
                    <th>Created Date</th>
                    <th>Blocked</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jobposts as $jobpost)
                    <tr>
                        <td>{{ $jobpost->id }}</td>
                        <td>{{ $jobpost->title }}</td>
                        <td>{{ $jobpost->employer->name }}</td>
                        <td>{{ $jobpost->created_at->format('Y-m-d') }}</td>
                        <td>
                            @if($jobpost->isBlocked()) Yes
                            @else No
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('jobpost.show', $jobpost->id) }}" class="button button-outline" style="font-size: 0.8rem;">View JobPost</a>
                            <a href="{{ route('admin.jobpost.applications', $jobpost->id) }}" class="button button-outline" style="font-size: 0.8rem;">View Applications</a>
                            <form method="POST" action="{{ route('admin.deleteJobPost', $jobpost->id) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this jobpost?');">
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
            {{ $jobposts->links() }}
        </div>
    @else
        <p>No jobposts found.</p>
    @endif
</div>
@endsection
