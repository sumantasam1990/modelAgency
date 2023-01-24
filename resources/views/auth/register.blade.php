@extends('header')
@section('content')
    <div class="row">
        <div class="col-md-5">
            <div class="sec-box">
                <h4 class="fw-bold fs-4">Register</h4>
                <form action="{{route('register.post')}}" method="post">
                    @csrf
                    <div class="form-group mb-2">
                        <label>Name*</label>
                        <input type="text" name="_name" placeholder="eg. John doe" class="form-control @error('_name') is-invalid @enderror">
                        @if ($errors->has('_name'))
                            <span class="text-danger">{{ $errors->first('_name') }}</span>
                        @endif
                    </div>
                    <div class="form-group mb-2">
                        <label>Email*</label>
                        <input type="email" name="email" placeholder="eg. John@example.com" class="form-control @error('email') is-invalid @enderror">
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-2">
                                <label>Password*</label>
                                <input type="password" name="password" placeholder="" class="form-control @error('password') is-invalid @enderror">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-2">
                                <label>Confirm Password*</label>
                                <input type="password" name="password_confirmation" placeholder="" class="form-control @error('password_confirmation') is-invalid @enderror">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-2">
                                <label>State*</label>
                                <input type="text" name="_state" placeholder="" class="form-control @error('_state') is-invalid @enderror">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-2">
                                <label>City*</label>
                                <input type="text" name="_city" placeholder="" class="form-control @error('_city') is-invalid @enderror">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-2">
                                <label>District*</label>
                                <input type="text" name="_district" placeholder="" class="form-control @error('_district') is-invalid @enderror">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-2">
                                <label>WhatsApp*</label>
                                <input type="text" name="_wp" placeholder="" class="form-control @error('_wp') is-invalid @enderror">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-2">
                                <label>Gender*</label>
                                <select class="form-control @error('_gender') is-invalid @enderror" name="_gender">
                                    <option value="" selected>Select</option>
                                    <option>Female</option>
                                    <option>Male</option>
                                    <option>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-2">
                                <label>Civil Status*</label>
                                <input type="text" name="_civil_status" placeholder="" class="form-control @error('_civil_status') is-invalid @enderror">
                            </div>
                        </div>
                    </div>
                    <div class="d-grid gap-2 mx-auto col-4 mt-4">
                        <button type="submit" class="btn btn-dark">Sign Up</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
