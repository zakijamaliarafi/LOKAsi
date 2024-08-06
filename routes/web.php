<?php

use Illuminate\Support\Facades\Route;

// Home page
Route::view('/', 'dashboard')
    ->middleware(['auth'])
    ->name('home');

// Dashboard page
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Profile page
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Waiting page
Route::view('waiting', 'waiting')
    ->middleware(['guest'])
    ->name('waiting');

// Manage User page
Route::view('user/manage', 'user')
    ->middleware(['auth', 'role:admin'])
    ->name('user.manage');

// Verify Report page
Route::view('verify', 'verify')
    ->middleware(['auth', 'role:curator|coordinator'])
    ->name('verify');

// view verify report
Route::view('verify/view', 'view-verify')
    ->middleware(['auth', 'role:curator|coordinator'])
    ->name('verify.view');

// Manage Location page
Route::get('location/manage', function () {
    return 'This page for manage location';
})->middleware(['auth', 'role:coordinator|admin']);

// Map
Route::view('map', 'map')
    ->middleware(['auth'], 'role:user|contributor|curator|coordinator|admin')
    ->name('map');

require __DIR__.'/auth.php';
