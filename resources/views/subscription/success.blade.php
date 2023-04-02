@extends('header')
@section('content')
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="d-flex flex-column justify-content-center align-items-center align-content-center text-center">
                <p class="fs-1 text-success fw-bold">
                    <i class="fa-solid fa-circle-check"></i>
                </p>
                <h2 class="fw-bold fs-4 text-dark">
                    {{__('main.subscription_conf')}} <br /><br /> Your renewal date is <span class="fw-bold">{{\Carbon\Carbon::parse($endDate->end_date)->format('jS F Y')}}</span>
                </h2>
                <p class="mt-4">
                    <a class="btn btn-lg btn-dark" href="{{route('portfolio')}}"><i class="fa-solid fa-camera"></i> &nbsp; Add your photos</a> &nbsp;
                    <a class="btn btn-lg btn-dark" href="{{route('edit.profile')}}"><i class="fa-solid fa-user"></i> &nbsp; Edit Profile Info</a>
                </p>
            </div>
        </div>
    </div>
@endsection
