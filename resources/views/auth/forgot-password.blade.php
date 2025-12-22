@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-body p-4"> <h2 class="card-title text-center mb-4 fw-bold">Forgot your password?</h2>
                    <p class="text-center text-muted mb-4">
                        Enter your email address and we will send you a password reset link.
                    </p>

                    <form method="post" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-1">
                                <label for="email" class="form-label mb-0 me-2">Email</label>
                                
                                <span class="badge rounded-pill bg-secondary" 
                                      data-bs-toggle="tooltip" 
                                      title="You must write the email where you want to receive the link to reset you password"
                                      style="cursor: help;">
                                    ?
                                </span>
                            </div>

                            <input
                                id="email"
                                name="email"
                                type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}"
                                required
                                placeholder="Type here your email"
                            >

                            @error('email')
                                <div class="invalid-feedback" role="alert" id="email-error">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            <button type="submit" class="button w-50">
                                Send password reset link
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection