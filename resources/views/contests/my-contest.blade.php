@extends('header')
@section('content')
    <div class="row">
        <div class="col-md-8">
            <h4 class="fw-bold fs-4 mb-1">My Contests</h4>
            <p class="text-black-50 mb-3 fs-6">List of contest that you have participated.</p>
            <div class="row">
                <div class="col-md-10">
                    @foreach($results_s as $contest)
                        <div class="sec-box mb-3">
                            <div class="d-flex">
                                <div class="flex-grow-1 ms-3">
                                    <h4>{{$contest['contest_name']}} - <span class="text-black-50">{{$contest['start']}}</span></h4>
                                    This contest is starting on <span class="fw-bold">{{$contest['start']}}</span>.
                                    <hr />
                                    <div class="row">
                                        @foreach($contest['winners'] as $winner)
                                        <div class="col-md-4">

                                        </div>
                                        @endforeach
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
                <div class="col-md-6">
                    <img src="{{asset('storage/image/' . $myContests->portfolio->file_name . '.' . $myContests->portfolio->ext)}}" alt="" class="img-fluid img-thumbnail image">
                </div>
            </div>
        </div>
    </div>

@endsection
