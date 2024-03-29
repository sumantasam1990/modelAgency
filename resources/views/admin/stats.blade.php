@extends('admin.header')
@section('content')

    <div class="row">
        <h4 class="fs-4 fw-bold mb-3">Stats</h4>

        <div class="col-md-3 border sec-box">
            <form action="{{route('admin.stats.search')}}" method="post">
                @csrf
                <div class="bg-light p-2 mb-2" style="border-radius: 10px;">
                    <div class="mb-2">
                        <select class="form-control" name="time">
                            <option value="1x" {{request('time') == '1x' ? 'selected' : ''}}>Today</option>
                            <option value="2x" {{request('time') == '2x' ? 'selected' : ''}}>This month</option>
                            <option value="3x" {{request('time') == '3x' ? 'selected' : ''}}>This week</option>
                        </select>
                    </div>
                </div>

                <div class="bg-light p-2 mb-2" style="border-radius: 10px;">
                    <h5 class="fs-6 fw-bold text-black-50 mt-3">Gender</h5>
                    <div class="mb-2 form-check">
                        <input type="checkbox" class="form-check-input" name="gender[]"
                               value="male" {{isset(request('gender')[0]) && in_array('male', request('gender')) ? 'checked' : ''}}>
                        <label class="form-check-label" for="flexCheckDefault">
                            Male
                        </label>
                    </div>
                    <div class="mb-2 form-check">
                        <input type="checkbox" class="form-check-input" name="gender[]"
                               value="female" {{isset(request('gender')[0]) && in_array('female', request('gender')) ? 'checked' : ''}}>
                        <label class="form-check-label" for="flexCheckDefault">
                            Female
                        </label>
                    </div>
{{--                    <div class="mb-2 form-check">--}}
{{--                        <input type="checkbox" class="form-check-input" name="gender[]"--}}
{{--                               value="male_trans" {{isset(request('gender')[0]) && in_array('male_trans', request('gender')) ? 'checked' : ''}}>--}}
{{--                        <label class="form-check-label" for="flexCheckDefault">--}}
{{--                            Male trans--}}
{{--                        </label>--}}
{{--                    </div>--}}
{{--                    <div class="mb-2 form-check">--}}
{{--                        <input type="checkbox" class="form-check-input" name="gender[]"--}}
{{--                               value="female_trans" {{isset(request('gender')[0]) && in_array('female_trans', request('gender')) ? 'checked' : ''}}>--}}
{{--                        <label class="form-check-label" for="flexCheckDefault">--}}
{{--                            Female trans--}}
{{--                        </label>--}}
{{--                    </div>--}}
                </div>

                <div class="bg-light p-2 mb-2" style="border-radius: 10px;">
                    <livewire:state-city-select-box :selectedState="request('state')" :selectedCity="request('city')" />
                </div>

{{--                <h5 class="fs-6 fw-bold text-black-50 mt-3">Age(in months)</h5>--}}
{{--                <div class="row">--}}
{{--                    <div class="col-md-6">--}}
{{--                        <input type="number" class="form-control" name="age_from" placeholder="" value="{{request('age_from') ?? ''}}">--}}
{{--                    </div>--}}
{{--                    <div class="col-md-6">--}}
{{--                        <input type="number" class="form-control" name="age_to" placeholder="" value="{{request('age_to') ?? ''}}">--}}
{{--                    </div>--}}
{{--                </div>--}}

                <h5 class="fs-6 fw-bold text-black-50 mt-3">Height(m)</h5>
                <div class="row">
                    <div class="col-md-6">
                        <select class="form-control" name="h_from">
                            <option value="">Choose</option>
                            @foreach(range(20, 220) as $number)
                                <option>{{number_format($number / 100, 2)}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <select class="form-control" name="h_to">
                            <option value="">Choose</option>
                            @foreach(range(20, 220) as $number)
                                <option>{{number_format($number / 100, 2)}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <h5 class="fs-6 fw-bold text-black-50 mt-3">Skin color</h5>
                <div class="mb-2">
                    <select class="form-control" name="_skin">
                        <option value="">Choose</option>
                        <option {{request('_skin') == "White" ? 'selected' : ''}}>White</option>
                        <option {{request('_skin') == "Brown" ? 'selected' : ''}}>Brown</option>
                        <option {{request('_skin') == "Black" ? 'selected' : ''}}>Black</option>
                    </select>
                </div>

                <h5 class="fs-6 fw-bold text-black-50 mt-3">Dress size</h5>
                <div class="mb-2">
                    <select class="form-control" name="dress">
                        <option value="">Choose</option>
                        @foreach($arr as $a)
                            <option value="{{$a}}">{{$a}}</option>
                        @endforeach
                    </select>
                </div>

                <h5 class="fs-6 fw-bold text-black-50 mt-3">Hair color</h5>
                <div class="mb-2">
                    <select class="form-control" name="hair">
                        <option value="">Choose</option>
                        <option {{request('hair') == 'Bald' ? 'selected' : ''}}>Bald</option>
                        <option {{request('hair') == 'Black' ? 'selected' : ''}}>Black</option>
                        <option {{request('hair') == 'Blonde' ? 'selected' : ''}}>Blonde</option>
                        <option {{request('hair') == 'Brown' ? 'selected' : ''}}>Brown</option>
                        <option {{request('hair') == 'Gray' ? 'selected' : ''}}>Gray</option>
                        <option {{request('hair') == 'White' ? 'selected' : ''}}>White</option>
                        <option {{request('hair') == 'Red' ? 'selected' : ''}}>Red</option>
                        <option {{request('hair') == 'Colored' ? 'selected' : ''}}>Colored</option>
                    </select>
                </div>

                <h5 class="fs-6 fw-bold text-black-50 mt-3">Eyes color</h5>
                <div class="mb-2">
                    <select class="form-control" name="eyes">
                        <option value="">Choose</option>
                        <option {{request('eyes') == 'Brown' ? 'selected' : ''}}>Brown</option>
                        <option {{request('eyes') == 'Black' ? 'selected' : ''}}>Black</option>
                        <option {{request('eyes') == 'Green' ? 'selected' : ''}}>Green</option>
                        <option {{request('eyes') == 'Blue' ? 'selected' : ''}}>Blue</option>
                        <option {{request('eyes') == 'Honey' ? 'selected' : ''}}>Honey</option>
                    </select>
                </div>


                <div class="d-grid gap-2 mx-auto col-12 mt-3">
                    <button type="submit" class="btn btn-dark">Submit</button>
                </div>

            </form>
        </div>

        <div class="col-md-8">
            <div class="row">
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
                <div class="col-md-4 mb-2">
                    <div class="card text-bg-danger mb-3">
                        <div class="card-header">Total Income (USD)</div>
                        <div class="card-body">
                            <h5 class="card-title fs-1">${{$data['total_income']}}</h5>
                            <p class="card-text">Total income generated.</p>
                        </div>
                    </div>
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
