@extends('header')
@section('content')

    <div class="row">
        <div class="col-md-5 mx-auto">
            @if(count($data) > 0)
                @if($data[0]->end_date < \Carbon\Carbon::today()->format('Y-m-d'))
                    <div class="sec-box border text-center p-4">
                        <h4 class="fw-bold fs-3 mb-1">Subscription</h4>
                        <p class="text-black-50">
                            Purchase a subscription
                        </p>
                        <h2 class="fs-2 fw-bold">
                            $19.99/month
                        </h2>
                        <h5 class="mt-4 fw-bold fs-5">Unlock all features</h5>
                        <p class="mb-1">Website functionality 1</p>
                        <p class="mb-1">Website functionality 2</p>
                        <p class="mb-1">Website functionality 3</p>
                        <p class="mb-1">Website functionality 4</p>
                        <div class="d-grid gap-2 col-8 mt-4 mx-auto">
                            <a class="btn btn-dark btn-lg text-uppercase" href="{{route('subscription.create')}}">Subscribe</a>
                        </div>
                    </div>
            @else
                <div class="sec-box border p-4">
                    <h2 class="fs-3 fw-bold">{{__('main.premium')}}</h2>
                    <h4 class="fw-semibold fs-4 mb-1">{{__('main.membership_active')}}</h4>
{{--                    <p class="fs-6 text-black">Your next renewal date is <span class="fw-bold">{{\Carbon\Carbon::parse($data[0]->end_date)->format('jS F Y')}}</span></p>--}}
                    <div class="d-grid gap-2 col-12 mt-3">
                        <a class="btn-lg btn btn-dark" href="{{route('contest.vote')}}"><i class="fa-solid fa-heart"></i> &nbsp; {{__('main.gotovote')}}</a>
                        @if($data[0]->user->subscribed === 1 && $data[0]->user->payment_card_id === null)
{{--                            <p class="fw-semibold fs-5 mt-3 text-danger">--}}
{{--                                You cancelled your membership. We will not charge you from next renewal date.--}}
{{--                            </p>--}}
                        @elseif($data[0]->user->subscribed === 1 && $data[0]->user->payment_card_id !== null)
                            <p>
                                <i class="fa-solid fa-ban"></i>
                                {{__('main.cancel_membership')}}
                                <a onclick="return confirm('Are you sure? You will miss all premium features.')" class="text-black text-decoration-none fw-bold" href="{{route('cancel.membership')}}">{{__('main.cancel')}}</a>
                            </p>
                        @endif



                    </div>
                </div>
                @endif
            @endif
            @if(count($data) === 0)
                <div class="sec-box border text-left p-4">
                    <h4 class="fw-bold fs-3 mb-1">ASSINATURA EUMODELO</h4>

                    <div class="p-2">
                        <p>
                            Seja bem-vindo(a) à eumodelo!
                        </p>

                        <p>
                            Para ter acesso completo ao seu painel eumodelo, é necessário se tornar um assinante.
                        </p>

                        <p>
                            Com a assinatura, você poderá:
                        </p>

                        <ul>
                            <li>Completar seu perfil profissional</li>
                            <li>Adicionar suas melhores fotos</li>
                            <li>Apresentar-se para produtores artísticos</li>
                            <li>Participar de concursos de beleza</li>
                            <li>Competir por prêmios em dinheiro</li>
                        </ul>

                        <p class="mt-3">
                            A assinatura custa R$100 por mês e é cobrada no cartão de crédito pelo Pagseguro. Você poderá cancelar a qualquer momento antes da próxima cobrança.
                        </p>

                        <p>
                            Clique no botão abaixo para assinar agora e amplie seu potencial com a eumodelo.
                        </p>

                    </div>


                    <div class="d-grid gap-2 col-8 mt-4 mx-auto">
                        <a class="btn btn-dark btn-lg text-uppercase" href="{{route('subscription.create')}}">Assinar</a>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection
