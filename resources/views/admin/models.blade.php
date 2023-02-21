@extends('admin.header')
@section('content')

    <div class="row" style="position: relative;">
        <div class="col-md-3 border sec-box">
            <h5 class="fs-5 fw-bold text-dark mb-2">Filter</h5>
            <form action="{{route('admin.model.search')}}" method="get">
                <input type="hidden" name="alpha" value="{{request('alpha')}}">

                <div class="d-grid gap-2 col-12 mb-3">
                    <button type="submit" name="s" class="btn btn-dark"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
                </div>

                <div class="mb-2">
                    <input type="search" class="form-control" name="keyword" placeholder="Search with name,email,wp..."
                           value="{{request('keyword') !== null ? request('keyword') : ''}}">
                </div>

                <livewire:state-city-select-box :selectedState="request('state')" :selectedCity="request('city')" />

                <div class="bg-light p-2 mb-2" style="border-radius: 10px;">
                    <div class="mb-2 form-check">
                        <input type="radio" class="form-check-input" name="filter_one"
                               {{request('filter_one') == '1' ? 'checked' : ''}} value="1"> <label
                            class="form-check-label" for="flexCheckDefault">
                            Subscribed Models
                        </label>
                    </div>
                    <div class="mb-2 form-check">
                        <input type="radio" class="form-check-input" name="filter_one"
                               {{request('filter_one') == '0' ? 'checked' : ''}} value="0"> <label
                            class="form-check-label" for="flexCheckDefault">
                            Registered Models
                        </label>
                    </div>
                </div>

                <div class="bg-light p-2 mb-2" style="border-radius: 10px;">
                    <div class="mb-2 form-check">
                        <input type="radio" class="form-check-input" name="filter_two"
                               {{request('filter_two') == '0' ? 'checked' : ''}} value="0"> <label
                            class="form-check-label" for="flexCheckDefault">
                            New Models
                        </label>
                    </div>
                    <div class="mb-2 form-check">
                        <input type="radio" class="form-check-input" name="filter_two"
                               {{request('filter_two') == '1' ? 'checked' : ''}} value="1"> <label
                            class="form-check-label" for="flexCheckDefault">
                            Approved Models
                        </label>
                    </div>
                    <div class="mb-2 form-check">
                        <input type="radio" class="form-check-input" name="filter_two"
                               {{request('filter_two') == '2' ? 'checked' : ''}} value="2"> <label
                            class="form-check-label" for="flexCheckDefault">
                            Hidden Models
                        </label>
                    </div>
                </div>

                <div class="bg-light p-2 mb-2" style="border-radius: 10px;">
                    <h5 class="fw-bold fs-6 mt-0 text-center border-black-50 border border-2 p-2">Save Filters</h5>
                    @foreach($saveFilters as $filter)
                        <div class="mb-2 form-check d-flex flex-row justify-content-between align-items-center">
                            <div>
                                <input type="radio" class="form-check-input" name="save_filter" value="{{$filter->url}}" {{request('save_filter') == $filter->url ? 'checked' : ''}}>
                                <label
                                    class="form-check-label" for="flexCheckDefault">
                                    {{$filter->title}}
                                </label>
                            </div>
                            <div>
                                <a onclick="return confirm('Are you sure?');" class="fs-6 text-danger" href="{{route('admin.filter.delete', [$filter->id])}}"><i class="fa-solid fa-trash"></i></a>
                            </div>

                        </div>
                    @endforeach
                    @if(count($saveFilters) === 0)
                        <p>No filter has been created.</p>
                    @endif
                </div>

                <div class="d-grid gap-2 col-12 mt-2">
                    <button type="submit" name="s" class="btn btn-dark"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
                </div>

            </form>

            <form action="{{route('admin.save.filter')}}" method="post">
                @csrf
                <div class="bg-light p-2 mb-2 mt-3" style="border-radius: 10px;">
                    <h4 class="fw-bold fs-6 mt-0 text-center border-black-50 border border-2 p-2">New Filter</h4>
                    <h5 class="fs-6 fw-bold text-black-50">Gender</h5>
                    <div class="mb-2 form-check">
                        <input type="checkbox" class="form-check-input" name="gender[]"
                               value="male" {{isset(request('gender')[0]) && in_array('male', request('gender')) ? 'checked' : ''}}>
                        <label class="form-check-label" for="flexCheckDefault">
                            Male
                        </label>
                    </div>
                    <div class="mb-2 form-check">
                        <input type="checkbox" class="form-check-input" name="gender[]"
                               value="female" {{isset(request('gender')[0]) && in_array('female', request('gender')) ? 'checked' : ''}}>
                        <label class="form-check-label" for="flexCheckDefault">
                            Female
                        </label>
                    </div>
                    <div class="mb-2 form-check">
                        <input type="checkbox" class="form-check-input" name="gender[]"
                               value="male_trans" {{isset(request('gender')[0]) && in_array('male_trans', request('gender')) ? 'checked' : ''}}>
                        <label class="form-check-label" for="flexCheckDefault">
                            Male trans
                        </label>
                    </div>
                    <div class="mb-2 form-check">
                        <input type="checkbox" class="form-check-input" name="gender[]"
                               value="female_trans" {{isset(request('gender')[0]) && in_array('female_trans', request('gender')) ? 'checked' : ''}}>
                        <label class="form-check-label" for="flexCheckDefault">
                            Female trans
                        </label>
                    </div>

                    <h5 class="fs-6 fw-bold text-black-50">Civil Status</h5>
                    <div class="mb-2 form-check">
                        <input type="checkbox" class="form-check-input" name="civil[]"
                               value="single" {{isset(request('civil')[0]) && in_array('single', request('civil')) ? 'checked' : ''}}>
                        <label class="form-check-label" for="flexCheckDefault">
                            Single
                        </label>
                    </div>
                    <div class="mb-2 form-check">
                        <input type="checkbox" class="form-check-input" name="civil[]"
                               value="married" {{isset(request('civil')[0]) && in_array('married', request('civil')) ? 'checked' : ''}}>
                        <label class="form-check-label" for="flexCheckDefault">
                            Married
                        </label>
                    </div>

                    <h5 class="fs-6 fw-bold text-black-50">Age</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="number" class="form-control" value="5">
                        </div>
                        <div class="col-md-6">
                            <input type="number" class="form-control" value="99">
                        </div>
                    </div>

                    <h5 class="fs-6 fw-bold text-black-50 mt-2">Height</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="number" class="form-control" value="4.0">
                        </div>
                        <div class="col-md-6">
                            <input type="number" class="form-control" value="10.0">
                        </div>
                    </div>

                    <h5 class="fs-6 fw-bold text-black-50 mt-2">Weight</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="number" class="form-control" value="5">
                        </div>
                        <div class="col-md-6">
                            <input type="number" class="form-control" value="200">
                        </div>
                    </div>
                </div>

                <div class="mb-2">
                    <input type="text" class="form-control" placeholder="Filter name" name="title">
                </div>


                <div class="d-grid gap-2 col-12">
                    <button type="submit" class="btn btn-dark"><i class="fa-solid fa-floppy-disk"></i> Save Filter</button>
                </div>
            </form>


        </div>
        <div class="col-md-6">
            @if(request('filter_one') > '0' && request('filter_two') > '0')
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex flex-row justify-content-between flex-wrap">
                            @for ($i = 65; $i <= 90; $i++)
                                <p class="fs-5">
                                    <a class="text-decoration-none text-black"
                                       href="?alpha={{chr($i)}}">{{ chr($i) }}</a>
                                </p>
                            @endfor
                        </div>
                    </div>
                </div>
            @endif


            <div class="row admin-secondary-nav">
                <div class="col-12">

                    @if(!empty($data))
                        <nav style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
                            <ol class="breadcrumb d-flex flex-row justify-content-start align-content-center align-items-center">
                                <li class="breadcrumb-item"><a
                                        class="text-decoration text-light btn btn-secondary"
                                        href="{{route('admin.models', request()->query())}}">Photos</a></li>

                                @livewire('show-user-modal', ['userId' => count($data) > 0 ? $data[0]['uid'] : 0])

                                <li class="breadcrumb-item {{ (request()->is('admin/add/contest')) ? 'active-admin' : '' }}"
                                    aria-current="page"><a
                                        class="text-decoration text-light btn {{ (request()->is('admin/model')) ? 'btn-dark' : 'btn-secondary' }}"
                                        href="{{route('add.contest')}}">Notes</a></li>

                                @livewire('config-modal', ['userId' => count($data) > 0 ? $data[0]['uid'] : 0])
                            </ol>
                        </nav>
                    @else
                        <p class="fw-bold fs-5">No model found.</p>
                    @endif

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
                        <div class="col-md-3 col-6 mb-4 mt-2 col-lg-4 col-xl-4 col-xxl-4 col-sm-6">
                            <img src="{{asset('storage/image/' . $gallery['file_name'] . '.' . $gallery['ext'])}}"
                                 alt="" class="img-fluid img-thumbnail profile-photo">
                        </div>
                    @endforeach

                @endforeach
            </div>
        </div>
        {{--        @if(request()->is('admin/model/info*'))--}}
        @if(!empty($data))
        <div class="col-md-3 border sec-box" id="right-box" style="height: 100vh; overflow: auto;">
            <h5 class="fs-5 text-dark fw-bold mb-3">Model Info</h5>
            <div class="text-center">
                <img
                    src="{{asset('storage/image/' . (!empty($data) ? $data[0]['portfolioWithContestPhoto']['file_name'] : '') . '.' . (!empty($data) ? $data[0]['portfolioWithContestPhoto']['ext'] : ''))}}"
                    alt="" class="img-fluid img-thumbnail profile-photo">
            </div>
            <div class="info mt-2 mb-3 p-3">
                <p class="mb-0">Name: <span class="fw-bold">{{!empty($data) ? $data[0]['name'] : ''}}</span></p>
                <p class="mb-0">Email: <span class="fw-bold">{{!empty($data) ? $data[0]['email'] : ''}}</span></p>
                <p class="mb-0">Gender: <span class="fw-bold">{{!empty($data) ? $data[0]['gender'] : ''}}</span></p>
                <p class="mb-0">State: <span class="fw-bold">{{!empty($data) ? $data[0]['state']: ''}}</span></p>
                <p class="mb-0">City: <span class="fw-bold">{{!empty($data) ? $data[0]['city'] : ''}}</span></p>
                <p class="mb-0">Civil Stats: <span class="fw-bold">{{!empty($data) ? $data[0]['civil'] : ''}}</span></p>
                <p class="mb-0">WhatsApp: <span class="fw-bold">{{!empty($data) ? $data[0]['wp'] : ''}}</span></p>
            </div>

            <div class="notes p-3">
                <h6 class="fs-6 text-black-50 fw-bold">Admin Notes</h6>
                <div class="mb-2">
                    <livewire:admin-notes :uid="$data[0]['uid']" :note="$admin_note->note ?? ''" />
                </div>
            </div>

        </div>
        @endif
    </div>


    @if(!empty($data))
        <div class="star-container">
            @for($i=1; $i<=5; $i++)
                @if ($i <= $data[0]['infos'][0]['rating'])
                    <a class="text-warning" href="{{route('admin.model.rate', [$i, $data[0]['uid']])}}"><i
                            class="fa-solid fa-star"></i></a>
                @else
                    <a class="text-dark" href="{{route('admin.model.rate', [$i, $data[0]['uid']])}}"><i
                            class="fa-regular fa-star"></i></a>
                @endif
            @endfor

            @if($data[0]['love'] > 0)
                <a class="text-danger" href="{{route('admin.model.heart', [0, $data[0]['uid']])}}"><i
                        class="fa-solid fa-heart"></i></a>
            @else
                <a class="text-dark" href="{{route('admin.model.heart', [1, $data[0]['uid']])}}"><i
                        class="fa-regular fa-heart"></i></a>
            @endif

            @php
                $queryParams = request()->query();
                unset($queryParams['page']);
                $url_prev_query_string = http_build_query($queryParams) . '&s=';
            @endphp
            <a href="{{$data[0]['prev_page_url'] == '' ? '#' : $data[0]['prev_page_url'] . '&' .$url_prev_query_string }}"
               class="text-dark {{$data[0]['prev_page_url'] == '' ? 'text-black-50' : ''}}"><i
                    class="fa-solid fa-circle-chevron-left"></i></a>
            <a href="{{$data[0]['next_page_url'] == '' ? '#' : $data[0]['next_page_url'] . '&' . $url_prev_query_string}}"
               class="text-dark {{$data[0]['next_page_url'] == '' ? 'text-black-50' : ''}}"><i
                    class="fa-solid fa-circle-chevron-right"></i></a>

            @if($data[0]['user_status'] === 1)
                <i class="fa-solid fa-circle-check text-success fs-2"></i>
            @elseif($data[0]['user_status'] === 2)
                <i class="fa-solid fa-circle-xmark text-danger fs-2"></i>
            @else
                <a href="{{route('admin.model.status', [$data[0]['uid'], 1])}}"><i
                        class="fa-solid fa-circle-check text-success "></i></a>
                <a href="{{route('admin.model.status', [$data[0]['uid'], 2])}}"><i
                        class="fa-solid fa-circle-xmark text-danger "></i></a>
            @endif


        </div>
    @endif

@endsection

