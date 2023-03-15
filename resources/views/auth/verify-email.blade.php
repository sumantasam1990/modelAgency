@extends('header')
@section('content')
    <div class="row">
        <h4 class="fw-bold fs-4 mb-3 text-black"><i class="fa-solid fa-certificate"></i> Verify Email</h4>
        <div class="col-md-6">
            <h4 class="fs-4 fw-semibold">Please verify your email before access the webpages.</h4>
            <a class="btn btn-outline-dark fw-bold mt-3" href="{{route('contest.vote')}}">If you already verified, click here to refresh</a>
            <a class="btn btn-outline-danger fw-bold mt-3" href="{{route('verification-resend')}}">Resend Verification Email</a>
        </div>
    </div>

@endsection
