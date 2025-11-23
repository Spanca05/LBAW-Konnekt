<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobPostController;

    // Home
Route::redirect('/', '/login');


//resultados da pesquisa por jobpost
Route::get('/jobposts/search', [JobPostController::class, 'search'])->name('jobpost.search');

Route::get('/jobposts', [JobPostController::class, 'index'])->name('pages.jobposts.index');
Route::get('/jobposts/{jobpost}', [JobPostController::class, 'show'])->name('jobpost.show');
// pagina formulario criaçao jobpost
Route::get('/create', [JobPostController::class, 'create'])->name('jobpost.create');


// guardar novo jobpost na BD
Route::post('/jobposts', [JobPostController::class, 'store'])->name('jobpost.store');
Route::get('/jobposts/{jobpost}/edit_jobpost', [JobPostController::class, 'edit'])->name('jobpost.edit');
Route::put('/jobposts/{jobpost}', [JobPostController::class, 'update'])->name('jobpost.update');
Route::delete('/jobposts/{jobpost}', [JobPostController::class, 'delete'])->name('jobpost.delete');


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
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
