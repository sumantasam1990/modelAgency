@extends('header')
@section('content')

    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="d-flex align-items-start">
                <img src="{{asset('storage/image/' . $data->portfolio->file_name . '.' . $data->portfolio->ext)}}" class="mr-md-3 rounded-circle p-2 border profile-main-photo" alt="{{$data->name}}">
                <div class="d-flex flex-column ml-3">
                    <h4 class="mb-0 fw-bold fs-2">{{$data->name}}</h4>

                    <div class="row">
                        <div class="col-md-12">
                            <p class="mb-0 fw-semibold"><span class="fw-bold">{{$data->state_name->nome}}, {{$data->city_name->nome}}</span> </p>
                            <p class="mb-0 fw-semibold"><span class="fw-bold">{{$data->gender}}</span>, <span class="fw-bold">{{$data->civil}}</span>, <span>
                            @php
                                $age = \Carbon\Carbon::createFromFormat('Y-m-d', $data->age)->age;
                            @endphp
                                    @if($age > 12)
                                        {{$age}} years
                                    @else
                                        {{$age}} months
                                    @endif
                        </span> </p>
{{--                            <p class="mb-0 fw-bold fs-5">{{$contestsWon}} contests won</p>--}}
                        </div>
{{--                        <div class="col-md-5">--}}
{{--                            <p class="mb-0 fw-semibold">Height: <span class="fw-bold">{{$data->height}}</span></p>--}}
{{--                            <p class="mb-0 fw-semibold">Eyes: <span class="fw-bold">{{$data->eyes}}</span> </p>--}}
{{--                            <p class="mb-0 fw-semibold">Skin: <span class="fw-bold">{{$data->skin}}</span> </p>--}}
{{--                            <p class="mb-0 fw-semibold">Dress Size: <span class="fw-bold">{{$data->dress}}</span> </p>--}}
{{--                            <p class="mb-0 fw-semibold">Bust: <span class="fw-bold">{{$data->bust}}</span> </p>--}}
{{--                            <p class="mb-0 fw-semibold">Hips: <span class="fw-bold">{{$data->hips}}</span> </p>--}}
{{--                            <p class="mb-0 fw-semibold">Waist: <span class="fw-bold">{{$data->waist}}</span> </p>--}}

{{--                        </div>--}}
                    </div>


                    <div class="d-flex mt-2">
                        <a href="{{$data->preferences['social']['insta']['url'] ?? '#'}}" target="_blank" class="btn btn-dark mr-3">Instagram</a>
                        <a href="{{$data->preferences['social']['tiktok']['url'] ?? '#'}}" target="_blank" class="btn btn-dark mr-3">Tiktok</a>
                        <a href="{{$data->preferences['social']['other']['url'] ?? '#'}}" target="_blank" class="btn btn-dark">{{$data->preferences['social']['other']['label'] ?? 'Other'}}</a>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <div class="row mt-4 mb-4">
        <div class="col-md-10 mx-auto">
            <div class="row">
                @foreach($data->portfolios as $photo)
                    <div class="col-md-4 col-4 col-sm-4 col-xl-4 col-xxl-4 mb-1 p-2 text-center">
                        <img src="{{asset('storage/image/' . $photo->file_name . '.' . $photo->ext)}}" alt="" class="img-fluid grid-photo" alt="{{$data->name}}">
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
