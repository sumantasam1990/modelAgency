@extends('header')
@section('content')
    <div class="row">
        <div class="col-md-8">
            <h4 class="fw-bold fs-4 mb-3">{{__('main.my_contests')}}</h4>
{{--            <p class="text-black-50 mb-3 fs-6">List of contest that you have participated.</p>--}}
            <div class="row">
                <div class="col-md-10">
                    @if(count($results_s) === 0)
                        <p class="fw-bold">
                            No contest found.
                        </p>
                    @endif
                    @foreach($results_s as $contest)
                        <div class="sec-box mb-3">
                            <div class="d-flex">
                                <div class="flex-grow-1 ms-3">
                                    <h4 class="fw-bold">{{$contest['contest_name']}}</h4>
                                    <p>
                                        {{__('main.start_contest')}} <span class="fw-bold">{{$contest['start']}}</span>
                                        {{__('main.end_contest')}}: <span class="fw-bold">{{$contest['end']}}</span>.
                                    </p>

                                    <div class="accordion accordion-flush bg-warning" id="accordionFlushExample">

                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="flush-headingOne-{{$contest['contest_id']}}">
                                                    <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne-{{$contest['contest_id']}}" aria-expanded="false" aria-controls="flush-collapseOne-{{$contest['contest_id']}}">
                                                        {{__('main.rules')}}
                                                    </button>
                                                </h2>
                                                <div id="flush-collapseOne-{{$contest['contest_id']}}" class="accordion-collapse collapse" aria-labelledby="flush-headingOne-{{$contest['contest_id']}}" >
                                                    <div class="accordion-body">
                                                        {{$contest['rules']}}
                                                    </div>
                                                </div>
                                            </div>

                                    </div>

                                    <hr />

                                    <div class="d-flex flex-row justify-content-around align-content-center">
                                        <div class="fs-5 fw-bold">
                                            <i class="fa-sharp fa-solid fa-trophy"></i> ${{$contest['contest_first_prize']}}
                                            <p class="fs-6 text-black-50">{{__('main.first_prize')}}</p>
                                        </div>
                                        <div class="fs-5 fw-bold">
                                            <i class="fa-sharp fa-solid fa-trophy"></i> ${{$contest['contest_second_prize']}}
                                            <p class="fs-6 text-black-50">{{__('main.second_prize')}}</p>
                                        </div>
                                        <div class="fs-5 fw-bold">
                                            <i class="fa-sharp fa-solid fa-trophy"></i> ${{$contest['contest_third_prize']}}
                                            <p class="fs-6 text-black-50">{{__('main.third_prize')}}</p>
                                        </div>
                                    </div>

                                </div>
                                <div class="flex-shrink-0">
                                    <img class="image profile-photo" src="{{asset('storage/image/' . ($contest['contest_photo'] === null ? $myContests->portfolio_without_profile_photo->file_name.'.'.$myContests->portfolio_without_profile_photo->ext : $contest['contest_photo']) )}}" alt="contest photo">
                                    <p class="mt-2">
                                        <a href="{{route('portfolio', [$contest['contest_id']])}}" class="text-black text-decoration-none mt-2 fw-bold"><i class="fa-solid fa-camera"></i> &nbsp; {{__('main.change_contest_photo')}}</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

{{--        <div class="col-md-4">--}}
{{--            <h4 class="fw-bold fs-4 mb-3">Contest Photo</h4>--}}
{{--            <div class="row">--}}
{{--                <div class="col-md-12">--}}
{{--                    @if($myContests != null)--}}
{{--                        <img src="{{asset('storage/image/' . $myContests->portfolio_without_profile_photo->file_name . '.' . $myContests->portfolio_without_profile_photo->ext)}}" alt="" class="img-fluid img-thumbnail image profile-photo">--}}
{{--                        <p class="mt-2">--}}
{{--                            <a href="{{route('portfolio')}}" class="text-black text-decoration-none mt-2 fw-bold"><i class="fa-solid fa-camera"></i> &nbsp; Change Contest Photo</a>--}}
{{--                        </p>--}}
{{--                    @endif--}}

{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>

@endsection
