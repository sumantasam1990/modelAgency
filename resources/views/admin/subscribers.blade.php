@extends('admin.header')
@section('content')

    <div class="row">

        <div class="col-md-3 border sec-box">
            <h4 class="fs-5 text-black-50 fw-bold mb-3">Filter</h4>
            <form action="{{route('admin.subscribers.search')}}" method="get">
                @csrf

                <div class="bg-light p-2 mb-2" style="border-radius: 10px;">
                    <div class="mb-2 form-check form-check-inline">
                        <input type="radio" class="form-check-input" name="status"
                               value="1" {{request('status') == '1' || request('status') != '0' ? 'checked' : ''}}>
                        <label class="form-check-label" for="flexCheckDefault">
                            Active
                        </label>
                    </div>
                    <div class="mb-2 form-check form-check-inline">
                        <input type="radio" class="form-check-input" name="status"
                               value="0" {{request('status') == '0' ? 'checked' : ''}}>
                        <label class="form-check-label" for="flexCheckDefault">
                            Inactive
                        </label>
                    </div>
                </div>

                <div class="bg-light p-2 mb-2" style="border-radius: 10px;">
                    <livewire:state-city-select-box :selectedState="request('state')" :selectedCity="request('city')" />
                </div>

                <div class="bg-light p-2 mb-2" style="border-radius: 10px;">
                    <h5 class="fs-6 fw-bold text-black-50">Gender</h5>
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
                    <div class="mb-2 form-check">
                        <input type="checkbox" class="form-check-input" name="gender[]"
                               value="male_trans" {{isset(request('gender')[0]) && in_array('male_trans', request('gender')) ? 'checked' : ''}}>
                        <label class="form-check-label" for="flexCheckDefault">
                            Male trans
                        </label>
                    </div>
                    <div class="mb-2 form-check">
                        <input type="checkbox" class="form-check-input" name="gender[]"
                               value="female_trans" {{isset(request('gender')[0]) && in_array('female_trans', request('gender')) ? 'checked' : ''}}>
                        <label class="form-check-label" for="flexCheckDefault">
                            Female trans
                        </label>
                    </div>
                </div>

                <div class="d-grid gap-2 mx-auto col-12 mt-3">
                    <button type="submit" class="btn btn-dark">Search</button>
                </div>

            </form>
        </div>

        <div class="col-md-9">
            <h4 class="fs-4 fw-bold mb-3">Subscribers</h4>
            @if(count($payments) > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped caption-top">
                        <caption>List of subscribers</caption>
                        <thead>
                        <tr class="table-dark">
                            <th>User name</th>
                            <th>User email</th>
                            <th>Gender</th>
                            <th>Start date</th>
                            <th>Renewal date</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($payments as $d)
                            <tr>
                                <td class="fw-bold">{{$d->name}}</td>
                                <td class="fw-bold">{{$d->email}}</td>
                                <td class="fw-bold">{{$d->gender}}</td>
                                <td class="fw-bold">{{\Carbon\Carbon::parse($d->payment->start_date)->format('jS F Y')}}</td>
                                <td class="fw-bold">{{\Carbon\Carbon::parse($d->payment->end_date)->format('jS F Y')}}</td>
                                <td class="fw-bold text-danger">{{number_format($d->payment->amount, 2)}}</td>
                                <td>
                                    @if($d->payment->end_date > \Illuminate\Support\Carbon::today()->format('Y-m-d'))
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Expired/Canceled</span>
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="5" class="text-end"><strong>Total:</strong></td>
                            <td class="fw-bold text-danger">
                                {{number_format($totalAmount, 2)}}
                            </td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    {{$payments->links()}}
                </div>
            @else
                <p class="fw-bold">No subscribers found.</p>
            @endif


        </div>
    </div>

@endsection
