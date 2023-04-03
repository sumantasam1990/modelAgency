@extends('admin.header')
@section('content')
    <div class="row admin-secondary-nav">
        <div class="col-12">
            <nav style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item {{ (request()->is('admin/category/contests')) ? 'active-admin' : '' }}" aria-current="page"><a class="text-decoration text-black" href="{{route('admin.category.contests')}}">Dashboard</a></li>
                    <li class="breadcrumb-item {{ (request()->is('admin/contest/winners')) ? 'active-admin' : '' }}" aria-current="page"><a class="text-decoration text-black" href="{{route('admin.winners')}}">Winners</a></li>
                    <li class="breadcrumb-item {{ (request()->is('admin/add/contest')) ? 'active-admin' : '' }}" aria-current="page"><a class="text-decoration text-black" href="{{route('add.contest')}}">Creator</a></li>
                    <li class="breadcrumb-item {{ (request()->is('admin/add/category')) ? 'active-admin' : '' }}" aria-current="page"><a class="text-decoration text-black" href="{{route('add.category')}}">Category</a></li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <form action="{{route('winner.search')}}" method="get">
                @csrf
                <div class="row">
                    <div class="col-4">
                        <select name="year" class="form-control">
                            <option value="">Choose Year</option>
                            @foreach(range(date('Y'), date('Y')) as $y)
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

    <div class="row">
        <div class="col-md-8">
            @foreach($data as $d)
                <div class=" mb-3 sec-box">
                    <h4 class="fs-4 fw-bold mb-3">{{$d['contest_name']}} </h4>

                    <header class="d-flex flex-row justify-content-between align-items-baseline mb-3 fw-bold">
                        <div style="width: 100px;">Name of model</div>
                        <div style="width: 100px;">WhatsApp</div>
                        <div style="width: 100px;">Pix</div>
                        <div style="width: 100px;">Prize</div>
                        <div style="width: 100px;">Status</div>
                    </header>
                    @php
                    $i = 1;
                    @endphp

                    @foreach($d['winners'] as $winner)
                        @php
                        if($i === 1) {
                            $prize = $d['first_prize'];
                        } elseif ($i === 2) {
                            $prize = $d['second_prize'];
                        } else {
                            $prize = $d['third_prize'];
                        }
                        @endphp
                        <div class="d-flex flex-row justify-content-between align-items-center mb-2">
                            <div style="width: 100px;">{{$winner['user_name']}}</div>
                            <div style="width: 100px;">

                                <span class="fw-bold">{{$winner['wp']}}</span>
                            </div>
                            <div style="width: 100px;">
                                <span class="fw-bold">{{$winner['user_pix']}}</span>
                            </div>
                            <div style="width: 100px;">
                                @if($winner['accMatch'] === 0)
                                    <span class="badge bg-success fs-6">
                                        @else
                                            <span class="badge bg-warning fs-6">
                                @endif

                                    @if($i === 1)
                                        ${{$d['first_prize']}}
                                    @elseif($i === 2)
                                        ${{$d['second_prize']}}
                                    @else
                                        ${{$d['third_prize']}}
                                    @endif
                                </span>
                                    </span>
                            </div>
                            <div style="width: 100px;">
                                @if($winner['accMatch'] === 0)
                                    <a class="btn btn-success btn-sm" href="#"><i class="fa-solid fa-check"></i></a>
                                @else
{{--                                    <a class="btn btn-outline-dark btn-sm" href="{{route('winner.bank.transfer', [$d['contest_id'], $winner['user_id'], $prize])}}"><i class="fa-solid fa-hourglass-start"></i></a>--}}

                                    @php
                                    if($i === 1) {
                                        $prize_money = $d['first_prize'];
                                    } elseif ($i === 2) {
                                        $prize_money = $d['second_prize'];
                                    } else {
                                        $prize_money = $d['third_prize'];
                                    }
                                    @endphp
                                    <form onsubmit="return confirm('Are you sure?');" action="{{route('bank.transfer.post')}}" method="post">
                                        @csrf

                                        <input type="hidden" name="_user" value="{{$winner['user_id']}}">
                                        <input type="hidden" name="_contest" value="{{$d['contest_id']}}">
                                        <input type="hidden" name="_prize" value="{{$prize_money}}">
                                        <button type="submit" class="btn btn-outline-dark btn-sm"><i class="fa-solid fa-hourglass-start"></i></button>
                                    </form>


                                @endif
                            </div>
                        </div>
                        @php
                        $i++;
                        @endphp
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>

@endsection
