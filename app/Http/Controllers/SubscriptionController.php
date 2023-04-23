<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use App\Services\ContestService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SubscriptionController extends Controller
{
    private function getPagSeguroPublicKey()
    {
        $url = 'https://api.pagseguro.com/public-keys/';
        $token = '1d5e9025-0203-4db4-92d2-d47a5eee368a58fece184846b1d60a56cd9d1546caece558-0a00-43a4-b077-b5166a422170';
        $type = 'card';

        $client = new Client([
            'headers' => [
                'Authorization' => $token,
                'Content-Type' => 'application/json',
                'x-api-version' => '1.0',
                'x-idempotency-key' => '',
            ]
        ]);

        $body = json_encode(['type' => $type]);

        try {
            $response = $client->post($url, ['body' => $body]);
            $data = json_decode($response->getBody(), true);

            // Handle the success response
            return $data['public_key'];
        } catch (RequestException $e) {
            // Handle the error response
            return 'error!';
        }
    }
    public function subscription()
    {
        $data = Payment::with(['user' => function($q) {
            $q->select('id', 'subscribed', 'payment_card_id');
        }])->whereUserId(Auth::user()->id)
            ->select('end_date', 'user_id')
            ->get();

        //return $data;

        return view('subscription.index', compact('data'));
    }

    public function create()
    {
        $publicKey = $this->getPagSeguroPublicKey();
        return view('subscription.create', compact('publicKey'));
    }

    public function checkout(Request $request, ContestService $contestService)
    {
        $client = new Client();

        try {
            $encrypted = $request->encrypted;

            $response = $client->post('https://api.pagseguro.com/orders', [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('PAGSEGURO_TOKEN'),
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    "reference_id" => md5(uniqid().time()),
                    "customer" => [
                        "name" => Auth::user()->name,
                        "email" => Auth::user()->email,
                        "tax_id" => $request->tax,
//                        "phones" => [
//                            [
//                                "country" => "55",
//                                "area" => "11",
//                                "number" => "999999999",
//                                "type" => "MOBILE"
//                            ]
//                        ]
                    ],
                    "items" => [
                        [
                            "reference_id" => "monthly_subscription_one",
                            "name" => "subscription",
                            "quantity" => 1,
                            "unit_amount" => 10000
                        ]
                    ],
//                    "shipping" => [
//                        "address" => [
//                            "street" => "Avenida Brigadeiro Faria Lima",
//                            "number" => "1384",
//                            "complement" => "apto 12",
//                            "locality" => "Pinheiros",
//                            "city" => "São Paulo",
//                            "region_code" => "SP",
//                            "country" => "BRA",
//                            "postal_code" => "01452002"
//                        ]
//                    ],
                    "notification_urls" => [
                        route('webhook.payment')
                    ],
                    "charges" => [
                        [
                            "reference_id" => md5(uniqid().time().Auth::user()->id),
                            "description" => "subscription",
                            "amount" => [
                                "value" => 10000,
                                "currency" => "BRL"
                            ],
                            "payment_method" => [
                                "type" => "CREDIT_CARD",
                                "installments" => 1,
                                "capture" => true,
                                "card" => [
                                    "encrypted" => $encrypted,
                                    "security_code" => $request->cvv,
                                    "holder" => [
                                        "name" => $request->cardHolder
                                    ],
                                    "store" => true
                                ]
                            ],
                            "recurring" => [
                                "type" => "INITIAL"
                            ]
                        ]
                    ]
                ]
            ]);

            $responseBody = $response->getBody()->getContents();
            $response = json_decode($responseBody, true);


            if (isset($response) && !empty($response)) {
                $cardId = $response['charges'][0]['payment_method']['card']['id'];

                User::whereId(Auth::user()->id)
                    ->update(['payment_card_id' => $cardId]);

                $paymentArray = [
                    'order_id' => $response['id'],
                    'charge_id' => $response['charges'][0]['id'],
                    'status' => $response['charges'][0]['status'],
                    'paid' => $response['charges'][0]['amount']['summary']['paid'],
                    'message' => $response['charges'][0]['payment_response']['message'],
                    'reference' => $response['charges'][0]['payment_response']['reference'],
                    'card_id' => $response['charges'][0]['payment_method']['card']['id'],
                ];

                // delete user from payment
                Payment::where('user_id', Auth::user()->id)->delete();

                Payment::updateOrInsert(
                    [
                        'user_id' => Auth::user()->id,
                        'amount' => $response['charges'][0]['amount']['summary']['paid'],
                        'start_date' => Carbon::today()->format('Y-m-d'),
                    ],
                    [
                        'end_date' => Carbon::now()->addMonth()->format('Y-m-d'),
                        'preferences' => json_encode($paymentArray),
                        'transaction_id' => md5(uniqid().time().Auth::user()->email)
                    ]
                );

                User::whereId(Auth::user()->id)
                    ->update(['subscribed' => 1]);

                $contestService->putUserIntoParticipants(Auth::user()->id);
            }

            return response()->json($paymentArray);

        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                return response()->json($e->getResponse()->getBody());
            } else {
                return response()->json($e->getMessage());
            }
        }
    }

    public function success()
    {
        $endDate = Payment::whereUserId(Auth::user()->id)
            ->select('end_date')
            ->first();

        return view('subscription.success', compact('endDate'));
    }

    public function error()
    {
        return view('subscription.error');
    }

    public function checkout_final($cardId)
    {
        $client = new Client([
            'base_uri' => 'https://api.pagseguro.com/',
        ]);

        try {
            $response = $client->request('POST', 'orders', [
                'headers' => [
                    'Authorization' => 'Bearer 49DF159E0FF44987BDDBF8092FF76CB5',
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'reference_id' => 'ex-00001',
                    'customer' => [
                        'name' => 'Jose da Silva',
                        'email' => 'email@test.com',
                        'tax_id' => '12345678909',
                        'phones' => [
                            [
                                'country' => '55',
                                'area' => '11',
                                'number' => '999999999',
                                'type' => 'MOBILE',
                            ],
                        ],
                    ],
                    'items' => [
                        [
                            'reference_id' => 'referencia do item',
                            'name' => 'nome do item',
                            'quantity' => 1,
                            'unit_amount' => 10000,
                        ],
                    ],
//                    'shipping' => [
//                        'address' => [
//                            'street' => 'Avenida Brigadeiro Faria Lima',
//                            'number' => '1384',
//                            'complement' => 'apto 12',
//                            'locality' => 'Pinheiros',
//                            'city' => 'São Paulo',
//                            'region_code' => 'SP',
//                            'country' => 'BRA',
//                            'postal_code' => '01452002',
//                        ],
//                    ],
                    'notification_urls' => [
                        route('webhook.payment')
                    ],
                    'charges' => [
                        [
                            'reference_id' => 'referencia da cobranca',
                            'description' => 'descricao da cobranca',
                            'amount' => [
                                'value' => 10000,
                                'currency' => 'BRL',
                            ],
                            'plan' => [
                                'code' => '7224F1DC-C2C2-104C-C4D6-AFAB9A22BE37'
                            ],
                            'payment_method' => [
                                'type' => 'CREDIT_CARD',
                                'installments' => 1,
                                'capture' => true,
                                'card' => [
                                    'id' => $cardId,
                                    'holder' => [
                                        'name' => 'Jose da Silva',
                                    ],
                                    'store' => true,
                                ],
                            ],
                            'recurring' => [
                                'type' => 'SUBSEQUENT',
                            ],
                        ],
                    ],
                ],
            ]);

            $responseBody = (string)$response->getBody();
            $responseData = json_decode($responseBody, true);

            return $responseData;

            // Do something with $responseData...

        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $responseBody = (string)$e->getResponse()->getBody();
                $responseError = json_decode($responseBody, true);

                // Handle error response...
            } else {
                // Handle network or other errors...
            }
        }

    }

    // Define the webhook endpoint for subscription events
    public function webhook(Request $request)
    {
        // Verify that the request is coming from PagSeguro
        if ($request->input('notificationType') === 'transaction') {
            // Get the subscription by the reference ID
            $subscription = Subscription::where('reference_id', $request->input('reference'))->first();
            // Get the transaction details from PagSeguro
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/vnd.pagseguro.com.br.v3+json;charset=UTF-8',
                'Authorization' => 'Bearer ' . config('services.pagseguro.access_token'),
            ])->get('https://api.pagseguro.com/charges/' . $request->input('code'));

            if ($response->successful()) {
                // Update the subscription status in the database
                $subscription->status = $response['status'];
                $subscription->save();
            }
        }
    }

    public function free_subscription(int $uid)
    {
        $pay = Payment::where('user_id', $uid)
            ->where('end_date', '>', now())
            ->count('id');
        if ($pay > 0) {
            return redirect()->back()->with('err', 'Already subscribed.');
        } else {
            Payment::updateOrInsert(
                [
                    'user_id' => $uid,
                    'amount' => 0.00,
                    'start_date' => Carbon::today()->format('Y-m-d'),
                ],
                [
                    'end_date' => Carbon::now()->addMonth()->format('Y-m-d'),
                    'preferences' => json_encode(['free']),
                    'transaction_id' => 'free_' . md5(uniqid().time().Auth::user()->email)
                ]
            );
            User::where('id', $uid)->update(['subscribed' => 1]);
            return redirect()->back()->with('msg', 'Subscribed successfully.');
        }
    }
}
