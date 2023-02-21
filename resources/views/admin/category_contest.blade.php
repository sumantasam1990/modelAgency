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

    <div class="row mt-2">
        <div class="col-md-12">
            <h4 class="fs-4 fw-bold mb-3">Contests</h4>
            <div class="row">
                <div class="col-md-10">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped caption-top">
                            <caption>List of contests</caption>
                            <thead>
                            <tr class="table-dark">
                                <th>Title</th>
                                <th>Start</th>
                                <th>End</th>
                                <th>First Prize</th>
                                <th>Second Prize</th>
                                <th>Third Prize</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($contests as $contest)
                                <tr>
                                    <td class="fw-bold">{{$contest->title}}</td>
                                    <td class="text-black-50 fw-bold">{{$contest->start}}</td>
                                    <td class="text-black-50 fw-bold">{{$contest->end}}</td>
                                    <td class="text-success fw-bold">${{$contest->prize_first}}</td>
                                    <td class="text-info fw-bold">${{$contest->prize_second}}</td>
                                    <td class="text-danger fw-bold">${{$contest->prize_third}}</td>
                                    <td>
                                        <div class="d-grid gap-2 col-3 mt-3">
                                            <a href="{{route('admin.contest.stats', [$contest->id])}}" class="btn btn-dark btn-sm">Stats</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div>
                        {{$contests->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
