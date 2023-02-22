@extends('header')
@section('content')

    <div class="row">
        <div class="col-md-4 mx-auto">
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
        </div>
    </div>

@endsection
