<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Policies\AdminPolicy;

class AdminController extends Controller
{

    public function index()
    {
        Gate::policy(Admin::class, AdminPolicy::class);
        Gate::authorize('view', Admin::class);

        $user = Auth::user();
        $userCount = User::count();

        return view('pages.admin', [
            'admin' => $user,
            'userCount' => $userCount,
        ]);
    }

    public function createAdmin(Request $request)
    {
        Gate::policy(Admin::class, AdminPolicy::class);
        Gate::authorize('createAdmin', Admin::class);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users,name'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone_number' => ['required', 'string', 'max:32'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'password' => Hash::make($data['password']),
            'role' => 'Admin',
        ]);

        return redirect()->route('admin.index')->with('success', 'Admin account created.');
    }
}
