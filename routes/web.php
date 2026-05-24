<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProblemController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// 1. Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/explore', [ProblemController::class, 'index'])->name('problems.index');
Route::get('/problems/{id}', [ProblemController::class, 'show'])->name('problems.show');
Route::get('/seed-database', function() {
    \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
    return 'Database seeded successfully!';
});

// 2. Guest-only Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// 3. Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Problems CRUD
    Route::get('/problems/create/new', [ProblemController::class, 'create'])->name('problems.create');
    Route::post('/problems', [ProblemController::class, 'store'])->name('problems.store');
    Route::get('/problems/{id}/edit', [ProblemController::class, 'edit'])->name('problems.edit');
    Route::put('/problems/{id}', [ProblemController::class, 'update'])->name('problems.update');
    Route::delete('/problems/{id}', [ProblemController::class, 'destroy'])->name('problems.destroy');
    Route::post('/problems/{id}/solved', [ProblemController::class, 'toggleSolved'])->name('problems.solved');

    // Answers CRUD
    Route::post('/problems/{problem_id}/answers', [AnswerController::class, 'store'])->name('answers.store');
    Route::put('/answers/{id}', [AnswerController::class, 'update'])->name('answers.update');
    Route::delete('/answers/{id}', [AnswerController::class, 'destroy'])->name('answers.destroy');
});

// 4. Admin-only Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Admin Category CRUD
    Route::get('/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
    Route::put('/categories/{id}', [AdminController::class, 'updateCategory'])->name('admin.categories.update');
    Route::delete('/categories/{id}', [AdminController::class, 'destroyCategory'])->name('admin.categories.destroy');

    // Admin User CRUD
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/users/{id}/role', [AdminController::class, 'toggleUserRole'])->name('admin.users.role');
    Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

    // Content moderation
    Route::get('/content', [AdminController::class, 'content'])->name('admin.content');
});
