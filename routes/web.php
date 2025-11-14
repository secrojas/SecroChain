<?php

use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', function () {
    return view('landing');
})->name('landing');

// Authentication
Route::get('/auth', function () {
    return view('auth');
})->name('auth');

// Dashboard (temporary - will require authentication later)
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
