<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CV;

class CVPolicy {
    /**
     * Determine whether the user can view the CV.
     */
    public function view(User $user, CV $cv) {
        // Only the owner (jobseeker) may view their CV
        return ($user->role ?? null) === 'JobSeeker' && $cv->jobseeker_id === $user->id;
    }

    /**
     * Determine whether the user can create/upload a CV.
     */
    public function create(User $user) {
        return ($user->role ?? null) === 'JobSeeker';
    }

    /**
     * Determine whether the user can delete the CV.
     */
    public function delete(User $user, CV $cv) {
        return ($user->role ?? null) === 'JobSeeker' && $cv->jobseeker_id === $user->id;
    }

    /**
     * Determine whether the user can update the CV (e.g., change description or replace file).
     */
    public function update(User $user, CV $cv) {
        return ($user->role ?? null) === 'JobSeeker' && $cv->jobseeker_id === $user->id;
    }
}
