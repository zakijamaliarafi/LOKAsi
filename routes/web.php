<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'approved', 'agent_check'])->group(function () {
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

    // Manage Project page
    Route::view('project/manage', 'project')
        ->middleware('role:coordinator')
        ->name('project.manage');

    // Report POI page
    Route::view('report/poi', 'report-poi')
        ->middleware(['role:coordinator'])
        ->name('report.poi');

    // Report PA page
    Route::view('report/pa', 'report-pa')
        ->middleware(['role:coordinator'])
        ->name('report.pa');

    // Report page
    Route::view('report', 'report')
        ->middleware(['role:contributor'])
        ->name('report');

    // Verify PA Report page
    Route::view('verify/pa', 'verify-pa')
        ->middleware(['role:curator'])
        ->name('verify.pa');

    // view verify PA report
    Route::view('verify/pa/view', 'verify-pa-view')
        ->middleware(['role:curator'])
        ->name('verify.pa.view');

    // Verify POI Report page
    Route::view('verify/poi', 'verify-poi')
        ->middleware(['role:curator'])
        ->name('verify.poi');

    // view verify POI report
    Route::view('verify/poi/view', 'verify-poi-view')
        ->middleware(['role:curator'])
        ->name('verify.poi.view');

    // // Manage Location page
    // Route::get('location/manage', function () {
    //     return 'This page for manage location';
    // })->middleware(['role:coordinator|admin']);

    // Map
    Route::view('map', 'map')
        ->name('map');
});

Route::prefix('m')->middleware(['auth', 'approved', 'role:contributor'])->group(function () {
    // Home page
    Route::view('/', 'mobile/dashboard')
        ->name('mobile.home');

    // Dashboard page
    Route::view('dashboard', 'mobile/dashboard')
        ->middleware(['verified'])
        ->name('mobile.dashboard');

    // Map
    Route::view('map', 'mobile/map')
        ->name('mobile.map');

    // Payment Form
    Route::view('payment', 'mobile/payment')
        ->name('mobile.payment');

    // Payment History
    Route::view('history', 'mobile/history')
        ->name('mobile.history');
});

require __DIR__.'/auth.php';
