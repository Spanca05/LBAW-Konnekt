<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\JobPostController;
use App\Http\Controllers\CVController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PageController;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;

// Home
Route::redirect('/', '/login');

Route::get('/about', [PageController::class, 'about'])->name('pages.about');
Route::get('/mainFeatures', [PageController::class, 'mainFeatures'])->name('pages.mainFeatures');
Route::get('/contacts', [PageController::class, 'contacts'])->name('pages.contacts');
// Rota para o AJAX das sugestões
Route::get('/api/search/suggestions', [JobPostController::class, 'suggestions'])->name('search.suggestions');
//resultados da pesquisa por jobpost
Route::get('/jobposts/search', [JobPostController::class, 'search'])->name('jobpost.search');
Route::get('/employers/search', [JobPostController::class, 'search'])->name('jobpost.search');

Route::get('/jobposts', [JobPostController::class, 'index'])->name('pages.jobposts.index');

Route::get('/jobposts/create', [JobPostController::class, 'create'])->name('jobpost.create');
Route::get('/jobposts/{jobpost}', [JobPostController::class, 'show'])->name('jobpost.show');
Route::get('/employers/{pro}', [ProfileController::class, 'show'])->name('employer.show');


// guardar novo jobpost na BD
Route::post('/jobposts', [JobPostController::class, 'store'])->name('jobpost.store');
Route::get('/jobposts/{jobpost}/edit', [JobPostController::class, 'edit'])->name('jobpost.edit');
Route::put('/jobposts/{jobpost}', [JobPostController::class, 'update'])->name('jobpost.update');
Route::delete('/jobposts/{jobpost}', [JobPostController::class, 'delete'])->name('jobpost.delete');

// Authentication
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'authenticate');
});

Route::controller(LogoutController::class)->group(function () {
    Route::get('/logout', 'logout')->name('logout');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
});

// Profile (authenticated user)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'showAuth'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CV download/remove (CV uploads handled by profile.update)
    Route::get('/profile/cv/download', [CVController::class, 'download'])->name('profile.cv.download');
    Route::get('/users/{user}/cv/download', [CVController::class, 'downloadOther'])->name('profile.cv.download_other');
    Route::delete('/profile/cv', [CVController::class, 'destroy'])->name('profile.cv.destroy');
    Route::delete('/profile/photo', [ProfileController::class, 'destroyPhoto'])->name('profile.photo.destroy');

    // other users profile (public)
    Route::get('/users/{id}', [ProfileController::class, 'show'])->name('profile.other');
});

// Applications
Route::middleware('auth')->group(function () {
    Route::get('/jobposts/{jobpost}/apply', [ApplicationController::class, 'create'])->name('jobpost.apply.form');
    Route::post('/jobposts/{jobpost}/application', [ApplicationController::class, 'store'])->name('jobpost.apply');
    Route::get('/jobposts/{jobpost}/application', [ApplicationController::class, 'index'])->name('jobpost.application'); // employer view
    // Jobseeker application management
    Route::get('/applications/{application}/edit', [ApplicationController::class, 'edit'])->name('applications.edit');
    Route::put('/applications/{application}', [ApplicationController::class, 'update'])->name('applications.update');
    Route::delete('/applications/{application}', [ApplicationController::class, 'destroy'])->name('applications.destroy');
    // Employer: update application status (Accept / Reject)
    Route::patch('/applications/{application}/status', [ApplicationController::class, 'status_update'])->name('applications.status.update');
});

// Admin dashboard
Route::middleware('auth')->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/create-admin', [AdminController::class, 'showCreateAdminForm'])->name('admin.create.form');
    Route::post('/admin/create-admin', [AdminController::class, 'createAdmin'])->name('admin.create');

    Route::get('/admin/users', [AdminController::class, 'listUsers'])->name('admin.users');
    Route::delete('/admin/users/{userId}', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');

    Route::get('/admin/jobposts', [AdminController::class, 'listJobPosts'])->name('admin.jobposts');
    Route::delete('/admin/jobposts/{jobpostId}', [AdminController::class, 'deleteJobPost'])->name('admin.deleteJobPost');

    Route::get('/admin/applications', [AdminController::class, 'listApplications'])->name('admin.applications');
    Route::get('/admin/jobposts/{jobpostId}/applications', [AdminController::class, 'listJobpostApplications'])->name('admin.jobpost.applications');
    Route::get('/admin/applications/{applicationId}', [AdminController::class, 'showApplication'])->name('admin.application.show');
    Route::delete('/admin/applications/{applicationId}', [AdminController::class, 'deleteApplication'])->name('admin.deleteApplication');
});

// Recover Password
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::ResetLinkSent
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );

    return $status === Password::PasswordReset
        ? redirect()->route('login')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');