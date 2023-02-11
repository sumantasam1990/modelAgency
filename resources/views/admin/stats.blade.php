@extends('admin.header')
@section('content')

    <div class="row">
        <h4 class="fs-4 fw-bold mb-3">Stats</h4>
        <div class="col-md-3 mb-2">
            <div class="card text-bg-dark mb-3">
                <div class="card-header">Total Users</div>
                <div class="card-body">
                    <h5 class="card-title fs-1">{{$data['users']}}</h5>
                    <p class="card-text">Registered users.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card text-bg-secondary mb-3">
                <div class="card-header">Total Categories</div>
                <div class="card-body">
                    <h5 class="card-title fs-1">{{$data['categories']}}</h5>
                    <p class="card-text">All categories.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card text-bg-success mb-3">
                <div class="card-header">Active Contests</div>
                <div class="card-body">
                    <h5 class="card-title fs-1">{{$data['active_contests']}}</h5>
                    <p class="card-text">Contests that are active now.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card text-bg-danger mb-3">
                <div class="card-header">Total Expired Contests</div>
                <div class="card-body">
                    <h5 class="card-title fs-1">{{$data['inactive_contests']}}</h5>
                    <p class="card-text">Contests that are expired.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card text-bg-light mb-3">
                <div class="card-header">Total Participants</div>
                <div class="card-body">
                    <h5 class="card-title fs-1">{{$data['participants']}}</h5>
                    <p class="card-text">All unique participants for all contest.</p>
                </div>
            </div>
        </div>
    </div>

@endsection
