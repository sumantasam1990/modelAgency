@include('header')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <div class="left-sidebar">
                <h2 class="text-capitalize fs-4 fw-bold">Model name</h2>
                <p style="margin-top: -5px;">
                    <a class="btn btn-link text-success fs-6 fw-bold text-decoration-none text-capitalize" href="">My profile</a>
                </p>

                <hr>

                <ul>
                    <li><a href="">Contest</a> </li>
                    <li><a href="">Portfolio</a> </li>
                    <li><a href="">Help</a> </li>
                    <li><a href="">Subscription</a> </li>
                    <hr>
                    <li class="active"><a href="{{route('register')}}">Register</a> </li>
                    <li class="active"><a href="{{route('login')}}">Sign In</a> </li>
                </ul>
            </div>
        </div>

        <div class="col-md-10">
            <div class="right-sidebar">

                <div class="row">
                    <div class="col-md-6">
                        <div class="sec-box">
                            <h4 class="fw-bold fs-4">Register</h4>
                            <div class="form-group mb-2">
                                <label>Name*</label>
                                <input type="text" name="_name" placeholder="eg. John doe" class="form-control">
                            </div>
                            <div class="form-group mb-2">
                                <label>Email*</label>
                                <input type="email" name="_email" placeholder="eg. John@example.com" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group mb-2">
                                        <label>Password*</label>
                                        <input type="password" name="_password" placeholder="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mb-2">
                                        <label>Confirm Password*</label>
                                        <input type="password" name="_conf" placeholder="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mb-2">
                                        <label>State*</label>
                                        <input type="text" name="_state" placeholder="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mb-2">
                                        <label>City*</label>
                                        <input type="text" name="_city" placeholder="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mb-2">
                                        <label>District*</label>
                                        <input type="text" name="_district" placeholder="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mb-2">
                                        <label>WhatsApp*</label>
                                        <input type="text" name="_wp" placeholder="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mb-2">
                                        <label>Gender*</label>
                                        <select class="form-control" name="gender">
                                            <option>Female</option>
                                            <option>Male</option>
                                            <option>Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mb-2">
                                        <label>Civil Status*</label>
                                        <input type="text" name="_civil_status" placeholder="" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
@include('footer')
