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
    Route::get('contests/vote', [\App\Http\Controllers\ContestsController::class, 'index_vote'])->name('contest.vote');
    Route::get('my/contest', [\App\Http\Controllers\ContestsController::class, 'my_contests'])->name('my.contests');
    Route::get('winners', [\App\Http\Controllers\ContestsController::class, 'winners'])->name('winners');
    Route::get('winners/search', [\App\Http\Controllers\ContestsController::class, 'winner_search'])->name('winner.search');
    Route::get('my/results', [\App\Http\Controllers\ContestsController::class, 'my_results'])->name('my.results');



    Route::get('logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
});

Route::get('/{username}', [\App\Http\Controllers\ProfileController::class, 'profile'])->name('profile');


// admin routes

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('add/category', [\App\Http\Controllers\AdminController::class, 'add_category'])->name('add.category');
    Route::post('add/category/post', [\App\Http\Controllers\AdminController::class, 'add_category_post'])->name('add.category.post');
    Route::get('category/delete/{id}', [\App\Http\Controllers\AdminController::class, 'category_delete'])->name('category.delete');
    Route::get('add/contest', [\App\Http\Controllers\AdminController::class, 'add_contest'])->name('add.contest');
    Route::post('add/contest/post', [\App\Http\Controllers\AdminController::class, 'add_contest_post'])->name('add.contest.post');
    Route::get('contest/delete/{id}', [\App\Http\Controllers\AdminController::class, 'contest_delete'])->name('contest.delete');
    Route::get('contest/winners', [\App\Http\Controllers\AdminController::class, 'winners'])->name('admin.winners');
    Route::get('contest/dashboard', [\App\Http\Controllers\AdminController::class, 'contest_dashboard'])->name('admin.contest.dashboard');
    Route::get('category/contests/{id}', [\App\Http\Controllers\AdminController::class, 'category_contests'])->name('admin.category.contests');
    Route::get('contest/stats/{id}', [\App\Http\Controllers\AdminController::class, 'contest_stats'])->name('admin.contest.stats');
    Route::get('stats', [\App\Http\Controllers\AdminController::class, 'stats'])->name('admin.stats');
    Route::get('models', [\App\Http\Controllers\AdminController::class, 'models'])->name('admin.models');
    Route::get('model/info/{id}', [\App\Http\Controllers\AdminController::class, 'models'])->name('admin.model.info');
    Route::get('model/search', [\App\Http\Controllers\AdminController::class, 'models'])->name('admin.model.search');
    Route::get('model/rating/{rate}', [\App\Http\Controllers\AdminController::class, 'model_rate'])->name('admin.model.rate');

});
