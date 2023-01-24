@include('header')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" style="margin: 0; padding: 0;">
            <div class="left-sidebar">
                <h2 class="text-capitalize fs-5 fw-bold text-light" style="margin-left: 20px;">Maria Doe</h2>
                <p style="margin-top: -5px;">
                    <a class=" fs-6 fw-bold text-decoration-none text-capitalize" href="" style="color: #d2d2d2; margin-left: 20px;">My profile &nbsp; <i class="fa-solid fa-arrow-right"></i></a>
                </p>

                <ul class="mt-5">
                    <li><a href=""><i class="fa-solid fa-heart"></i> &nbsp; Contest</a> </li>
                    <li><a href=""><i class="fa-solid fa-camera-retro"></i> &nbsp; Portfolio</a> </li>
                    <li><a href=""><i class="fa-solid fa-person-circle-question"></i> &nbsp; Help</a> </li>
                    <li><a href=""><i class="fa-solid fa-credit-card"></i> &nbsp; Subscription</a> </li>
                    <li class="active"><a href="{{route('register')}}"><i class="fa-solid fa-user-plus"></i> &nbsp; Register</a> </li>
                    <li><a href="{{route('login')}}"><i class="fa-solid fa-right-to-bracket"></i> &nbsp; Sign In</a> </li>
                </ul>
            </div>
        </div>

        <div class="col-md-10">
            <div class="right-sidebar mt-5">

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

            </div>

        </div>
    </div>
</div>
@include('footer')
