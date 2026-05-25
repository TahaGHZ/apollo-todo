<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
// import projects controller
use App\Http\Controllers\ProjectController;
//import tasks controlelr
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('projects.index');
    }

    return view('welcome');
});

// I removed the email verification to make access easier for testing purposes.
Route::get('/dashboard', function () {
    return redirect()->route('projects.index');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //projects routes
    Route::resource('projects', ProjectController::class);
    //tasks routes
    Route::resource('projects.tasks', TaskController::class)
        ->except(['index', 'create', 'show']);

});

// Load the auth routes from routes/auth.php file (auth handled by Laravel Breeze)
require __DIR__.'/auth.php';
