<?php

declare(strict_types=1);

use App\Http\Controllers\IdeaController;
use App\Http\Controllers\IdeaImageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\StepController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('ideas');
    // return view('welcome');
});

Route::middleware('guest')->group(function (): void {
    Route::get('/register', [RegisterUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisterUserController::class, 'store'])->name('register.store');
    Route::get('/login', [SessionController::class, 'create'])->name('login');
    Route::post('/login', [SessionController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function (): void {
    Route::delete('/logout', [SessionController::class, 'destroy'])->name('logout');

    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/ideas', [IdeaController::class, 'index'])->name('ideas');
    Route::post('/ideas', [IdeaController::class, 'store'])->name('idea.store');
    Route::get('/ideas/{idea}', [IdeaController::class, 'show'])->name('idea.show')->can('modify', 'idea');
    Route::patch('/ideas/{idea}', [IdeaController::class, 'update'])->name('idea.update')->can('modify', 'idea');
    Route::delete('/ideas/{idea}', [IdeaController::class, 'destroy'])->name('idea.destroy')->can('modify', 'idea');

    Route::delete('/ideas/{idea}/image', [IdeaImageController::class, 'destroy'])->name('idea.image.destroy')->can('modify', 'idea');

    Route::patch('/steps/{step}', [StepController::class, 'update'])->name('step.update');
});
