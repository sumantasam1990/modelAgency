@extends('header')
@section('content')
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="d-flex flex-column justify-content-center align-items-center align-content-center text-center">
                <p class="fs-1 text-success fw-bold">
                    <i class="fa-solid fa-circle-check"></i>
                </p>
                <h2 class="fw-bold fs-4 text-dark">
                    Your payment has been <span class="badge bg-success">paid successfully</span>. We will charge you every month. Now you can use all premium features for each month. <br /><br /> Your expiry date is <span class="fw-bold">{{\Carbon\Carbon::parse($endDate->end_date)->format('jS F Y')}}</span>
                </h2>
                <p class="mt-4">
                    <a class="btn btn-lg btn-dark" href="{{route('portfolio')}}"><i class="fa-solid fa-camera"></i> &nbsp; Add your photos</a> &nbsp;
                    <a class="btn btn-lg btn-dark" href=""><i class="fa-solid fa-user"></i> &nbsp; Edit Profile Info</a>
                </p>
            </div>
        </div>
    </div>
@endsection
