@extends('header')
@section('content')

    <div class="row">
        <div class="col-md-5 mx-auto">
            @if(count($data) > 0)
                @if($data[0]->end_date < \Carbon\Carbon::today()->format('Y-m-d'))
                    <div class="sec-box border text-left p-4">
                        <h4 class="fw-bold fs-3 mb-1">AGENCIAMENTO</h4>

                        <div class="p-2">
                            <p>
                                Seu período gratuiíto de <span class="text-dark fw-bold">10 dias</span> chegou ao fim. Esperamos que tenha aproveitado ao máximo todas as funcionalidades que oferecemos para alavancar a sua carreira de modelo
                            </p>

                            <p>
                                Para continuar participando de concursos de beleza e buscando novas oportunidades de parcerias, é necessário se tornar um assinante. Por apenas <span class="text-dark fw-bold">R$100</span> mensal, você terá acesso à todas as funcionalidades e poderá ampliar ainda mais o seu potencial como modelo.
                            </p>

                            <p>
                                Clique no botão abaixo e garanta sua vaga na eumodelo.
                            </p>

                        </div>


                        <div class="d-grid gap-2 col-8 mt-4 mx-auto">
                            <a class="btn btn-dark btn-lg text-uppercase" href="{{route('subscription.create')}}">Assinar</a>
                        </div>
                    </div>
            @else
                <div class="sec-box border p-4">
                    <h2 class="fs-3 fw-bold">{{__('main.premium')}}</h2>

{{--                    <p class="fs-6 text-black">Your next renewal date is <span class="fw-bold">{{\Carbon\Carbon::parse($data[0]->end_date)->format('jS F Y')}}</span></p>--}}
                    <div class="d-grid gap-2 col-12 mt-3">
                        <a class="btn-lg btn btn-dark" href="{{route('contest.vote')}}"><i class="fa-solid fa-heart"></i> &nbsp; {{__('main.gotovote')}}</a>
                        @if($data[0]->user->subscribed === 1 && $data[0]->user->payment_card_id === null)
                            <p class="fw-semibold fs-5 mt-3 text-danger">
                                A sua assinatura eumodelo foi cancelada!
                            </p>
                        @elseif($data[0]->user->subscribed === 1 && $data[0]->user->payment_card_id !== null && $data[0]->user->payment_card_id !== 'free_trial')
                            <h4 class="fw-semibold fs-4 mb-1">{{__('main.membership_active')}}</h4>
                            <p>
                                <i class="fa-solid fa-ban"></i>
                                {{__('main.cancel_membership')}}
                                <a onclick="return confirm('Tem certeza? Você perderá acesso todos os recursos da sua conta.')" class="text-black text-decoration-none fw-bold" href="{{route('cancel.membership')}}">{{__('main.cancel')}}</a>
                            </p>
                        @elseif($data[0]->user->subscribed === 1 && $data[0]->user->payment_card_id === 'free_trial')
                            <p class="fw-semibold fs-5 mt-3 text-danger text-center">
                                Teste grátis por 10 dias.
                            </p>
                        @endif



                    </div>
                </div>
                @endif
            @endif
            @if(count($data) === 0)
                <div class="sec-box border text-left p-4">
                    <h4 class="fw-bold fs-3 mb-1">AGENCIAMENTO</h4>

                    <div class="p-2">
                        <p>
                            Seja bem-vindo(a) à eumodelo!
                        </p>

                        <p>
                            Ao se tornar um modelo agenciado, você poderá:
                        </p>

{{--                        <p>--}}
{{--                            Com a assinatura, você poderá:--}}
{{--                        </p>--}}

                        <ul>
                            <li>Ter um perfil de modelo profissional</li>
                            <li>Adicionar suas melhores fotos</li>
                            <li>Apresentar para produtores artísticos</li>
                            <li>Participar de concursos de beleza</li>
                            <li>Competir por prêmios em dinheiro</li>
                        </ul>

                        <p class="mt-3">
                            O agenciamento custa R$100 por mês e é cobrado no cartão de crédito pelo Pagseguro.
                            Você poderá cancelar o agenciamento a qualquer momento.
                        </p>

                        <p>
                            Clique no botão abaixo para garantir sua vaga e amplie seu potencial com a eumodelo.
                        </p>

                    </div>


                    <div class="d-grid gap-2 col-12 mt-4 mx-auto">
                        <a class="btn btn-dark btn-lg text-uppercase" href="{{route('subscription.create')}}">Garantir minha vaga</a>
                    </div>
                </div>
            @endif
        </div>
    </div>



@endsection
