@extends('admin.header')
@section('content')

    <div class="row">
        <div class="col-2 border"></div>
        <div class="col-7">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex flex-row justify-content-between flex-wrap">
                        @for ($i = 65; $i <= 90; $i++)
                            <p class="fs-5">
                                <a class="text-decoration-none text-black" href="?alpha={{chr($i)}}">{{ chr($i) }}</a>
                            </p>
                        @endfor
                    </div>
                </div>
            </div>
            <div class="row">
            @foreach($data as $d)
                    @php
                        $existingQuery = request()->query();
                        $routeParams = [$d->id];
                        $params = array_merge($routeParams, $existingQuery);
                    @endphp
                    <div class="col-md-4 mb-4">
                        <a href="{{route('admin.model.info', $params)}}">
                            <img src="{{asset('storage/image/' . $d->portfolio->file_name . '.' . $d->portfolio->ext)}}" alt="{{$d->name}}" class="img-thumbnail img-fluid profile-photo">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-3 border sec-box">
            @if(request()->is('admin/model/info*'))
                <h5 class="fs-5 text-black-50 text-center">Model Info</h5>
                <div class="text-center">
                    <img src="{{asset('storage/image/' . $model_info->portfolioWithContestPhoto->file_name . '.' . $model_info->portfolioWithContestPhoto->ext)}}" alt="" class="img-fluid img-thumbnail profile-photo">
                </div>
                <div class="info mt-2 mb-3 p-3">
                    <p class="mb-0">Name: <span class="fw-bold">{{$model_info->name}}</span></p>
                    <p class="mb-0">Email: <span class="fw-bold">{{$model_info->email}}</span></p>
                    <p class="mb-0">Gender: <span class="fw-bold">{{$model_info->gender}}</span></p>
                    <p class="mb-0">State: <span class="fw-bold">{{$model_info->state}}</span></p>
                    <p class="mb-0">City: <span class="fw-bold">{{$model_info->city}}</span></p>
                    <p class="mb-0">Civil Stats: <span class="fw-bold">{{$model_info->civil}}</span></p>
                    <p class="mb-0">WhatsApp: <span class="fw-bold">{{$model_info->wp}}</span></p>
                </div>
                <div class="notes p-3">
                    <h6 class="fs-6 text-black-50 fw-bold">Notes/Interest</h6>
                    <p>
                        {{$model_info->interest?->content}}
                    </p>
                </div>
            @endif
        </div>
    </div>

@endsection
