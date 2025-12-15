@extends('layouts.app')

@section('title', 'Admin - Users Management')

@section('content')
<div>
    <h2>Users Management</h2>
    <a href="{{ route('admin.index') }}" class="button button-outline">Back to Admin Dashboard</a>
    <p><strong>Total Users:</strong> {{$userCount}}</p>

    @if($userCount > 0)
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone_number }}</td>
                        <td>{{ $user->role}}</td>
                        <td>
                            <a href="{{ route('profile.other', $user->id) }}" class="button button-outline" style="font-size: 0.8rem;">View Profile</a>
                            <form method="POST" action="{{ route('admin.deleteUser', $user->id) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this user?');">
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
            {{ $users->links() }}
        </div>
    @else
        <p>No users found.</p>
    @endif
</div>
@endsection
