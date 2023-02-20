@extends('admin.header')
@section('content')

    <div class="row">
        <h4 class="fs-4 fw-bold mb-3">Stats</h4>

        <form action="{{route('admin.stats.search')}}" method="post">
            <div class="row mb-3">
                    @csrf
                    <div class="col-md-2">
                        <select class="form-control" name="time">
                            <option value="1x" {{request('time') == '1x' ? 'selected' : ''}}>Today</option>
                            <option value="2x" {{request('time') == '2x' ? 'selected' : ''}}>This month</option>
                            <option value="3x" {{request('time') == '3x' ? 'selected' : ''}}>This week</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <div class="d-grid gap-2 mx-auto col-5">
                            <button type="submit" class="btn btn-secondary">Submit</button>
                        </div>
                    </div>
            </div>
        </form>


        <div class="col-md-4 mb-2">
            <div class="card text-bg-dark mb-3">
                <div class="card-header">Total Registrations</div>
                <div class="card-body">
                    <h5 class="card-title fs-1">{{$data['users']}}</h5>
                    <p class="card-text">Registered users (not subscribed).</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-2">
            <div class="card text-bg-success mb-3">
                <div class="card-header">Total Subscribers</div>
                <div class="card-body">
                    <h5 class="card-title fs-1">{{$data['total_subscribers']}}</h5>
                    <p class="card-text">Subscribed users.</p>
                </div>
            </div>
        </div>


{{--        <div class="col-md-3 mb-2">--}}
{{--            <div class="card text-bg-secondary mb-3">--}}
{{--                <div class="card-header">Total Categories</div>--}}
{{--                <div class="card-body">--}}
{{--                    <h5 class="card-title fs-1">{{$data['categories']}}</h5>--}}
{{--                    <p class="card-text">All categories.</p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-md-3 mb-2">--}}
{{--            <div class="card text-bg-success mb-3">--}}
{{--                <div class="card-header">Active Contests</div>--}}
{{--                <div class="card-body">--}}
{{--                    <h5 class="card-title fs-1">{{$data['active_contests']}}</h5>--}}
{{--                    <p class="card-text">Contests that are active now.</p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-md-3 mb-2">--}}
{{--            <div class="card text-bg-danger mb-3">--}}
{{--                <div class="card-header">Total Expired Contests</div>--}}
{{--                <div class="card-body">--}}
{{--                    <h5 class="card-title fs-1">{{$data['inactive_contests']}}</h5>--}}
{{--                    <p class="card-text">Contests that are expired.</p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-md-3 mb-2">--}}
{{--            <div class="card text-bg-light mb-3">--}}
{{--                <div class="card-header">Total Participants</div>--}}
{{--                <div class="card-body">--}}
{{--                    <h5 class="card-title fs-1">{{$data['participants']}}</h5>--}}
{{--                    <p class="card-text">All unique participants for all contest.</p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>

@endsection
