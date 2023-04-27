<?php

namespace App\Services;

use App\Models\Configure;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ModelsService
{
    public function alphaOrder($request, $letter = '')
    {
        $users = User::with(['portfolioWithContestPhoto','portfolios', 'modelInfos', 'model_info_love', 'portfolio', 'state_name', 'city_name'])
            ->leftJoin('model_infos', function($join) {
                $join->on('users.id', '=', 'model_infos.user_id')
                    ->where('model_infos.key', '=', 'rate');
            })
            ->where('name', 'like', $letter . '%')
            ->where('email', '!=', 'admin@admin.com');

        if (isset($request['save_filter'])) {
            $queryString = $request['save_filter'];
            $queryArray = [];
            parse_str($queryString, $queryArray);
        }

        if (isset($queryArray['gender'])) {
            $users->whereIn('gender', $queryArray['gender']);
        }
        if (isset($queryArray['civil'])) {
            $users->whereIn('civil', $queryArray['civil']);
        }
        if (isset($queryArray['age_from'])) {
            $users->whereBetween('users.preferences->_age', [$queryArray['age_from'], $queryArray['age_to']]);
        }
        if (isset($queryArray['h_from'])) {
            $users->whereBetween(DB::raw("CAST(json_extract(`users`.`preferences`, '$._height') AS UNSIGNED)"), [$queryArray['h_from'], $queryArray['h_to']]);
        }
        if (isset($queryArray['_skin'])) {
            $users->where('users.preferences->_skin', $queryArray['_skin']);
        }
        if (isset($queryArray['dress'])) {
            $users->where('users.preferences->dress', $queryArray['dress']);
        }
        if (isset($queryArray['hair'])) {
            $users->where('users.preferences->hair', $queryArray['hair']);
        }
        if (isset($queryArray['eyes'])) {
            $users->where('users.preferences->eyes', $queryArray['eyes']);
        }
        // end save filter -----------------

        if (isset($request['filter_one'])) {
            $users->where('subscribed', $request['filter_one']);
        }
        if (isset($request['filter_two'])) {
            $users->where('status', $request['filter_two']);
        }
        if (isset($request['state'])) {
            $users->where('state', $request['state']);
        }
        if (isset($request['city'])) {
            $users->whereIn('city', $request['city']);
        }
        if (isset($request['keyword']) && $request['keyword'] != '') {
            $users->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request['keyword'] . '%')
                    ->orWhere('email', 'like', '%' . $request['keyword'] . '%')
                    ->orWhere('wp', 'like', '%' . $request['keyword'] . '%');
            });
        }

        $users->select('users.*', DB::raw('IFNULL(model_infos.value, 0) as rating'))
            ->orderByDesc('rating');

        $users = $users->paginate(1);

        if(count($users) === 0) {
            return [];
        }

        $nextPageUrl = $users->nextPageUrl();
        $prevPageUrl = $users->previousPageUrl();

        $data = $users->map(function ($user) use ($nextPageUrl, $prevPageUrl) {
            $infos = [];
            $portfolios = [];

            if (isset($user->modelInfos) && count($user->modelInfos) > 0) {
                $infos = collect($user->modelInfos)->map(function ($info) {
                    return [
                        'rating' => $info['key'] == 'rate' ? max(0, $info['value']) : '',
                    ];
                });
            } else {
                $infos = collect([
                    ['rating' => 0],
                ]);
            }

            if (isset($user->portfolios)) {
                $portfolios = collect($user->portfolios)->map(function ($info) {
                    return [
                        'file_name' => $info['file_name'],
                        'ext' => $info['ext'],
                    ];
                });
            }

            return [
                'uid' => $user->id,
                'preferences' => $user->preferences,
                'age' => $user->age,
                'bust' => $user->bust,
                'eyes' => $user->eyes,
                'hips' => $user->hips,
                'skin' => $user->skin,
                'dress' => $user->dress,
                'other' => $user->other,
                'waist' => $user->waist,
                'height' => $user->height,
                'hair' => $user->hair,
                'user_status' => $user->status,
                'user_subscribe' => $user->subscribed,
                'name' => $user->name,
                'email' => $user->email,
                'gender' => $user->gender,
                'city' => $user->city_name->nome ?? '',
                'state' => $user->state_name->nome ?? '',
                'district' => $user->district,
                'civil' => $user->civil,
                'wp' => $user->wp,
                'love' => $user->model_info_love['value'] ?? '',
                'portfolio' => [
                    'file_name' => $user->portfolio['file_name'] ?? '',
                    'ext' => $user->portfolio['ext'] ?? '',
                ],
                'portfolioWithContestPhoto' => [
                    'file_name' => $user->portfolioWithContestPhoto['file_name'] ?? '',
                    'ext' => $user->portfolioWithContestPhoto['ext'] ?? '',
                ],
                'portfolios' => $portfolios,
                'infos' => $infos,
                //'interest' => $interest,
                'next_page_url' => $nextPageUrl,
                'prev_page_url' => $prevPageUrl,
            ];
        });

        return $data;
    }

    public function modelInfo(int $id)
    {
        $users = User::with(['portfolioWithContestPhoto','portfolios', 'interest', 'modelInfos', 'model_info_love'])
            ->paginate(1);

        $nextPageUrl = $users->nextPageUrl();
        $prevPageUrl = $users->previousPageUrl();

        $data = $users->map(function ($user) use ($nextPageUrl, $prevPageUrl) {
            $infos = [];
            $portfolios = [];

            if (isset($user->modelInfos) && count($user->modelInfos) > 0) {
                $infos = collect($user->modelInfos)->map(function ($info) {
                    return [
                        'rating' => $info['key'] == 'rate' ? max(0, $info['value']) : '',
                    ];
                });
            } else {
                $infos = collect([
                    ['rating' => 0],
                ]);
            }

            if (isset($user->portfolios)) {
                $portfolios = collect($user->portfolios)->map(function ($info) {
                    return [
                        'file_name' => $info['file_name'],
                        'ext' => $info['ext'],
                    ];
                });
            }

            $interest = $user->interest['content'] ?? 'No interest found for this model.';

            return [
                'uid' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'gender' => $user->gender,
                'city' => $user->city,
                'state' => $user->state,
                'civil' => $user->civil,
                'wp' => $user->wp,
                'love' => $user->model_info_love['value'] ?? '',
                'portfolioWithContestPhoto' => [
                    'file_name' => $user->portfolioWithContestPhoto['file_name'],
                    'ext' => $user->portfolioWithContestPhoto['ext'],
                ],
                'portfolios' => $portfolios,
                'infos' => $infos,
                'interest' => $interest,
                'next_page_url' => $nextPageUrl,
                'prev_page_url' => $prevPageUrl,
            ];
        });

        return $data;
    }

    public function chargeMonthly($cardId, int $amount, $customerInfo): JsonResponse|array|null
    {
        $client = new Client([
            'base_uri' => 'https://api.pagseguro.com/',
        ]);

        try {

            $responsibleName = Configure::where('user_id', $customerInfo['id'])
                ->where('key', 'pix')
                ->select('value')
                ->first();
            $responsibleName = explode(',', $responsibleName->value);
            if (count($responsibleName) === 0 ) {
                return null;
            }

            $response = $client->post('https://api.pagseguro.com/orders', [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('PAGSEGURO_TOKEN'),
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    "reference_id" => md5(uniqid().time()),
                    'customer' => [
                        'name' => $customerInfo['name'],
                        'email' => $customerInfo['email'],
                        'tax_id' => $customerInfo['tax_id'],
//                        'phones' => [
//                            [
//                                'country' => '55',
//                                'area' => '11',
//                                'number' => '999999999',
//                                'type' => 'MOBILE',
//                            ],
//                        ],
                    ],
                    'items' => [
                        [
                            'reference_id' => 'monthly_subscription_infinite',
                            'name' => 'subscription',
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
                            'reference_id' => md5(uniqid().time().$cardId),
                            'description' => 'subscription',
                            'amount' => [
                                'value' => 10000,
                                'currency' => 'BRL',
                            ],
                            'payment_method' => [
                                'type' => 'CREDIT_CARD',
                                'installments' => 1,
                                'capture' => true,
                                'card' => [
                                    'id' => $cardId,
                                    'holder' => [
                                        'name' => $customerInfo['name'],
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

            $responseBody = $response->getBody()->getContents();
            $response = json_decode($responseBody, true);

            if (isset($response) && !empty($response)) {
                $cardId = $response['charges'][0]['payment_method']['card']['id'];

                User::whereId($customerInfo['id'])
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
                Payment::where('user_id', $customerInfo['id'])->delete();

                Payment::updateOrInsert(
                    [
                        'user_id' => $customerInfo['id'],
                        'amount' => $response['charges'][0]['amount']['summary']['paid'],
                        'start_date' => Carbon::today()->format('Y-m-d'),
                    ],
                    [
                        'end_date' => Carbon::now()->addMonth()->format('Y-m-d'),
                        'preferences' => json_encode($paymentArray),
                        'transaction_id' => md5(uniqid().time().$customerInfo['id'].$cardId)
                    ]
                );

                User::whereId($customerInfo['id'])
                    ->update(['subscribed' => 1]);

                (new ContestService())->putUserIntoParticipants($customerInfo['id']);

                return $paymentArray;
            } else {
                User::whereId($customerInfo['id'])
                    ->update(['subscribed' => 0]);

                return null;
            }

            // Do something with $responseData...

        } catch (RequestException $e) {
            User::whereId($customerInfo['id'])
                ->update(['subscribed' => 0]);

            if ($e->hasResponse()) {
                return response()->json($e->getResponse()->getBody());
            } else {
                return response()->json($e->getMessage());
            }
        }
    }
}
