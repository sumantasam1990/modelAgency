@extends('header')
@section('content')
    <div class="row">
        <h4 class="fw-bold fs-4 mb-3 text-black"><i class="fa-solid fa-certificate"></i> {{__('main.verify_email')}}</h4>
        <div class="col-md-6">
            <h4 class="fs-4 fw-semibold">{{__('main.verify_msg')}}</h4>
            <a class="btn btn-outline-dark fw-bold mt-3" href="{{route('contest.vote')}}">{{__('main.refresh_msg')}}</a>
            <a class="btn btn-outline-danger fw-bold mt-3" href="{{route('verification-resend')}}">{{__('main.resend_veri_email')}}</a>
        </div>
    </div>

@endsection
