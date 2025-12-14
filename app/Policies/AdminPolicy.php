<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AdminPolicy
{
    public function view(User $user): bool
    {
        return ($user->role ?? null) === 'Admin';
    }

    public function createAdmin(User $user) : bool
    {
        return ($user->role ?? null) === 'Admin';
    }

    public function showCreateAdminForm(User $user) : bool
    {
        return ($user->role ?? null) === 'Admin';
    }

    public function listUsers(User $user) : bool
    {
        return ($user->role ?? null) === 'Admin';
    }

    public function deleteUser(User $user) : bool
    {
        return ($user->role ?? null) === 'Admin';
    }

    public function listJobPosts(User $user) : bool
    {
        return ($user->role ?? null) === 'Admin';
    }

    public function deleteJobPost(User $user) : bool
    {
        return ($user->role ?? null) === 'Admin';
    }

    public function listApplications(User $user) : bool
    {
        return ($user->role ?? null) === 'Admin';
    }

    public function deleteApplication(User $user) : bool
    {
        return ($user->role ?? null) === 'Admin';
    }

    public function viewApplication(User $user) : bool
    {
        return ($user->role ?? null) === 'Admin';
    }
}
