<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CardController;
use App\Http\Controllers\ItemController;

use App\Http\Controllers\HomeController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;

// Home
Route::redirect('/', '/login');

Route::get('/jobposts', [App\Http\Controllers\JobPostController::class, 'index'])->name('pages.jobposts.index');
Route::get('/jobposts/{jobpost}', [App\Http\Controllers\JobPostController::class, 'show'])->name('jobpost.show');

//Route::get('/cards', [CardController::class, 'index'])->name('cards.index');
//Route::get('/cards/{card}', [CardController::class, 'show'])->name('cards.show');




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
