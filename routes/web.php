<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Public/Home');
})->name('home');

Route::get('/a-propos', function () {
    return Inertia::render('Public/About');
})->name('about');

Route::prefix('/services')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Public/Services');
    })->name('services');

    Route::get('/{slug}', function (string $slug) {
        return Inertia::render('Public/Services', ['slug' => $slug]);
    })->name('services.show');
});

Route::get('/contact', function () {
    return Inertia::render('Public/Contact');
})->name('contact');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
