<?php

namespace App\Policies;

use App\Models\User;

use Illuminate\Support\Facades\Auth;

class UserPolicy
{

    public function viewProfile(User $authUser, User $profile): bool
    {
        return !$profile->isDeleted() && $authUser->id === $profile->id;
    }

    public function viewPublic(User $authUser, User $profile): bool
    {
        return !$profile->isDeleted();
    }

    public function update(User $authUser, User $profile): bool
    {
      return !$profile->isDeleted() && $authUser->id === $profile->id;
    }

}
