@extends('header')
@section('content')

    <div class="row">
        @foreach($final_results[0]['participants'] as $result)
        <div class="col-md-3 text-center mb-2">
            <img src="{{asset('storage/image/' . $result['user_image'])}}" class="img-fluid img-thumbnail profile-photo" alt="">
            <div class="text-center">
                <h4 class="fs-4 fw-bold mt-3 mb-1">{{$result['user_name']}}</h4>
                <h5 class="fs-6 text-black-50">Total Votes: <span class="fw-bold">{{$result['total_votes']}}</span></h5>
            </div>
        </div>
        @endforeach
    </div>

@endsection
