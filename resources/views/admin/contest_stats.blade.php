@extends('header')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <h4 class="fs-4 fw-bold mb-3">Contest Stats</h4>
            <div class="row">
                @foreach($stats as $stat)
                    <div class="col-md-6 mb-3">
                        <div class="sec-box">
                            <h4 class="fs-4 fw-bold">{{$stat['contest_name']}}</h4>

                                <div class="row mt-3 mb-2">
                                    @foreach($stat['participants'] as $participant)
                                    <div class="col-md-4">
                                        <a href="{{route('profile', [$participant['username']])}}">
                                            <img src="{{asset('storage/image/' . $participant['user_image']['image_path'])}}" class="img-fluid img-thumbnail profile-photo" alt="">
                                        </a>
                                        <h4 class="fs-5 fw-bold mt-2 text-center">{{$participant['user_name']}}</h4>
                                    </div>
                                    @endforeach
                                </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
