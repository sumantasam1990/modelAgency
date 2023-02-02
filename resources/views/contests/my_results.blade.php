@extends('header')
@section('content')

    <div class="row mb-4">
        <div class="col-md-8">
            <h4 class="fw-bold fs-4 mb-1">My Results</h4>
            <p class="text-black-50 mb-3 fs-6">List of contest and my stats.</p>

            <div class="row mt-3">
                <div class="col-md-10">
                    @if(count($data) === 0)
                        <p class="fw-bold">
                            No contest found.
                        </p>
                    @endif
                    @foreach($data as $contest)
                        <div class="sec-box mb-3">
                            <div class="d-flex text-center">
                                <div class="flex-grow-1 ms-3">
                                    <h4 class="fw-bold fs-4 text-black">{{$contest['contest_name']}} - <span class="text-black-50">{{$contest['start']}}</span></h4>

                                    <hr />

                                    <div class="row mt-4">
                                        @foreach($contest['winners'] as $winner)
                                            <div class="col-md-4 mx-auto">
                                                <a href="{{route('profile', [$winner['username']])}}">
                                                    <img src="{{asset('storage/image/' . $winner['user_image']['image_path'])}}" class="img-fluid img-thumbnail profile-photo" alt="">
                                                </a>
                                                <p class="mt-3">
                                                    <span class="fw-bold">{{$winner['user_name']}}</span>  <br> Total votes: <span class="fw-bold">{{$winner['total_votes']}}</span>
                                                </p>
                                                <p>
                                                    <span class="badge bg-warning fw-bold fs-6">
                                                        <i class="fa-solid fa-trophy"></i>
                                                        You {{$contest['winner']}}
                                                    </span>
                                                </p>
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

    </div>

@endsection
