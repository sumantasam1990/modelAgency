@extends('header')
@section('content')

    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="d-flex align-items-start">
                <img src="{{asset('storage/image/' . $data->portfolio->file_name . '.' . $data->portfolio->ext)}}" class="mr-md-3 rounded-circle p-2 border profile-photo" alt="{{$data->name}}">
                <div class="d-flex flex-column ml-3">
                    <h4 class="mb-0 fw-bold fs-2">{{$data->name}},
                        <span>
                            {{\Illuminate\Support\Carbon::now()->diff(\Illuminate\Support\Carbon::now()->subMonths($data->preferences['_age']))->y}}
                        </span>
                    </h4>
                    <p class="mb-0 fw-bold fs-5">Contests Won: {{$contestsWon}}</p>
                    <p class="mb-0">{{$data->gender}}</p>
                    <p class="mb-0">{{$data->state_name->nome}}, {{$data->city_name->nome}}, {{$data->district}}</p>
                    <p class="mb-0">WhatsApp: {{$data->wp}}</p>
                    <p class="mb-0">{{$data->civil}}</p>

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
                    <div class="col-md-3 mb-1 p-2 text-center">
                        <img src="{{asset('storage/image/' . $photo->file_name . '.' . $photo->ext)}}" alt="" class="img-fluid grid-photo" alt="{{$data->name}}">
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
