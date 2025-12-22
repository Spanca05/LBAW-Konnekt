@extends('layouts.app')

@section('title', 'Create Admin Account')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')
<div class="container my-5 admin-users-page">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-6">

            <div class="card rounded-3 shadow">
                <div class="card-body p-4 p-md-5">

                    <h1 class="mb-4 text-center">Create Admin Account</h1>

                    <form method="POST" action="{{ url('/admin/create-admin') }}">
                        @csrf

                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label for="admin_name" class="form-label">Username</label>
                                <input id="admin_name" name="name" type="text" placeholder="Enter username" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required />
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="admin_email" class="form-label">Email</label>
                                <input id="admin_email" name="email" type="email" placeholder="admin@example.com" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required />
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="admin_phone" class="form-label">Phone</label>
                                <input id="admin_phone" name="phone_number" type="tel" placeholder="123456789" class="form-control @error('phone_number') is-invalid @enderror" value="{{ old('phone_number') }}" required />
                                @error('phone_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="admin_password" class="form-label">Password</label>
                                <input id="admin_password" name="password" type="password" placeholder="Enter password" class="form-control @error('password') is-invalid @enderror" required />
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="d-flex flex-column flex-md-row justify-content-md-center align-items-center gap-3 mt-4">
                            
                            <button class="button fw-bold px-5 py-2 fs-5 text-nowrap w-100 w-md-auto" style="letter-spacing: 1px;" type="submit">
                                Create Admin
                            </button>
                            
                            <a href="{{ route('admin.index', ['tab' => 'admin-tools']) }}" 
                               class="button button-outline fw-bold px-5 py-2 fs-5 text-nowrap d-inline-flex align-items-center justify-content-center text-decoration-none w-100 w-md-auto"
                               style="letter-spacing: 1px;">
                                Cancel
                            </a>

                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection