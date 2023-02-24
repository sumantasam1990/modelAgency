@include('header')
<div class="container-fluid h-100">
    <div class="row h-100">
        <div class="col-md-8 hero">

        </div>
        <div class="col-md-4 box h-100">
            @include('alert')
            <h1 class="fs-2 fw-bold text-capitalize">Access your model panel</h1>
            <form action="{{route('login.post')}}" method="post">
                @csrf
                <div class="form-group mb-3">
                    <label>Email*</label>
                    <input type="email" name="email" class="form-control" placeholder="eg. john@example.com">
                </div>
                <div class="form-group">
                    <label>Password*</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="d-grid gap-2 mx-auto col-8 mt-4">
                    <button type="submit" class="btn btn-dark">Sign In</button>
                    <a class="btn btn-light text-capitalize mt-4" data-bs-toggle="modal" data-bs-target="#signup" href="#">Create your account</a>
                </div>

            </form>
        </div>
    </div>
</div>



<!-- Register Modal -->
<div class="modal fade" id="signup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold" id="exampleModalLabel">Create Your Account</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="sec-box border">
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
                                        <option value="male_trans">Male trans</option>
                                        <option value="female_trans">Female trans</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mb-2">
                                    <label>Civil Status*</label>
                                    <select class="form-control @error('_civil_status') is-invalid @enderror" name="_civil_status">
                                        <option value="">Choose</option>
                                        <option>Single</option>
                                        <option>Married</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <h4 class="fw-bold fs-4 mt-3">Body Characteristics</h4>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-2">
                                    <label>Age*</label>
                                    <input type="date" name="_age" placeholder="d/m/Y" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-2">
                                    <label>Height(m)*</label>
                                    <input type="number" name="_height" placeholder="" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-2">
                                    <label>Skin color*</label>
                                    <select class="form-control" name="_skin">
                                        <option value="">Choose</option>
                                        <option>White</option>
                                        <option>Brown</option>
                                        <option>Black</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-2">
                                    <label>Bust(cm)*</label>
                                    <input type="number" name="bust" placeholder="" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-2">
                                    <label>Waist(cm)*</label>
                                    <input type="number" name="waist" placeholder="" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-2">
                                    <label>Hips(cm)*</label>
                                    <input type="number" name="hips" placeholder="" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-2">
                                    <label>Dress Size*</label>
                                    <select class="form-control" name="dress">
                                        <option value="">Choose</option>
                                        <option>Small</option>
                                        <option>Medium</option>
                                        <option>Large</option>
                                        <option>XL</option>
                                        <option>XXL</option>
                                        <option>XXXL</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-2">
                                    <label>Hair Color(m)*</label>
                                    <select class="form-control" name="hair">
                                        <option value="">Choose</option>
                                        <option>White</option>
                                        <option>Black</option>
                                        <option>Blond</option>
                                        <option>Color</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-2">
                                    <label>Eyes color*</label>
                                    <select class="form-control" name="eyes">
                                        <option value="">Choose</option>
                                        <option>Blue</option>
                                        <option>Brown</option>
                                        <option>Green</option>
                                        <option>Hazel</option>
                                        <option>Black</option>
                                        <option>Purple</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-3">
                                <div class="mb-2 form-check">
                                    <input type="checkbox" class="form-check-input" name="other[]"
                                           value="fitness">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Fitness
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-2 form-check">
                                    <input type="checkbox" class="form-check-input" name="other[]"
                                           value="tatoo">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Tatoo
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-2 form-check">
                                    <input type="checkbox" class="form-check-input" name="other[]"
                                           value="piercing">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Piercing
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-2 form-check">
                                    <input type="checkbox" class="form-check-input" name="other[]"
                                           value="silicone">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Silicone
                                    </label>
                                </div>
                            </div>
                        </div>

                        <h4 class="fw-bold fs-4 mt-3">Main Social Networks</h4>

                        <div class="row mt-2">
                            <div class="col-md-4">
                                <label>Instagram</label>
                            </div>
                            <div class="col-md-4">
                                <input type="url" name="url" placeholder="URL" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <select class="form-control" name="followers">
                                    <option>5k - 10k</option>
                                    <option>11k - 50k</option>
                                    <option>51k - 100k</option>
                                    <option>101k - 1M</option>
                                    <option>1M+</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-4">
                                <label>Tiktok</label>
                            </div>
                            <div class="col-md-4">
                                <input type="url" name="" placeholder="URL" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <select class="form-control" name="">
                                    <option>5k - 10k</option>
                                    <option>11k - 50k</option>
                                    <option>51k - 100k</option>
                                    <option>101k - 1M</option>
                                    <option>1M+</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-4">
                                <input type="text" name="" placeholder="Name of social media" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <input type="url" name="" placeholder="URL" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <select class="form-control" name="">
                                    <option>5k - 10k</option>
                                    <option>11k - 50k</option>
                                    <option>51k - 100k</option>
                                    <option>101k - 1M</option>
                                    <option>1M+</option>
                                </select>
                            </div>
                        </div>


                        <div class="d-grid gap-2 mx-auto col-4 mt-4">
                            <button type="submit" class="btn btn-dark">Sign Up</button>
                        </div>

                    </form>
                </div>
            </div>
{{--            <div class="modal-footer">--}}
{{--                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>--}}
{{--                <button type="button" class="btn btn-primary">Save changes</button>--}}
{{--            </div>--}}
        </div>
    </div>
</div>
@include('footer')
