@extends('layouts.app')

@section('title', 'Admin - Users Management')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')
<div class="container my-5 admin-users-page">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-9">
            <h1 class="mb-3">Users Management</h1>
            <a href="{{ route('admin.index') }}" class="button button-outline mb-3">Back to Admin Dashboard</a>
            <p class="mb-3"><strong>Total Users:</strong> {{$userCount}}</p>

            <div class="card shadow-sm">
                <div class="card-body p-3">
                    @if($userCount > 0)
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <span>{{ $user->name }}</span>
                                            <span class="badge jobpost-badge-soft">{{ $user->role }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone_number }}</td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-2 admin-actions">
                                            <a href="{{ route('profile.other', $user->id) }}" class="button button-sm">View Profile</a>
                                            <form method="POST" action="{{ route('admin.deleteUser', $user->id) }}" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="button button-danger button-sm">Delete</button>
                                            </form>
                                            @if($user->role !== 'Admin')
                                            @if($user->isBlocked())
                                            <form method="POST" action="{{ route('admin.unblockUser', $user->id) }}">
                                                @csrf
                                                <button type="submit" class="button button-success button-sm">Unblock</button>
                                            </form>
                                            @else
                                            <details>
                                                <summary>
                                                    <span class="button button-danger button-sm">Block</span>
                                                </summary>
                                                <div class="mt-2 d-flex align-items-start gap-2 flex-wrap">
                                                    <form method="POST" action="{{ route('admin.blockUser', $user->id) }}" class="d-flex gap-2 align-items-start flex-wrap">
                                                        @csrf
                                                        <label for="block-reason-{{ $user->id }}" class="sr-only">Reason</label>
                                                        <textarea id="block-reason-{{ $user->id }}" class="block-reason" name="reason" rows="3" required maxlength="500" placeholder="Enter reason for blocking"></textarea>
                                                        <button type="submit" class="button button-danger button-sm" style="white-space: nowrap;">Confirm Block</button>
                                                    </form>
                                                </div>
                                            </details>
                                            @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3 text-center">
                        {{ $users->links() }}
                    </div>
                    @else
                    <p class="mb-0">No users found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection