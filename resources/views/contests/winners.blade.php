@extends('header')
@section('content')

    <div class="row mb-4">
        <div class="col-md-8">
            <h4 class="fw-bold fs-4 mb-1">Winners</h4>
            <p class="text-black-50 mb-3 fs-6">List of winners from current month.</p>

            <div class="row">
                <div class="col-md-8">
                    <form action="{{route('winner.search')}}" method="get">
                        @csrf
                        <div class="row">
                            <div class="col-4">
                                <select name="year" class="form-control">
                                    <option value="">Choose Year</option>
                                    @foreach(range(date('Y')-5, date('Y')) as $y)
                                        <option {{$y == $request->year ? 'selected' : ''}}>{{$y}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-4">
                                <select name="month" class="form-control">
                                    <option value="">Choose Month</option>
                                    @foreach(range(1, 12) as $m)
                                        <option {{$m == $request->month ? 'selected' : ''}}>{{$m}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-4">
                                <div class="d-grid gap-2 col-12">
                                    <button type="submit" class="btn btn-dark"><i class="fas fa-search"></i> Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-10">
                    @foreach($data as $contest)
                        <div class="sec-box mb-3">
                            <div class="d-flex text-center">
                                <div class="flex-grow-1 ms-3">
                                    <h4 class="fw-bold fs-4 text-black">{{$contest['contest_name']}} - <span class="text-black-50">{{$contest['start']}}</span></h4>

                                    <hr />

                                    <div class="row mt-4">
                                        @foreach($contest['winners'] as $winner)
                                            <div class="col-md-4">
                                                <a href="{{route('profile', [$winner['username']])}}">
                                                <img src="{{asset('storage/image/' . $winner['user_image']['image_path'])}}" class="img-fluid img-thumbnail profile-photo" alt="">
                                                </a>
                                                <p class="mt-3">
                                                    <span class="fw-bold">{{$winner['user_name']}}</span>  <br> Total votes: <span class="fw-bold">{{$winner['total_votes']}}</span>
                                                </p>
                                                <p>
                                                    <span class="badge bg-warning fw-bold fs-6">
                                                        <i class="fa-solid fa-trophy"></i>
                                                        Winner
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
