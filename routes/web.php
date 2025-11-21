<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\JobPostController;
use App\Http\Controllers\ItemController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;

// Home
Route::redirect('/', '/login');

// JobPosts (authentication required)
Route::middleware('auth')->controller(JobPostController::class)->group(function () {
    Route::get('/jobposts', 'index')->name('jobposts.index');
    Route::get('/jobposts/{jobpost}', 'show')->name('jobposts.show');
});


// API (authentication required) - JobPosts
Route::middleware('auth')->controller(JobPostController::class)->group(function () {
    Route::post('/api/jobposts', 'store');              // create jobpost
    Route::delete('/api/jobposts/{jobpost}', 'destroy');   // delete jobpost
});

Route::middleware('auth')->controller(ItemController::class)->group(function () {
    Route::post('/api/jobposts/{jobpost}/items', 'store'); // add item to jobpost
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
