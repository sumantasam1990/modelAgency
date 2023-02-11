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

    <div class="row">
        <div class="col-md-8">
            <table class="table table-bordered table-striped">
                <thead>
                <tr class="fs-5">
                    <th>Category</th>
                    <th>Prize First (AVG)</th>
                    <th>Prize Second (AVG)</th>
                    <th>Prize Third (AVG)</th>
                    <th>Participants</th>
                </tr>
                </thead>
                <tbody>
                @foreach($totalParticipantsByCategory as $category)
                    <tr class="table-row">
                        <td class="fw-bold">
                            <a class="text-dark" href="{{route('admin.category.contests', [$category['category_id']])}}">{{$category['category_title']}}</a>
                        </td>
                        <td>${{$category['average_prize_first']}}</td>
                        <td>${{$category['average_prize_second']}}</td>
                        <td>${{$category['average_prize_third']}}</td>
                        <td class="fw-bold">{{$category['total_participants']}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
