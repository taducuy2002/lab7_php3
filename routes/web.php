<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



// Route::middleware('auth')->get('/profile', [ProfileController::class, 'show'])->name('profile');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile/detail', [AuthController::class, 'showProfile'])->name('profile.show');
    Route::get('/profile/edit/{id}', [AuthController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/edit/{id}', [AuthController::class, 'updateProfile']);
    Route::get('/password/change', [AuthController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/password/change', [AuthController::class, 'changePassword']);
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users');
    Route::post('/admin/users/{id}/toggle', [AdminController::class, 'toggleActive']);
});

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Register - Login - Logout
Route::get('/login', [AuthController::class, 'login'])->name('login');

Route::post('/login', [AuthController::class, 'postLogin']);

Route::get('/register', [AuthController::class, 'register'])->name('register');

Route::post('/register', [AuthController::class, 'postRegister']);

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
