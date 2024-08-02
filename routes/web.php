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

// View Hostelry map
Route::view('map/hostelry', 'map.hostelry')
    ->middleware(['auth'], 'role:user|contributor|curator|coordinator|admin')
    ->name('map.hostelry');

// View culinary map
Route::view('map/culinary', 'map.culinary')
    ->middleware(['auth'], 'role:user|contributor|curator|coordinator|admin')
    ->name('map.culinary');

// View schools map
Route::view('map/schools', 'map.schools')
    ->middleware(['auth'], 'role:user|contributor|curator|coordinator|admin')
    ->name('map.schools');

// View office map
Route::view('map/office', 'map.office')
    ->middleware(['auth'], 'role:user|contributor|curator|coordinator|admin')
    ->name('map.office');

// View worship map
Route::view('map/worship', 'map.worship')
    ->middleware(['auth'], 'role:user|contributor|curator|coordinator|admin')
    ->name('map.worship');

// test map
Route::view('map/test', 'map.test')
    ->middleware(['auth'], 'role:user|contributor|curator|coordinator|admin')
    ->name('map.test');

require __DIR__.'/auth.php';
