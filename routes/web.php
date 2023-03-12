<?php

use App\Mail\SendWinnersEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

use GuzzleHttp\Client;

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
Route::get('test/payment', function () {
    // Set your Sandbox PagSeguro credentials
    $email = 'atilavictorio@outlook.com';
    $token = '49DF159E0FF44987BDDBF8092FF76CB5';

// Build the POST data
    $data = [
        'email' => $email,
        'token' => $token,
    ];

// Make the POST request to create a new Sandbox session
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://ws.sandbox.pagseguro.uol.com.br/v2/sessions');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

// Extract the session ID from the response
    $xml = simplexml_load_string($response);
    $sessionId = (string) $xml->id;

    return view('subscription.payment', compact('sessionId'));
});

Route::post('create-payment-with-pre-approval', function (\Illuminate\Http\Request $request) {
Log::debug('hiiii');
    $plan = [
        'body' => [
            'reference' => 'plano laravel pagseguro',
        ],

        'preApproval' => [
            'name' => 'Plano ouro - mensal',
            'charge' => 'AUTO', // outro valor pode ser MANUAL
            'period' => 'MONTHLY', //WEEKLY, BIMONTHLY, TRIMONTHLY, SEMIANNUALLY, YEARLY
            'amountPerPayment' => '125.00', // obrigatório para o charge AUTO - mais que 1.00, menos que 2000.00
            'membershipFee' => '50.00', //opcional - cobrado com primeira parcela
            'trialPeriodDuration' => 30, //opcional
            'details' => 'Decrição do plano', //opcional
            'expiration' => [ // opcional
                'value' => 1, // obrigatório de 1 a 1000000
                'unit' => 'YEARLY', // obrigatório
            ],
        ]

    ];

    $plan = \PagSeguro::plan()->createFromArray($plan);
    $credentials = \PagSeguro::credentials()->get();
    $information = $plan->send($credentials);
    if ($information) {
        return response()->json(['code' => $information->getCode(), 'date' => $information->getDate(), 'paymentLink' => $information->getLink()]);
//        print_r($information->getCode());
//        print_r($information->getDate());
//        print_r($information->getLink());
    }

//    $email = 'atilavictorio@outlook.com';
//    $token = '49DF159E0FF44987BDDBF8092FF76CB5';
//
//    $url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/pre-approvals/request';
//    //$url = 'https://ws.pagseguro.uol.com.br/v2/pre-approvals/request';
//
//
//    $data = [
//        'currency' => 'BRL',
//        'reference' => '123456', // set your own reference code
//        'senderName' => $request->senderName,
//        'senderEmail' => $request->senderEmail,
//        'senderAreaCode' => '11',
//        'senderPhone' => '999999999',
//        'senderCPF' => '12345678900',
//        'senderHash' => $request->senderHash, // get senderHash from frontend
//        'preApprovalCharge' => 'AUTO',
//        'preApprovalName' => 'Monthly subscription',
//        'preApprovalAmountPerPayment' => '100.00',
//        'preApprovalPeriod' => 'MONTHLY',
//        'preApprovalFinalDate' => date('Y-m-d', strtotime('+1 year')),
//    ];
//
//    // Build API request
//    $ch = curl_init();
//    curl_setopt($ch, CURLOPT_URL, $url);
//    curl_setopt($ch, CURLOPT_POST, true);
//    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
//    curl_setopt($ch, CURLOPT_HTTPHEADER, [
//        "Content-Type: application/x-www-form-urlencoded; charset=ISO-8859-1",
//        "Accept: application/xml;charset=ISO-8859-1",
//    ]);
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//    curl_setopt($ch, CURLOPT_USERPWD, "$email:$token");
//    $result = curl_exec($ch);
//    curl_close($ch);
//
//    // Parse XML response
//    return $result;
//
//    // Parse API response
//    $response = new DOMDocument();
//    $response->loadXML($result);
//
//    if ($response->code) {
//        $paymentLink = "https://sandbox.pagseguro.uol.com.br/v2/pre-approvals/request.html?code={$response->code}";
//        return response()->json(['success' => true, 'paymentLink' => $paymentLink]);
//    } else {
//        return response()->json(['success' => false]);
//    }
});
