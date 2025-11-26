<?php

namespace App\Policies;

use App\Models\User;
use App\Models\JobPost;

use Illuminate\Support\Facades\Auth;

class JobPostPolicy
{

    public function create(User $user): bool
    {
        // Only authenticated users with the 'Employer' role can create job posts.
        return Auth::check() && $user->role === 'Employer';
    }

    public function delete(User $user, JobPost $jobPost): bool
    {
        // Só o employer pode eliminar o seu proprio jobpost
      return $user->id === $jobPost->employer_id;
    }

    public function update(User $user, JobPost $jobPost): bool
    {
        // Só o employer pode editar o seu proprio jobpost
      return $user->id === $jobPost->employer_id;
    }

    public function apply(User $user, JobPost $jobPost): bool
    {
        // Só Jobseekers podem candidatar-se a jobposts
      return $user->role === 'JobSeeker';
    }

}
