@extends('admin.header')
@section('content')
    <div class="row admin-secondary-nav">
        <div class="col-12">
            <nav style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item {{ (request()->is('admin/contest/dashboard')) ? 'active-admin' : '' }}" aria-current="page"><a class="text-decoration text-black" href="{{route('admin.contest.dashboard')}}">Dashboard</a></li>
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

    <div class="row">
        <div class="col-md-6">
            @foreach($data as $d)
                <div class="contest mb-3 sec-box">
                    <h4 class="fs-4 fw-bold mb-3">{{$d['contest_name']}}</h4>
                    <header class="d-flex flex-row justify-content-between align-items-center mb-3 fw-bold">
                        <div>Name of model</div>
                        <div>Bank Account No</div>
                        <div>Prize</div>
                        <div>Status</div>
                    </header>
                    @php
                    $i = 1;
                    @endphp
                    @foreach($d['winners'] as $winner)
                        <div class="d-flex flex-row justify-content-between align-items-center mb-2">
                            <div style="width: 100px;">{{$winner['user_name']}}</div>
                            <div>{{$winner['user_bank']}}</div>
                            <div>
                                <span class="badge bg-success fs-6">
                                    @if($i === 1)
                                        ${{$d['first_prize']}}
                                    @elseif($i === 2)
                                        ${{$d['second_prize']}}
                                    @else
                                        ${{$d['third_prize']}}
                                    @endif
                                </span>
                            </div>
                            <div>
                                <a class="btn btn-outline-dark btn-sm" href=""><i class="fa-solid fa-hourglass-start"></i></a>
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
