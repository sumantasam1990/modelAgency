<?php

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('test', function () {

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://ambergloballogistics.com/api/v1/trackingnumber/view/800000641812',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Secret-Key: yeoKzwkJke2N1A6FyuOcF63uQrgMwS4Y'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;


//    $client = new Client();
//    $headers = [
//        'Secret-Key' => ''
//    ];
//    $request = new Request('GET', 'https://ambergloballogistics.com/api/v1/trackingnumber/view/800000641812', $headers);
//    $res = $client->sendAsync($request)->wait();
//    echo $res->getBody();
});
