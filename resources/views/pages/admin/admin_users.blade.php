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
                            @if($user->role !== 'Admin')
                                @if($user->isBlocked())
                                    <form method="POST" action="{{ route('admin.unblockUser', $user->id) }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="button" style="background: #1b5e20; color: #fff; font-size: 0.8rem;">Unblock</button>
                                    </form>
                                @else
                                    <details style="display: inline-block; margin-right: 0.25rem;">
                                        <summary style="cursor: pointer; list-style: none;">
                                            <span class="button" style="background: #b00020; color: #fff; font-size: 0.8rem; display: inline-block;">Block</span>
                                        </summary>
                                            <div style="display: flex; align-items: flex-start; gap: 0.5rem; margin-top: 0.5rem;">
                                                <form method="POST" action="{{ route('admin.blockUser', $user->id) }}" style="display: flex; gap: 0.5rem; align-items: flex-start; flex-wrap: wrap;">
                                                    @csrf
                                                    <label for="block-reason-{{ $user->id }}" class="sr-only" style="position: absolute; left: -9999px;">Reason</label>
                                                    <textarea id="block-reason-{{ $user->id }}" name="reason" rows="3" style="width: 240px; min-width: 200px; margin: 0;" required maxlength="500" placeholder="Enter reason for blocking"></textarea>
                                                    <button type="submit" class="button" style="background: #b00020; color: #fff; font-size: 0.8rem; white-space: nowrap;">Confirm Block</button>
                                                </form>
                                            </div>
                                    </details>
                                @endif
                            @endif
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
