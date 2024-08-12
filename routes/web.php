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

// Report page
Route::view('report', 'report')
    ->middleware(['auth', 'role:contributor'])
    ->name('report');

// Verify PA Report page
Route::view('verify/pa', 'verify-pa')
    ->middleware(['auth', 'role:curator|coordinator'])
    ->name('verify.pa');

// view verify PA report
Route::view('verify/pa/view', 'verify-pa-view')
    ->middleware(['auth', 'role:curator|coordinator'])
    ->name('verify.pa.view');

// Verify POI Report page
Route::view('verify/poi', 'verify-poi')
    ->middleware(['auth', 'role:curator|coordinator'])
    ->name('verify.poi');

// view verify POI report
Route::view('verify/poi/view', 'verify-poi-view')
    ->middleware(['auth', 'role:curator|coordinator'])
    ->name('verify.poi.view');

// Manage Location page
Route::get('location/manage', function () {
    return 'This page for manage location';
})->middleware(['auth', 'role:coordinator|admin']);

// Map
Route::view('map', 'map')
    ->middleware(['auth'], 'role:user|contributor|curator|coordinator|admin')
    ->name('map');

require __DIR__.'/auth.php';
