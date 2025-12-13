<?php

namespace App\Policies;

use App\Models\Application;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ApplicationPolicy
{
    use HandlesAuthorization; 
    
    public function view(User $user, Application $application): bool
    {
        return $user->id === $application->jobseeker_id;
    }

    
    public function create(User $user): bool
    {
        return $user->role === 'JobSeeker';
    }

    public function edit(User $user, Application $application): bool
    {
        return $user->id === $application->jobseeker_id;
    }

    public function update(User $user, Application $application): bool
    {
        return $user->id === $application->jobseeker_id;
    }

    public function delete(User $user, Application $application): bool
    {
        return $user->id === $application->jobseeker_id;
    }

    public function status_update(User $user, Application $application): bool
    {
        return $user->id === $application->jobPost->employer_id;
    }

    //public function viewApplications(U)

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Application $application): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Application $application): bool
    {
        return false;
    }
}
