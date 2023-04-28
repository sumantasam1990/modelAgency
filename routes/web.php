<?php

use App\Mail\SendWinnersEmail;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;


//Route::get('clear', function () {
//    try {
//            \Illuminate\Support\Facades\Artisan::call('cache:clear');
//            \Illuminate\Support\Facades\Artisan::call('config:clear');
//            \Illuminate\Support\Facades\Artisan::call('view:clear');
//            \Illuminate\Support\Facades\Artisan::call('route:clear');
//
//            return 'Good Luck!';
//
//    } catch (\Throwable $th) {
//        abort(500, $th->getMessage());
//    }
//
//});


Route::get('/', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('privacy', function () {
   return view('privacy');
})->name('privacy');
Route::get('terms', function () {
    return view('terms');
})->name('terms');
Route::get('sub/policy', function () {
    return view('subscriptionpolicy');
})->name('sub.policy');


Route::get('login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::post('login/post', [\App\Http\Controllers\AuthController::class, 'authenticate'])->name('login.post');
Route::get('register', [\App\Http\Controllers\AuthController::class, 'register'])->name('register');
Route::post('register/post', [\App\Http\Controllers\AuthController::class, 'register_post'])->name('register.post');

Route::middleware(['auth', 'verified'])->prefix('model')->group(function () {
    Route::get('portfolio/{contest_id?}',[\App\Http\Controllers\portfolioController::class, 'index'])->name('portfolio')->middleware('not_subscribed_redirect');
    Route::post('upload/photo', [\App\Http\Controllers\portfolioController::class, 'uploadPhoto'])->name('upload.image')->middleware('not_subscribed_redirect');
    Route::post('links/post', [\App\Http\Controllers\portfolioController::class, 'links_post'])->name('links.post')->middleware('not_subscribed_redirect');
    Route::get('delete/photo/{id}', [\App\Http\Controllers\portfolioController::class, 'delete_photo'])->name('delete.photo')->middleware('not_subscribed_redirect');
    Route::post('add/interest', [\App\Http\Controllers\portfolioController::class, 'add_interest'])->name('add.interest')->middleware('not_subscribed_redirect');
    Route::get('contests/vote', [\App\Http\Controllers\ContestsController::class, 'index_vote'])->name('contest.vote')->middleware('not_subscribed_redirect');
    Route::get('my/contest', [\App\Http\Controllers\ContestsController::class, 'my_contests'])->name('my.contests')->middleware('not_subscribed_redirect');
    Route::get('winners', [\App\Http\Controllers\ContestsController::class, 'winners'])->name('winners')->middleware('not_subscribed_redirect');
    Route::get('winners/search', [\App\Http\Controllers\ContestsController::class, 'winner_search'])->name('winner.search')->middleware('not_subscribed_redirect');
    Route::get('my/results', [\App\Http\Controllers\ContestsController::class, 'my_results'])->name('my.results')->middleware('not_subscribed_redirect');
    Route::get('help', [\App\Http\Controllers\OtherController::class, 'help'])->name('help');

    //subscription
    Route::get('subscription/now', [\App\Http\Controllers\SubscriptionController::class, 'subscription'])->name('subscription.now')->middleware(['update_info_before_subscribed']);
    Route::get('/subscription', [\App\Http\Controllers\SubscriptionController::class, 'create'])->name('subscription.create')->middleware(['update_info_before_subscribed']);
    Route::post('/checkout', [\App\Http\Controllers\SubscriptionController::class, 'checkout'])->name('checkout.post')->middleware(['update_info_before_subscribed']);
    Route::get('/checkout/final/payment', [\App\Http\Controllers\SubscriptionController::class, 'checkout_final']);
    Route::post('webhook/payment', [\App\Http\Controllers\SubscriptionController::class, 'webhook'])->name('webhook.payment');
    Route::get('success', [\App\Http\Controllers\SubscriptionController::class, 'success'])->name('payment.success')->middleware(['update_info_before_subscribed']);
    Route::get('error', [\App\Http\Controllers\SubscriptionController::class, 'error'])->name('payment.error')->middleware(['update_info_before_subscribed']);
    Route::get('mark/profile/photo/{id}', [\App\Http\Controllers\portfolioController::class, 'mark_profile_photo'])->name('mark.profile.photo')->middleware('not_subscribed_redirect');
    Route::get('mark/contest/photo/{id}/{contest_id}', [\App\Http\Controllers\portfolioController::class, 'mark_contest_photo'])->name('mark.contest.photo')->middleware('not_subscribed_redirect');
    Route::get('edit/profile', [\App\Http\Controllers\ProfileController::class, 'edit_profile'])->name('edit.profile');
    Route::post('edit/profile', [\App\Http\Controllers\ProfileController::class, 'update_profile'])->name('update.profile');
    Route::get('cancel/membership', [\App\Http\Controllers\PaymentController::class, 'cancel_membership'])->name('cancel.membership');
    Route::get('about/me', [\App\Http\Controllers\ProfileController::class, 'about_me'])->name('about.me')->middleware('not_subscribed_redirect');
    Route::post('about/me/post', [\App\Http\Controllers\ProfileController::class, 'about_post'])->name('about.me.post')->middleware('not_subscribed_redirect');







});
Route::get('logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('/{username}', [\App\Http\Controllers\ProfileController::class, 'profile'])->name('profile')->middleware('auth', 'verified', 'check.min.photo.upload');


// admin routes

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('add/category', [\App\Http\Controllers\AdminController::class, 'add_category'])->name('add.category');
    Route::post('add/category/post', [\App\Http\Controllers\AdminController::class, 'add_category_post'])->name('add.category.post');
    Route::get('category/delete/{id}', [\App\Http\Controllers\AdminController::class, 'category_delete'])->name('category.delete');
    Route::get('add/contest', [\App\Http\Controllers\AdminController::class, 'add_contest'])->name('add.contest');
    Route::post('add/contest/post', [\App\Http\Controllers\AdminController::class, 'add_contest_post'])->name('add.contest.post');
    Route::get('contest/delete/{id}', [\App\Http\Controllers\AdminController::class, 'contest_delete'])->name('admin.contest.delete');
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
    Route::get('free/subscription/{uid}', [\App\Http\Controllers\SubscriptionController::class, 'free_subscription'])->name('free.subscription');





});

// Email verification
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect(\route('edit.profile'));
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('resend/email/verification', function (Request $request) {
    $user = $request->user();
    if ($user->hasVerifiedEmail()) {
        return response()->json(['message' => 'User already verified'], 400);
    }

    $user->sendEmailVerificationNotification();

    return redirect()->back()->with('msg', trans('main.verify_email_msg'));
})->name('verification-resend');

// testing query ---------------------------------------------------

//Route::get('/test/query', function () {
//
//});

//Route::get('get/price', function (Request $request) {
//    $planCode = '7224F1DC-C2C2-104C-C4D6-AFAB9A22BE37';
//    $client = new \GuzzleHttp\Client();
//    $response = $client->get("https://ws.pagseguro.uol.com.br/pre-approvals/{$planCode}", [
//        'headers' => [
//            'Authorization' => 'Bearer ' . env('LIVE_TOKEN'),
//            'Content-Type' => 'application/json',
//        ]
//    ]);
//    $planData = json_decode($response->getBody()->getContents(), true);
//    //$price = $planData['preApproval']['charge']['amount']['value'];
//
//    return $planData;
//
//})->name('get.price');


