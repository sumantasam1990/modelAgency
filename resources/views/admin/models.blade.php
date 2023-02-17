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


            <div class="row admin-secondary-nav">
                <div class="col-12">
                    <nav style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
                        <ol class="breadcrumb d-flex flex-row justify-content-start align-content-center align-items-center">
                            <li class="breadcrumb-item"><a class="text-decoration text-light btn  {{ (request()->is('admin/model*')) ? 'btn-dark' : 'btn-secondary' }}" href="{{route('admin.models', request()->query())}}">Photos</a></li>
                            <li class="breadcrumb-item {{ (request()->is('admin/contest/winners')) ? 'active-admin' : '' }}" aria-current="page"><a class="text-decoration text-light btn {{ (request()->is('admin/model')) ? 'btn-dark' : 'btn-secondary' }}" href="{{route('admin.winners')}}">About</a></li>
                            <li class="breadcrumb-item {{ (request()->is('admin/add/contest')) ? 'active-admin' : '' }}" aria-current="page"><a class="text-decoration text-light btn {{ (request()->is('admin/model')) ? 'btn-dark' : 'btn-secondary' }}" href="{{route('add.contest')}}">Notes</a></li>
                            <li class="breadcrumb-item {{ (request()->is('admin/add/category')) ? 'active-admin' : '' }}" aria-current="page"><a class="text-decoration text-light btn {{ (request()->is('admin/model')) ? 'btn-dark' : 'btn-secondary' }}" href="{{route('add.category')}}">Config</a></li>
                        </ol>
                    </nav>
                </div>
            </div>


            <div class="row">
            @foreach($data as $d)
                    @php
                        $existingQuery = request()->query();
                        $routeParams = [$d['uid']];
                        $params = array_merge($routeParams, $existingQuery);
                    @endphp

                        @foreach($data[0]['portfolios'] as $gallery)
                            <div class="col-md-3 mb-4 mt-2">
                                <img src="{{asset('storage/image/' . $gallery['file_name'] . '.' . $gallery['ext'])}}" alt="" class="img-fluid img-thumbnail profile-photo">
                            </div>
                        @endforeach

                @endforeach
            </div>
        </div>
{{--        @if(request()->is('admin/model/info*'))--}}
        <div class="col-md-4 border sec-box" id="right-box" style="height: 100vh; overflow: auto;">
                <h5 class="fs-5 text-dark fw-bold mb-3">Model Info</h5>
                <div class="text-center">
                    <img src="{{asset('storage/image/' . $data[0]['portfolioWithContestPhoto']['file_name'] . '.' . $data[0]['portfolioWithContestPhoto']['ext'])}}" alt="" class="img-fluid img-thumbnail profile-photo">
                </div>
                <div class="info mt-2 mb-3 p-3">
                    <p class="mb-0">Name: <span class="fw-bold">{{$data[0]['name']}}</span></p>
                    <p class="mb-0">Email: <span class="fw-bold">{{$data[0]['email']}}</span></p>
                    <p class="mb-0">Gender: <span class="fw-bold">{{$data[0]['gender']}}</span></p>
                    <p class="mb-0">State: <span class="fw-bold">{{$data[0]['state']}}</span></p>
                    <p class="mb-0">City: <span class="fw-bold">{{$data[0]['city']}}</span></p>
                    <p class="mb-0">Civil Stats: <span class="fw-bold">{{$data[0]['civil']}}</span></p>
                    <p class="mb-0">WhatsApp: <span class="fw-bold">{{$data[0]['wp']}}</span></p>
                </div>
                <div class="notes p-3">
                    <h6 class="fs-6 text-black-50 fw-bold">Notes/Interest</h6>
                    <p>
                        {{$data[0]['interest']}}
                    </p>
                </div>
        </div>
{{--        @endif--}}
    </div>


    <div class="star-container">
        @for($i=1; $i<=5; $i++)
            @if ($i <= $data[0]['infos'][0]['rating'])
                <a class="text-warning" href="{{route('admin.model.rate', [$i, $data[0]['uid']])}}"><i class="fa-solid fa-star"></i></a>
            @else
                <a class="text-dark" href="{{route('admin.model.rate', [$i, $data[0]['uid']])}}"><i class="fa-regular fa-star"></i></a>
            @endif
        @endfor

        @if($data[0]['love'] > 0)
                <a class="text-danger" href="{{route('admin.model.heart', [0, $data[0]['uid']])}}"><i class="fa-solid fa-heart"></i></a>
            @else
                <a class="text-dark" href="{{route('admin.model.heart', [1, $data[0]['uid']])}}"><i class="fa-regular fa-heart"></i></a>
        @endif

            @php
                $queryParams = request()->query();
                unset($queryParams['page']);
                $url_prev_query_string = http_build_query($queryParams);
            @endphp
            <a href="{{$data[0]['prev_page_url'] == '' ? '#' : $data[0]['prev_page_url'] . '&' .$url_prev_query_string }}" class="text-dark {{$data[0]['prev_page_url'] == '' ? 'text-black-50' : ''}}"><i class="fa-solid fa-circle-chevron-left"></i></a>
            <a href="{{$data[0]['next_page_url'] == '' ? '#' : $data[0]['next_page_url'] . '&' . $url_prev_query_string}}" class="text-dark {{$data[0]['next_page_url'] == '' ? 'text-black-50' : ''}}"><i class="fa-solid fa-circle-chevron-right"></i></a>

    </div>

@endsection
