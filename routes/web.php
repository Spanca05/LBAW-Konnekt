<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CardController;
use App\Http\Controllers\ItemController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\JobPostController;
use App\Http\Controllers\CVController;
use App\Http\Controllers\ApplicationController;

// Home
Route::redirect('/', '/login');

Route::get('/jobposts', [JobPostController::class, 'index'])->name('pages.jobposts.index');
// pagina formulario criaçao jobpost
Route::get('/jobposts/create', [JobPostController::class, 'create'])->name('jobpost.create');
// guardar novo jobpost na BD
Route::post('/jobposts', [JobPostController::class, 'store'])->name('jobpost.store');
//Route::get('/jobposts/{jobpost}/edit_jobpost', [JobPostController::class, 'edit'])->name('jobpost.edit');
//Route::put('/jobposts/{jobpost}', [JobPostController::class, 'update'])->name('jobpost.update');
//Route::delete('/jobposts/{jobpost}', [JobPostController::class, 'delete'])->name('jobpost.delete');
Route::get('/jobposts/{jobpost}/edit', [JobPostController::class, 'edit'])->name('jobpost.edit');
Route::put('/jobposts/{jobpost}', [JobPostController::class, 'update'])->name('jobpost.update');
Route::delete('/jobposts/{jobpost}', [JobPostController::class, 'delete'])->name('jobpost.delete');
Route::get('/jobposts/{jobpost}', [JobPostController::class, 'show'])->name('jobpost.show');




//Route::get('/cards', [CardController::class, 'index'])->name('cards.index');
//Route::get('/cards/{card}', [CardController::class, 'show'])->name('cards.show');


// Cards (authentication required)
Route::middleware('auth')->controller(CardController::class)->group(function () {
    Route::get('/cards', 'index')->name('cards.index');
    Route::get('/cards/{card}', 'show')->name('cards.show');
});


// API (authentication required)
Route::middleware('auth')->controller(CardController::class)->group(function () {
    Route::post('/api/cards', 'store');              // create card
    Route::delete('/api/cards/{card}', 'destroy');   // delete card
});

Route::middleware('auth')->controller(ItemController::class)->group(function () {
    Route::post('/api/cards/{card}/items', 'store'); // add item to card
    Route::patch('/api/items/{item}', 'update');     // update item
    Route::delete('/api/items/{item}', 'destroy');   // delete item
});

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
    Route::delete('/profile/cv', [CVController::class, 'destroy'])->name('profile.cv.destroy');
    Route::delete('/profile/photo', [ProfileController::class, 'destroyPhoto'])->name('profile.photo.destroy');

    // other users profile (public)
    Route::get('/users/{id}', [ProfileController::class, 'show'])->name('profile.other');
});

// Applications
Route::middleware('auth')->group(function() {
    Route::get('/jobposts/{jobpost}/apply', [ApplicationController::class,'create'])->name('jobpost.apply.form');
    Route::post('/jobposts/{jobpost}/application', [ApplicationController::class,'store'])->name('jobpost.apply');
    Route::get('/jobposts/{jobpost}/application', [ApplicationController::class,'index'])->name('jobpost.application'); // employer view
    // Jobseeker application management
    Route::get('/applications/{application}/edit', [ApplicationController::class, 'edit'])->name('applications.edit');
    Route::put('/applications/{application}', [ApplicationController::class, 'update'])->name('applications.update');
    Route::delete('/applications/{application}', [ApplicationController::class, 'destroy'])->name('applications.destroy');
});
