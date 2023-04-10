@extends('header')
@section('content')
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="d-flex flex-column justify-content-center align-items-center align-content-center text-center">
                <p class="fs-1 text-success fw-bold">
                    <i class="fa-solid fa-circle-check"></i>
                </p>
                <h2 class="fw-bold fs-4 text-dark">
                    {{__('main.subscription_conf')}} <br /><br /> Sua data de renovação é
                    <span class="fw-bold">{{\Carbon\Carbon::parse($endDate->end_date)->isoFormat('Do [de] MMMM [de] YYYY')}}</span>
                </h2>
                <p class="mt-4">
                    <a class="btn btn-lg btn-dark" href="{{route('portfolio')}}"><i class="fa-solid fa-camera"></i> &nbsp; Adicionar suas fotos</a> &nbsp;
                </p>
            </div>
        </div>
    </div>
@endsection
