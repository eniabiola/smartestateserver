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

Route::get('/', function () {
    return view('welcome');
});

Route::view('/counter', 'counter');

Route::get('email/verify/{id}', [\App\Http\Controllers\API\VerificationController::class, 'verify'])->name('verification.verify');
Route::get('email/resend', [\App\Http\Controllers\API\VerificationController::class, 'resend'])->name('verification.resend');
