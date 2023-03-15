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
                    <h2 class="fs-3 fw-bold">Premium User</h2>
                    <h4 class="fw-semibold fs-4 mb-1">You have successfully subscribed.</h4>
                    <p class="fs-6 text-black">Your next renewal date is <span class="fw-bold">{{\Carbon\Carbon::parse($data[0]->end_date)->format('jS F Y')}}</span></p>
                    <div class="d-grid gap-2 col-12 mt-3">
                        <a class="btn-lg btn btn-dark" href="{{route('contest.vote')}}"><i class="fa-solid fa-heart"></i> &nbsp; Go to vote</a>
                        @if($data[0]->user->subscribed === 1 && $data[0]->user->payment_card_id === null)
                            <p class="fw-semibold fs-5 mt-3 text-danger">
                                You cancelled your membership. We will not charge you from next renewal date.
                            </p>
                        @elseif($data[0]->user->subscribed === 1 && $data[0]->user->payment_card_id !== null)
                            <a onclick="return confirm('Are you sure? You will miss all premium features.')" class="btn-lg btn btn-danger" href="{{route('cancel.membership')}}"><i class="fa-solid fa-ban"></i> &nbsp; Cancel membership</a>
                            <small class="text-black-50">If you cancel your membership, we will not charge you from next renewal date.</small>
                        @endif



                    </div>
                </div>
                @endif
            @endif
            @if(count($data) === 0)
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
            @endif
        </div>
    </div>

@endsection
