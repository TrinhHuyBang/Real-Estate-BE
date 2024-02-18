<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/verify-success', function () {
    return view('notification.verifySuccess');
})->name('verifySuccess');

Route::get('/verify-fail', function () {
    return view('notification.verifyFail');
})->name('verifyFail');
