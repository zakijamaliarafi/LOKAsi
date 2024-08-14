<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'approved'])->group(function () {
    // Home page
    Route::view('/', 'dashboard')
        ->name('home');

    // Dashboard page
    Route::view('dashboard', 'dashboard')
        ->middleware(['verified'])
        ->name('dashboard');

    // Profile page
    Route::view('profile', 'profile')
        ->name('profile');

    // Manage User page
    Route::view('user/manage', 'user')
        ->middleware(['role:admin'])
        ->name('user.manage');

    // Report page
    Route::view('report', 'report')
        ->middleware(['role:contributor'])
        ->name('report');

    // Verify PA Report page
    Route::view('verify/pa', 'verify-pa')
        ->middleware(['role:curator|coordinator'])
        ->name('verify.pa');

    // view verify PA report
    Route::view('verify/pa/view', 'verify-pa-view')
        ->middleware(['role:curator|coordinator'])
        ->name('verify.pa.view');

    // Verify POI Report page
    Route::view('verify/poi', 'verify-poi')
        ->middleware(['role:curator|coordinator'])
        ->name('verify.poi');

    // view verify POI report
    Route::view('verify/poi/view', 'verify-poi-view')
        ->middleware(['role:curator|coordinator'])
        ->name('verify.poi.view');

    // // Manage Location page
    // Route::get('location/manage', function () {
    //     return 'This page for manage location';
    // })->middleware(['role:coordinator|admin']);

    // Manage Project page
    Route::view('project/manage', 'project')
        ->middleware('role:coordinator')
        ->name('project.manage');

    // Map
    Route::view('map', 'map')
        ->name('map');
});

require __DIR__.'/auth.php';
