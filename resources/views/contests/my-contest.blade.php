@extends('header')
@section('content')
    <div class="row">
        <div class="col-md-8">
            <h4 class="fw-bold fs-4 mb-1">My Contests</h4>
            <p class="text-black-50 mb-3 fs-6">List of contest that you have participated.</p>
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
                                    <h4 class="fw-bold">{{$contest['contest_name']}} - <span class="text-black-50">{{$contest['start']}}</span></h4>
                                    <p>End contest: <span class="fw-bold">{{$contest['end']}}</span>.</p>
                                    <hr />

                                    <div class="d-flex flex-row justify-content-around align-content-center">
                                        <div class="fs-5 fw-bold">
                                            <i class="fa-sharp fa-solid fa-trophy"></i> ${{$contest['contest_first_prize']}}
                                            <p class="fs-6 text-black-50">First Prize</p>
                                        </div>
                                        <div class="fs-5 fw-bold">
                                            <i class="fa-sharp fa-solid fa-trophy"></i> ${{$contest['contest_second_prize']}}
                                            <p class="fs-6 text-black-50">Second Prize</p>
                                        </div>
                                        <div class="fs-5 fw-bold">
                                            <i class="fa-sharp fa-solid fa-trophy"></i> ${{$contest['contest_third_prize']}}
                                            <p class="fs-6 text-black-50">Third Prize</p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <h4 class="fw-bold fs-4 mb-3">Contest Photo</h4>
            <div class="row">
                <div class="col-md-12">
                    <img src="{{asset('storage/image/' . $myContests->portfolio_without_profile_photo->file_name . '.' . $myContests->portfolio_without_profile_photo->ext)}}" alt="" class="img-fluid img-thumbnail image profile-photo">
                    <p class="mt-2">
                        <a href="{{route('portfolio')}}" class="text-black text-decoration-none mt-2 fw-bold"><i class="fa-solid fa-camera"></i> &nbsp; Change Contest Photo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

@endsection
