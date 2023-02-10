@extends('header')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <h4 class="fs-4 fw-bold mb-3">{{$contests[0]->category->title}} - Contests</h4>
            <div class="row">
                @foreach($contests as $contest)
                    <div class="col-md-6 mb-3">
                        <div class="sec-box">
                            <h5 class="fs-5 text-black-50">
                                Start at <span>{{$contest->start}}</span>
                            </h5>
                            <h5 class="fs-5 text-black-50">
                                End at <span>{{$contest->end}}</span>
                            </h5>
                            <h4 class="fs-4 fw-bold">{{$contest->title}}</h4>
                            <p class="mb-1">First Prize: <span class="fw-bold">${{$contest->prize_first}}</span></p>
                            <p class="mb-1">Second Prize: <span class="fw-bold">${{$contest->prize_second}}</span></p>
                            <p class="mb-1">Third Prize: <span class="fw-bold">${{$contest->prize_third}}</span></p>
                            <div class="d-grid gap-2 col-3 mt-3">
                                <a href="{{route('admin.contest.stats', [$contest->id])}}" class="btn btn-dark">Stats</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
