@extends('header')
@section('content')

    <div class="row mb-4">
        <div class="col-md-8">
            <h4 class="fw-bold fs-4 mb-1">{{__('main.winners')}}</h4>
            <p class="text-black-50 mb-3 fs-6">{{__('main.winners_list')}}</p>

            <div class="row">
                <div class="col-md-8">
                    <form action="{{route('winner.search')}}" method="get">
                        @csrf
                        <div class="row">
                            <div class="col-4">
                                <select name="year" class="form-control">
                                    <option value="">{{__('main.winners_choose_year')}}</option>
                                    @foreach(range(date('Y'), date('Y')) as $y)
                                        <option {{$y == $request->year ? 'selected' : ''}}>{{$y}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-4">
                                <select name="month" class="form-control">
                                    <option value="">{{__('main.winners_choose_month')}}</option>
                                    @foreach(range(1, 12) as $m)
                                        <option {{$m == $request->month ? 'selected' : ''}}>{{$m}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-4">
                                <div class="d-grid gap-2 col-12">
                                    <button type="submit" class="btn btn-dark"><i class="fas fa-search"></i> {{__('main.winners_search')}}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-10">
                    @if(count($data) === 0)
{{--                        <p class="fw-semibold">No contest found.</p>--}}
                    @endif

                    @foreach($data as $contest)
                        <div class="sec-box mb-3">
                            <div class="d-flex text-center">
                                <div class="flex-grow-1 ms-3">
                                    <h4 class="fw-bold fs-4 text-black">{{$contest['contest_name']}} - <span class="text-black-50">{{$contest['start']}}</span></h4>

                                    <hr />

                                    <div class="row mt-4">
                                        @foreach($contest['winners'] as $index => $winner)
                                            @php
                                                switch($winner['rank']) {
                                                    case 1:
                                                        $position = 'gold';
                                                        break;
                                                    case 2:
                                                        $position = 'silver';
                                                        break;
                                                    case 3:
                                                        $position = 'bronze';
                                                        break;
                                                    default:
                                                        $position = '';
                                                }
                                            @endphp
                                            <div class="col-md-4">
                                                <a href="{{route('profile', [$winner['username']])}}">
                                                <img src="{{asset('storage/image/' . $winner['user_image']['image_path'])}}" class="img-fluid img-thumbnail profile-photo" alt="">
                                                </a>
                                                <p class="mt-3">
                                                    <span class="fw-bold">{{$winner['user_name']}}</span>  <br> {{__('main.total_vote')}}: <span class="fw-bold">{{$winner['total_votes']}}</span>
                                                </p>
                                                <p>
                                                    <span class="{{ $position }} fw-bold fs-6">
                                                        <i class="fa-solid fa-trophy"></i>
                                                        {{$winner['rank']}}º Lugar
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
