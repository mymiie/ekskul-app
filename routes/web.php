<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;

// Public routes
Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

Route::post('/logout', function () {
    auth()->logout();
    return redirect('/login');
})->name('logout');

// User/Siswa routes
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');
    
    Route::get('/ekskul', function () {
        return view('user.ekskul-list');
    })->name('user.ekskul');
    
    Route::get('/my-registrations', function () {
        return view('user.my-registrations');
    })->name('user.registrations');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    Route::get('/ekskul', function () {
        return view('admin.ekskul-management');
    })->name('ekskul');
    
    Route::get('/pendaftaran', function () {
        return view('admin.pendaftaran-management');
    })->name('pendaftaran');
    
    Route::get('/users', function () {
        return view('admin.user-management');
    })->name('users');
});

// Guru routes
Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', function () {
        return view('guru.dashboard');
    })->name('dashboard');
    
    Route::get('/my-ekskul', function () {
        return view('guru.my-ekskul');
    })->name('ekskul');
});

// Shared routes for multiple roles
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');
});