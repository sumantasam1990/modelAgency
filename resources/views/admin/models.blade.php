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
                    <input type="text" class="form-control" name="keyword" placeholder="Search with name,email,wp..."
                           value="{{request('keyword') !== null ? request('keyword') : ''}}">
                    @error('keyword')
                    <div class="text-danger fw-bold">{{ $message }}</div>
                    @enderror
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
                    @error('filter_one')
                    <div class="text-danger fw-bold">{{ $message }}</div>
                    @enderror
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
                    @error('filter_two')
                    <div class="text-danger fw-bold">{{ $message }}</div>
                    @enderror
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

{{--                    <h5 class="fs-6 fw-bold text-black-50">Age(in months)</h5>--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-md-6">--}}
{{--                            <input type="number" class="form-control" name="age_from" placeholder="">--}}
{{--                        </div>--}}
{{--                        <div class="col-md-6">--}}
{{--                            <input type="number" class="form-control" name="age_to" placeholder="">--}}
{{--                        </div>--}}
{{--                    </div>--}}

                    <h5 class="fs-6 fw-bold text-black-50 mt-2">Height(m)</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <select class="form-control" name="h_from">
                                <option value="">Choose</option>
                                @for ($i = 0.1; $i <= 20; $i++)
                                    @for ($j = 0; $j <= 9; $j++)
                                        @php $value = $i + ($j / 10); @endphp
                                        <option value="{{ $value }}">{{ $value }} meters</option>
                                    @endfor
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control" name="h_to">
                                <option value="">Choose</option>
                                @for ($i = 0.1; $i <= 20; $i++)
                                    @for ($j = 0; $j <= 9; $j++)
                                        @php $value = $i + ($j / 10); @endphp
                                        <option value="{{ $value }}">{{ $value }} meters</option>
                                    @endfor
                                @endfor
                            </select>
                        </div>
                    </div>

                    <h5 class="fs-6 fw-bold text-black-50 mt-2">Skin color</h5>
                    <div class="mb-2">
                        <select class="form-control" name="_skin">
                            <option value="">Choose</option>
                            <option {{request('_skin') == "White" ? 'selected' : ''}}>White</option>
                            <option {{request('_skin') == "Brown" ? 'selected' : ''}}>Brown</option>
                            <option {{request('_skin') == "Black" ? 'selected' : ''}}>Black</option>
                        </select>
                    </div>

                    <h5 class="fs-6 fw-bold text-black-50 mt-3">Dress size</h5>
                    <div class="mb-2">
                        <select class="form-control" name="dress">
                            <option value="">Choose</option>
                            @foreach($arr as $a)
                                <option value="{{$a}}">{{$a}}</option>
                            @endforeach
                        </select>
                    </div>

                    <h5 class="fs-6 fw-bold text-black-50 mt-3">Hair color</h5>
                    <div class="mb-2">
                        <select class="form-control" name="hair">
                            <option value="">Choose</option>
                            <option {{request('hair') == "White" ? 'selected' : ''}}>White</option>
                            <option {{request('hair') == "Black" ? 'selected' : ''}}>Black</option>
                            <option {{request('hair') == "Blond" ? 'selected' : ''}}>Blond</option>
                            <option {{request('hair') == "Color" ? 'selected' : ''}}>Color</option>
                        </select>
                    </div>

                    <h5 class="fs-6 fw-bold text-black-50 mt-3">Eyes color</h5>
                    <div class="mb-2">
                        <select class="form-control" name="eyes">
                            <option value="">Choose</option>
                            <option {{request('eyes') == "Blue" ? 'selected' : ''}}>Blue</option>
                            <option {{request('eyes') == "Brown" ? 'selected' : ''}}>Brown</option>
                            <option {{request('eyes') == "Green" ? 'selected' : ''}}>Green</option>
                            <option {{request('eyes') == "Hazel" ? 'selected' : ''}}>Hazel</option>
                            <option {{request('eyes') == "Black" ? 'selected' : ''}}>Black</option>
                            <option {{request('eyes') == "Purple" ? 'selected' : ''}}>Purple</option>
                        </select>
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
{{--                            @for ($i = 65; $i <= 90; $i++)--}}
{{--                                <p class="fs-5">--}}
{{--                                    <a class="text-decoration-none text-black"--}}
{{--                                       href="?alpha={{chr($i)}}">{{ chr($i) }}</a>--}}
{{--                                </p>--}}
{{--                            @endfor--}}
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
                                        href="">Photos</a></li>

                                @livewire('show-user-modal', ['userId' => count($data) > 0 ? $data[0]['uid'] : 0])

{{--                                <li class="breadcrumb-item {{ (request()->is('admin/add/contest')) ? 'active-admin' : '' }}"--}}
{{--                                    aria-current="page"><a--}}
{{--                                        class="text-decoration text-light btn {{ (request()->is('admin/model')) ? 'btn-dark' : 'btn-secondary' }}"--}}
{{--                                        href="{{route('add.contest')}}">Notes</a></li>--}}

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
                @if($data[0]['portfolioWithContestPhoto']['file_name'] != '')
                    <img
                        src="{{asset('storage/image/' . (!empty($data) ? $data[0]['portfolioWithContestPhoto']['file_name'] : '') . '.' . (!empty($data) ? $data[0]['portfolioWithContestPhoto']['ext'] : ''))}}"
                        alt="" class="img-fluid img-thumbnail profile-photo">
                @endif

                <div class="text-center mt-2">
                    <span class="badge bg-primary fs-6">{{$data[0]['user_subscribe'] === 1 ? 'Subscribed' : 'Registered'}}</span>
                </div>
                    <div class=" mt-2 text-center">
                        <a href="{{$data[0]['preferences']['social']['insta']['url'] ?? '#'}}" target="_blank" class="btn btn-dark btn-sm ">Instagram</a>
                        <a href="{{$data[0]['preferences']['social']['tiktok']['url'] ?? '#'}}" target="_blank" class="btn btn-dark btn-sm ">Tiktok</a>
                        <a href="{{$data[0]['preferences']['social']['other']['url'] ?? '#'}}" target="_blank" class="btn btn-dark btn-sm">{{$data[0]['preferences']['social']['other']['label'] ?? 'Other'}}</a>
                    </div>

            </div>
            <div class="info mt-2 mb-3 p-3">
                <p class="mb-0">Name: <span class="fw-bold">{{!empty($data) ? $data[0]['name'] : ''}}</span></p>
                <p class="mb-0">Age: <span class="fw-bold">{{!empty($data) ? $data[0]['age'] : ''}}</span></p>
                <p class="mb-0">Height: <span class="fw-bold">{{!empty($data) ? $data[0]['height'] . 'm' : ''}}</span></p>
                <p class="mb-0">Dress: <span class="fw-bold">{{!empty($data) ? $data[0]['dress'] : ''}}</span></p>
                <p class="mb-0">Bust: <span class="fw-bold">{{!empty($data) ? $data[0]['bust'] : ''}}</span></p>
                <p class="mb-0">Waist: <span class="fw-bold">{{!empty($data) ? $data[0]['waist'] : ''}}</span></p>
                <p class="mb-0">Hips: <span class="fw-bold">{{!empty($data) ? $data[0]['hips'] : ''}}</span></p>


                <p class="mb-0">Email: <span class="fw-bold">{{!empty($data) ? $data[0]['email'] : ''}}</span></p>
                <p class="mb-0">Gender: <span class="fw-bold">{{!empty($data) ? $data[0]['gender'] : ''}}</span></p>
                <p class="mb-0">State: <span class="fw-bold">{{!empty($data) ? $data[0]['state']: ''}}</span></p>
                <p class="mb-0">City: <span class="fw-bold">{{!empty($data) ? $data[0]['city'] : ''}}</span></p>
                <p class="mb-0">District: <span class="fw-bold">{{!empty($data) ? $data[0]['district'] : ''}}</span></p>
                <p class="mb-0">Civil Stats: <span class="fw-bold">{{!empty($data) ? $data[0]['civil'] : ''}}</span></p>
                <p class="mb-0">WhatsApp: <span class="fw-bold">{{!empty($data) ? $data[0]['wp'] : ''}}</span></p>
            </div>

            <div class="notes p-3">
                <h6 class="fs-6 text-black fw-bold mb-0">Admin Notes</h6>
                <small class="fw-bold text-black-50 mb-3">Write anything and press "enter" to save.</small>
                <div class="mb-2 mt-2">
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
                    <a href="{{route('admin.model.status', [$data[0]['uid'], 2])}}"><i
                            class="fa-solid fa-circle-xmark text-danger "></i></a>
            @elseif($data[0]['user_status'] === 2)
                <i class="fa-solid fa-circle-xmark text-danger fs-2"></i>
                    <a href="{{route('admin.model.status', [$data[0]['uid'], 1])}}"><i
                            class="fa-solid fa-circle-check text-success "></i></a>
            @else
                <a href="{{route('admin.model.status', [$data[0]['uid'], 1])}}"><i
                        class="fa-solid fa-circle-check text-success "></i></a>
                <a href="{{route('admin.model.status', [$data[0]['uid'], 2])}}"><i
                        class="fa-solid fa-circle-xmark text-danger "></i></a>
            @endif


        </div>
    @endif

@endsection

