    @extends('layouts.app')

    @section('title', 'Admin - JobPosts Management')

    @push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @endpush

    @section('content')
    <div class="container my-5 admin-users-page">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-9">
                
                <h1 class="mb-3">JobPosts Management</h1>
                
                <a href="{{ route('admin.index', ['tab' => 'admin-tools']) }}" class="btn btn-secondary mb-3"style="color:white">Back to Admin Dashboard</a>

                
                <p class="mb-3"><strong>Total JobPosts:</strong> {{$jobpostCount}}</p>

                <div class="card shadow-sm">
                    <div class="card-body p-3">
                        @if($jobpostCount > 0)
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead>
                                    <tr class="fs-3">
                                        <th class="px-4">ID</th>
                                        <th >Title</th>
                                        <th >Employer</th>
                                        <th >Created Date</th>
                                        <th >Status</th>
                                        <th >Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($jobposts as $jobpost)
                                    <tr>
                                        <td class="fs-4 px-4 fw-semibold">{{ $jobpost->id }}</td>
                                        
                                        <td>
                                            <div class="d-flex align-items-center gap-2 fs-4 fw-semibold">
                                                <span>{{ $jobpost->title }}</span>
                                            </div>
                                        </td>

                                        <td class="fs-5">{{ $jobpost->employer->name }}</td>
                                        
                                        <td class="fs-5">{{ $jobpost->created_at->format('Y-m-d') }}</td>
                                        
                                        <td class="fs-5">
                                            @if($jobpost->isBlocked())
                                                <span class="badge bg-danger">Blocked</span>
                                            @else
                                                <span class="badge bg-success bg-opacity-75">Active</span>
                                            @endif
                                        </td>

                                        <td>
                                            <div class="d-flex flex-wrap gap-2 admin-actions" style="letter-spacing: 0.5px;">
                                                
                                                <a href="{{ route('jobpost.show', $jobpost->id) }}" class="button ">
                                                    View Post
                                                </a>

                                                <a href="{{ route('admin.jobpost.applications', $jobpost->id) }}" class="button " style="background-color: cornflowerBlue;">
                                                    Applications
                                                </a>

                                                <form method="POST" action="{{ route('admin.deleteJobPost', $jobpost->id) }}" onsubmit="return confirm('Are you sure you want to delete this jobpost?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="button button-danger button-sm">Delete</button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3 text-center">
                            {{ $jobposts->links() }}
                        </div>
                        @else
                        <div class="p-4 text-center text-muted">
                            <p class="mb-0 fs-5">No jobposts found.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection