@extends('header')
@section('content')
    <div class="row">
        <div class="col-md-6">
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

                    <h4 class="fw-bold fs-4 mt-3">Body Characteristics</h4>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-2">
                                <label>Age*</label>
                                <input type="number" name="_age" placeholder="d/m/Y" class="form-control">
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
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-2">
                                <label>Bust(cm)*</label>
                                <input type="number" name="_age" placeholder="d/m/Y" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-2">
                                <label>Waist(cm)*</label>
                                <input type="number" name="_height" placeholder="" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-2">
                                <label>Hips(cm)*</label>
                                <input type="number" name="_height" placeholder="" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-2">
                                <label>Dress Size*</label>
                                <select class="form-control" name="_skin">
                                    <option value="">Choose</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-2">
                                <label>Hair Color(m)*</label>
                                <select class="form-control" name="_skin">
                                    <option value="">Choose</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-2">
                                <label>Eyes color*</label>
                                <select class="form-control" name="_skin">
                                    <option value="">Choose</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-3">
                            <div class="mb-2 form-check">
                                <input type="checkbox" class="form-check-input" name="gender[]"
                                       value="fitness">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Fitness
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-2 form-check">
                                <input type="checkbox" class="form-check-input" name="gender[]"
                                       value="tatoo">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Tatoo
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-2 form-check">
                                <input type="checkbox" class="form-check-input" name="gender[]"
                                       value="piercing">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Piercing
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-2 form-check">
                                <input type="checkbox" class="form-check-input" name="gender[]"
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
                            <input type="url" required name="" placeholder="URL" class="form-control">
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
                            <label>Tiktok</label>
                        </div>
                        <div class="col-md-4">
                            <input type="url" required name="" placeholder="URL" class="form-control">
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
                            <input type="text" required name="" placeholder="Name of social media" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <input type="url" required name="" placeholder="URL" class="form-control">
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
    </div>
@endsection
