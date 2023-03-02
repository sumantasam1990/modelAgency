<?php

use App\Mail\SendWinnersEmail;
use Illuminate\Support\Facades\Mail;
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
    Route::get('help', [\App\Http\Controllers\OtherController::class, 'help'])->name('help');

    //subscription
    Route::get('subscription/now', [\App\Http\Controllers\SubscriptionController::class, 'subscription'])->name('subscription.now');
    Route::get('/subscription', [\App\Http\Controllers\SubscriptionController::class, 'create'])->name('subscription.create');
    Route::post('/checkout', [\App\Http\Controllers\SubscriptionController::class, 'checkout'])->name('checkout.post');
    Route::get('/checkout/final/payment', [\App\Http\Controllers\SubscriptionController::class, 'checkout_final']);
    Route::post('webhook/payment', [\App\Http\Controllers\SubscriptionController::class, 'webhook'])->name('webhook.payment');
    Route::get('success', [\App\Http\Controllers\SubscriptionController::class, 'success'])->name('payment.success');
    Route::get('error', [\App\Http\Controllers\SubscriptionController::class, 'error'])->name('payment.error');
    Route::get('mark/profile/photo/{id}', [\App\Http\Controllers\portfolioController::class, 'mark_profile_photo'])->name('mark.profile.photo');
    Route::get('mark/contest/photo/{id}', [\App\Http\Controllers\portfolioController::class, 'mark_contest_photo'])->name('mark.contest.photo');
    Route::get('edit/profile', [\App\Http\Controllers\ProfileController::class, 'edit_profile'])->name('edit.profile');
    Route::post('update/profile/info', [\App\Http\Controllers\ProfileController::class, 'update_profile'])->name('update.profile');






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
    Route::get('category/contests', [\App\Http\Controllers\AdminController::class, 'category_contests'])->name('admin.category.contests');
    Route::get('contest/stats/{id}', [\App\Http\Controllers\AdminController::class, 'contest_stats'])->name('admin.contest.stats');
    Route::get('stats', [\App\Http\Controllers\AdminController::class, 'stats'])->name('admin.stats');
    Route::get('models', [\App\Http\Controllers\AdminController::class, 'models'])->name('admin.models');
    Route::get('model/info/{id}', [\App\Http\Controllers\AdminController::class, 'models_info'])->name('admin.model.info');
    Route::get('model/search', [\App\Http\Controllers\AdminController::class, 'models'])->name('admin.model.search');
    Route::get('model/rating/{rate}/{uid}', [\App\Http\Controllers\AdminController::class, 'model_rate'])->name('admin.model.rate');
    Route::get('model/heart/{status}/{uid}', [\App\Http\Controllers\AdminController::class, 'model_heart'])->name('admin.model.heart');
    Route::get('model/status/{uid}/{status}', [\App\Http\Controllers\AdminController::class, 'model_status'])->name('admin.model.status');
    Route::post('save/filters', [\App\Http\Controllers\AdminController::class, 'save_filter'])->name('admin.save.filter');
    Route::get('filter/delete/{id}', [\App\Http\Controllers\AdminController::class, 'filter_delete'])->name('admin.filter.delete');
    Route::post('stats/search', [\App\Http\Controllers\AdminController::class, 'stats'])->name('admin.stats.search');
    Route::get('subscribers', [\App\Http\Controllers\AdminController::class, 'subscribers'])->name('admin.subscribers');
    Route::get('subscribers/search', [\App\Http\Controllers\AdminController::class, 'subscribers'])->name('admin.subscribers.search');
    Route::get('faqs', [\App\Http\Controllers\AdminController::class, 'faqs'])->name('admin.faq');
    Route::post('faq/post', [\App\Http\Controllers\AdminController::class, 'faq_post'])->name('admin.faq.post');
    Route::get('delete/faq/{id}', [\App\Http\Controllers\AdminController::class, 'faq_delete'])->name('admin.delete.faq');
    Route::get('winner/bank/transfer/{contest_id}/{id}/{prize}', [\App\Http\Controllers\AdminController::class, 'winner_bank_transfer'])->name('winner.bank.transfer');
    Route::post('bank/transfer/post', [\App\Http\Controllers\AdminController::class, 'bank_transfer_post'])->name('bank.transfer.post');
    Route::get('contest/info/category/{id}', [\App\Http\Controllers\AdminController::class, 'contest_info_by_category']);




});


// testing query
Route::get('/test/query', function (\App\Services\ContestService $contestService) {
    $data = $contestService->getWinnersJob();

    foreach ($data as $d)
    {
        $i = 1;
        foreach ($d['winners'] as $winner) {
            $array_data = [
                'contest_name' => $d['contest_name'],
                'end' => $d['end'],
                'index' => $i,
            ];
            Mail::to($winner['user_email'])->queue(new SendWinnersEmail($array_data));
            $i++;
        }
    }

    //return $data;
});

Route::get('test/mailable', function () {
//    $users = \App\Models\User::all();
//    return new \App\Mail\SendWinnersEmail($users);
//    \App\Jobs\SendWinnersEmailsJob::dispatch();
});



// php artisan queue:retry uuid for failed jobs
