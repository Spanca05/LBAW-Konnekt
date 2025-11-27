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
}
