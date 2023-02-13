@extends('admin.header')
@section('content')

    <div class="row" style="position: relative;">
        <div class="col-md-2 border sec-box">
            <h5 class="fs-5 fw-bold text-dark mb-3">Filter</h5>
            <form action="{{route('admin.model.search')}}" method="get">
                <input type="hidden" name="alpha" value="{{request('alpha')}}">
                <div class="mb-2">
                    <select class="form-control">
                        <option>State</option>
                    </select>
                </div>
                <div class="mb-2">
                    <select class="form-control">
                        <option>City</option>
                    </select>
                </div>

                <div class="bg-light p-2 mb-2" style="border-radius: 10px;">
                    <div class="mb-2 form-check">
                        <input type="checkbox" class="form-check-input"> <label class="form-check-label" for="flexCheckDefault">
                            Subscribed Models
                        </label>
                    </div>
                    <div class="mb-2 form-check">
                        <input type="checkbox" class="form-check-input"> <label class="form-check-label" for="flexCheckDefault">
                            Approved Models
                        </label>
                    </div>
                    <div class="mb-2 form-check">
                        <input type="checkbox" class="form-check-input"> <label class="form-check-label" for="flexCheckDefault">
                            Hidden Models
                        </label>
                    </div>
                </div>


                <div class="bg-light p-2 mb-2" style="border-radius: 10px;">
                    <h5 class="fs-6 fw-bold text-black-50">Gender</h5>
                    <div class="mb-2 form-check">
                        <input type="checkbox" class="form-check-input" name="gender[]" value="male" {{isset(request('gender')[0]) && in_array('male', request('gender')) ? 'checked' : ''}}> <label class="form-check-label" for="flexCheckDefault">
                            Male
                        </label>
                    </div>
                    <div class="mb-2 form-check">
                        <input type="checkbox" class="form-check-input" name="gender[]" value="female" {{isset(request('gender')[0]) && in_array('female', request('gender')) ? 'checked' : ''}}> <label class="form-check-label" for="flexCheckDefault">
                            Female
                        </label>
                    </div>
                </div>

                <div class="bg-light p-2 mb-2" style="border-radius: 10px;">
                    <h5 class="fs-6 fw-bold text-black-50">Civil Status</h5>
                    <div class="mb-2 form-check">
                        <input type="checkbox" class="form-check-input" name="civil[]" value="single" {{isset(request('civil')[0]) && in_array('single', request('civil')) ? 'checked' : ''}}> <label class="form-check-label" for="flexCheckDefault">
                            Single
                        </label>
                    </div>
                    <div class="mb-2 form-check">
                        <input type="checkbox" class="form-check-input" name="civil[]" value="married" {{isset(request('civil')[0]) && in_array('married', request('civil')) ? 'checked' : ''}}> <label class="form-check-label" for="flexCheckDefault">
                            Married
                        </label>
                    </div>
                </div>

                <div class="bg-light p-2 mb-2" style="border-radius: 10px;">
                    <h5 class="fs-6 fw-bold text-black-50">Age</h5>
                    <div class="mb-2">
                        <input type="number" class="form-control" value="18">
                    </div>
                    <div class="mb-2">
                        <input type="number" class="form-control" value="35">
                    </div>
                </div>

                <div class="bg-light p-2 mb-2" style="border-radius: 10px;">
                    <h5 class="fs-6 fw-bold text-black-50">Height</h5>
                    <div class="mb-2">
                        <input type="text" class="form-control" value="4'0">
                    </div>
                    <div class="mb-2">
                        <input type="text" class="form-control" value="6'0">
                    </div>
                </div>

                <div class="bg-light p-2 mb-2" style="border-radius: 10px;">
                    <h5 class="fs-6 fw-bold text-black-50">Weight</h5>
                    <div class="mb-2">
                        <input type="number" class="form-control" value="45">
                    </div>
                    <div class="mb-2">
                        <input type="number" class="form-control" value="65">
                    </div>
                </div>


                <div class="d-grid gap-2 col-12">
                    <button type="submit" class="btn btn-dark">Search</button>
                </div>




            </form>
        </div>
        <div class="col-md-6">
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
                            <div class="image-container">
                                <img src="{{asset('storage/image/' . $d->portfolio->file_name . '.' . $d->portfolio->ext)}}" alt="{{$d->name}}" class=" img-fluid profile-photo {{$d->id == $request->id ? 'active-img' : 'inactive-img'}}">
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        @if(request()->is('admin/model/info*'))
        <div class="col-md-4 border sec-box" id="right_box" style="height: 100vh; overflow: auto;">
                <h5 class="fs-5 text-dark fw-bold mb-3">Model Info</h5>
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

                <div class="border row">
                    @foreach($model_info->portfolios as $gallery)
                        <div class="col-md-4 mb-1 mt-2">
                            <img src="{{asset('storage/image/' . $gallery->file_name . '.' . $gallery->ext)}}" alt="" class="img-fluid img-thumbnail gallery-photo">
                        </div>
                    @endforeach
                </div>
        </div>
        @endif
    </div>

    @if(request()->is('admin/model/info*'))
    <div class="star-container">

        <a class="text-dark" href="{{route('admin.model.rate', [1])}}"><i class="fa-regular fa-star"></i></a>
        <a class="text-dark" href="{{route('admin.model.rate', [2])}}"><i class="fa-regular fa-star"></i></a>
        <a class="text-dark" href="{{route('admin.model.rate', [3])}}"><i class="fa-regular fa-star"></i></a>
        <a class="text-dark" href="{{route('admin.model.rate', [4])}}"><i class="fa-regular fa-star"></i></a>
        <a class="text-dark" href="{{route('admin.model.rate', [5])}}"><i class="fa-regular fa-star"></i></a>
        <i class="fas fa-heart"></i>
    </div>
    @endif


@endsection
