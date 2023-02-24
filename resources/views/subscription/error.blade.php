@extends('header')
@section('content')
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="d-flex flex-column justify-content-center align-items-center align-content-center text-center">
                <p class="fs-1 text-danger fw-bold">
                    <i class="fa-solid fa-circle-xmark"></i>
                </p>
                <h2 class="fw-bold fs-4 text-dark">
                    Failed! Your payment has been failed. Please try again after some time or change your Credit card or contact our support.
                </h2>
                <p class="mt-4 d-grid gap-2 mx-auto col-4">
                    <a class="btn btn-lg btn-dark" href="{{route('subscription.now')}}"><i class="fa-solid fa-money-bill"></i> &nbsp; Try again</a> &nbsp;
                </p>
            </div>
        </div>
    </div>
@endsection
