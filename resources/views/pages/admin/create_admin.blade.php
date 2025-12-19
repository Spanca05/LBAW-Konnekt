@extends('layouts.app')

@section('title', 'Create Admin Account')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')
<div class="container my-5 admin-users-page">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <a href="{{ route('admin.index', ['tab' => 'admin-tools']) }}" class="button button-outline mb-3" style="text-decoration: none;">
                ← Back to Admin Dashboard
            </a>

            <div class="card shadow-sm">
                <div class="card-header bg-blue border-bottom">
                    <h2 class="mb-0" style="color: #213448; font-weight: 600;">Create Admin Account</h2>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ url('/admin/create-admin') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="admin_name" class="form-label fw-semibold" style="color: #213448;">Username</label>
                            <input id="admin_name" name="name" type="text" placeholder="Enter username" required class="form-control" />
                        </div>

                        <div class="mb-4">
                            <label for="admin_email" class="form-label fw-semibold" style="color: #213448;">Email</label>
                            <input id="admin_email" name="email" type="email" placeholder="admin@example.com" required class="form-control" />
                        </div>

                        <div class="mb-4">
                            <label for="admin_phone" class="form-label fw-semibold" style="color: #213448;">Phone</label>
                            <input id="admin_phone" name="phone_number" type="text" placeholder="123456789" required class="form-control" />
                        </div>

                        <div class="mb-4">
                            <label for="admin_password" class="form-label fw-semibold" style="color: #213448;">Password</label>
                            <input id="admin_password" name="password" type="password" placeholder="Enter password" required class="form-control" />
                        </div>

                        <button class="button button-lg" type="submit">Create Admin</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection