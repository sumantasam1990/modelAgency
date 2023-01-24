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

Route::get('login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::post('login/post', [\App\Http\Controllers\AuthController::class, 'authenticate'])->name('login.post');
Route::get('register', [\App\Http\Controllers\AuthController::class, 'register'])->name('register');
Route::post('register/post', [\App\Http\Controllers\AuthController::class, 'register_post'])->name('register.post');

Route::middleware(['auth'])->prefix('model')->group(function () {
    Route::get('portfolio',[\App\Http\Controllers\portfolioController::class, 'index'])->name('portfolio');
    Route::post('upload/photo', [\App\Http\Controllers\portfolioController::class, 'uploadPhoto'])->name('upload.image');
    Route::post('links/post', [\App\Http\Controllers\portfolioController::class, 'links_post'])->name('links.post');
    Route::get('delete/photo/{id}', [\App\Http\Controllers\portfolioController::class, 'delete_photo'])->name('delete.photo');
    Route::post('add/interest', [\App\Http\Controllers\portfolioController::class, 'add_interest'])->name('add.interest');


    Route::get('logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
});
