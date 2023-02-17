@extends('admin.header')
@section('content')

    <div class="row">
        @if(request()->is('admin/model/info*'))
            <div class="col-md-6">
                <h5 class="fs-4 text-dark fw-bold mb-3">Model Info</h5>
                <div class="text-left">
                    <img src="{{asset('storage/image/' . $model_info[0]['portfolioWithContestPhoto']['file_name'] . '.' . $model_info[0]['portfolioWithContestPhoto']['ext'])}}" alt="" class="img-fluid img-thumbnail profile-photo">
                </div>
                <div class="info mt-2 mb-3 p-3">
                    <p class="mb-0">Name: <span class="fw-bold">{{$model_info[0]['name']}}</span></p>
                    <p class="mb-0">Email: <span class="fw-bold">{{$model_info[0]['email']}}</span></p>
                    <p class="mb-0">Gender: <span class="fw-bold">{{$model_info[0]['gender']}}</span></p>
                    <p class="mb-0">State: <span class="fw-bold">{{$model_info[0]['state']}}</span></p>
                    <p class="mb-0">City: <span class="fw-bold">{{$model_info[0]['city']}}</span></p>
                    <p class="mb-0">Civil Stats: <span class="fw-bold">{{$model_info[0]['civil']}}</span></p>
                    <p class="mb-0">WhatsApp: <span class="fw-bold">{{$model_info[0]['wp']}}</span></p>
                </div>
                <div class="notes p-3">
                    <h6 class="fs-6 text-black-50 fw-bold">Notes/Interest</h6>
                    <p>
                        {{$model_info[0]['interest']}}
                    </p>
                </div>


            </div>

            <div class="col-md-4 sec-box">
                <div class=" row">
                    @foreach($model_info[0]['portfolios'] as $gallery)
                        <div class="col-md-4 mb-1 mt-2">
                            <img src="{{asset('storage/image/' . $gallery['file_name'] . '.' . $gallery['ext'])}}" alt="" class="img-fluid img-thumbnail gallery-photo">
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

@endsection
