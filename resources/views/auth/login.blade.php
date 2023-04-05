@include('header')
<div class="container-fluid h-100 hero">
    <div class="row h-100">
        <div class="col-md-9">

        </div>
        <div class="col-md-3 box h-100 position-relative pad">
            @include('alert')
            <h1 class="fs-2 fw-bold text-capitalize mb-3 text-center">
                <img src="{{asset('images/logo.png')}}" alt="Eumodelo" class="img-fluid" style="width: 200px;">
            </h1>
            <h5 class="text-black-50 fs-5 text-center">{{__('main.access_model_info')}}</h5>
            <form action="{{route('login.post')}}" method="post">
                @csrf
                <div class="form-group mb-3 mt-4">
                    <label>Email*</label>
                    <input required type="email" name="email" class="form-control" placeholder="eg. john@example.com" style="background: transparent; border: 1px solid #000; color: #000; font-weight: bold;">
                </div>
                <div class="form-group">
                    <label>{{__('main.pass')}}*</label>
                    <input required type="password" name="password" class="form-control" style="background: transparent; border: 1px solid #000; color: #000; font-weight: bold;">
                </div>

                <div class="d-grid gap-2 mx-auto col-7 mt-4">
                    <button type="submit" class="btn btn-dark">{{__('main.signin')}}</button>
                    <a class="btn btn-outline-dark text-capitalize mt-4 fw-bold" data-bs-toggle="modal" data-bs-target="#signup" href="#">{{__('main.create_account')}}</a>
                </div>

            </form>

            <div class="mt-3 text-black-50 position-absolute bot">
                <div style="margin-left: 25px;">
                    <a class="text-dark" href="https://www.facebook.com/agenciaeumodelo"><i class="fa-brands fa-facebook fs-4 mr-3"></i></a>
                    <a class="text-dark" target="_blank" href="https://www.instagram.com/eumodelo"><i class="fa-brands fa-instagram fs-4 mr-3"></i></a>
                    <a class="text-dark" target="_blank" href="https://www.tiktok.com/@eumodelo"><i class="fa-brands fa-tiktok fs-4"></i></a>
                </div>

                <p class="fw-semibold mt-2" style="margin-left: -20px;">
                    CNPJ - 49.582.909/0001-94
                </p>
            </div>




        </div>
    </div>
</div>



<!-- Register Modal -->
<div class="modal fade" id="signup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold" id="exampleModalLabel">{{__('main.create_account')}}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="sec-box border">
                    <form action="{{route('register.post')}}" method="post">
                        @csrf
                        <div class="form-group mb-2">
                            <label>{{__('main.edit_profile_name')}}*</label>
                            <input required type="text" name="_name" placeholder="" class="form-control @error('_name') is-invalid @enderror">
                            @if ($errors->has('_name'))
                                <span class="text-danger">{{ $errors->first('_name') }}</span>
                            @endif
                        </div>
                        <div class="form-group mb-2">
                            <label>Email*</label>
                            <input required type="email" name="email" placeholder="" class="form-control @error('email') is-invalid @enderror">
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group mb-2">
                                    <label>{{__('main.pass')}}*</label>
                                    <input required type="password" name="password" placeholder="" class="form-control @error('password') is-invalid @enderror">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mb-2">
                                    <label>{{__('main.conf_pass')}}*</label>
                                    <input required type="password" name="password_confirmation" placeholder="" class="form-control @error('password_confirmation') is-invalid @enderror">
                                </div>
                            </div>

                        </div>

{{--                            <livewire:state-city-select-box :selectedState="request('state')" :selectedCity="request('city')" />--}}

{{--                            <div class="col-6">--}}
{{--                                <div class="form-group mb-2">--}}
{{--                                    <label>State*</label>--}}
{{--                                    <input type="text" name="_state" placeholder="" class="form-control @error('_state') is-invalid @enderror">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-6">--}}
{{--                                <div class="form-group mb-2">--}}
{{--                                    <label>City*</label>--}}
{{--                                    <input type="text" name="_city" placeholder="" class="form-control @error('_city') is-invalid @enderror">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-6">--}}
{{--                                <div class="form-group mb-2">--}}
{{--                                    <label>District*</label>--}}
{{--                                    <input type="text" name="_district" placeholder="" class="form-control @error('_district') is-invalid @enderror">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-6">--}}
{{--                                <div class="form-group mb-2">--}}
{{--                                    <label>WhatsApp*</label>--}}
{{--                                    <input type="text" name="_wp" placeholder="" class="form-control @error('_wp') is-invalid @enderror">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-6">--}}
{{--                                <div class="form-group mb-2">--}}
{{--                                    <label>Gender*</label>--}}
{{--                                    <select class="form-control @error('_gender') is-invalid @enderror" name="_gender">--}}
{{--                                        <option value="" selected>Select</option>--}}
{{--                                        <option>Female</option>--}}
{{--                                        <option>Male</option>--}}
{{--                                        <option value="male_trans">Male trans</option>--}}
{{--                                        <option value="female_trans">Female trans</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-6">--}}
{{--                                <div class="form-group mb-2">--}}
{{--                                    <label>Civil Status*</label>--}}
{{--                                    <select class="form-control @error('_civil_status') is-invalid @enderror" name="_civil_status">--}}
{{--                                        <option value="">Choose</option>--}}
{{--                                        <option>Single</option>--}}
{{--                                        <option>Married</option>--}}
{{--                                        <option value="relationship">In a relationship</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <h4 class="fw-bold fs-4 mt-3">Body Characteristics</h4>--}}

{{--                        <div class="row">--}}
{{--                            <div class="col-md-4">--}}
{{--                                <div class="form-group mb-2">--}}
{{--                                    <label>Age*</label>--}}
{{--                                    <input type="date" name="_age" placeholder="d/m/Y" class="form-control">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-4">--}}
{{--                                <div class="form-group mb-2">--}}
{{--                                    <label>Height(m)*</label>--}}
{{--                                    <select class="form-control" name="_height">--}}
{{--                                        <option value="">Choose</option>--}}
{{--                                        @foreach(range(20, 220) as $number)--}}
{{--                                            <option value="{{ number_format($number / 100, 2) }}">{{number_format($number / 100, 2)}} meters</option>--}}
{{--                                        @endforeach--}}
{{--                                        @for ($i = 0.1; $i <= 20; $i++)--}}
{{--                                            @for ($j = 0; $j <= 9; $j++)--}}
{{--                                                @php $value = $i + ($j / 10); @endphp--}}
{{--                                                <option value="{{ $value }}">{{ $value }} meters</option>--}}
{{--                                            @endfor--}}
{{--                                        @endfor--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-4">--}}
{{--                                <div class="form-group mb-2">--}}
{{--                                    <label>Skin color*</label>--}}
{{--                                    <select class="form-control" name="_skin">--}}
{{--                                        <option value="">Choose</option>--}}
{{--                                        <option>White</option>--}}
{{--                                        <option>Brown</option>--}}
{{--                                        <option>Black</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="row">--}}
{{--                            <div class="col-md-4">--}}
{{--                                <div class="form-group mb-2">--}}
{{--                                    <label>Bust(cm)*</label>--}}
{{--                                    <select class="form-control" name="bust">--}}
{{--                                        <option value="">Choose</option>--}}
{{--                                        @for($i=5; $i<=50; $i++)--}}
{{--                                            <option value="{{$i}}">{{$i}}cm.</option>--}}
{{--                                        @endfor--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-4">--}}
{{--                                <div class="form-group mb-2">--}}
{{--                                    <label>Waist(cm)*</label>--}}
{{--                                    <select class="form-control" name="waist">--}}
{{--                                        <option value="">Choose</option>--}}
{{--                                        @for($i=5; $i<=50; $i++)--}}
{{--                                            <option value="{{$i}}">{{$i}}cm.</option>--}}
{{--                                        @endfor--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-4">--}}
{{--                                <div class="form-group mb-2">--}}
{{--                                    <label>Hips(cm)*</label>--}}
{{--                                    <select class="form-control" name="hips">--}}
{{--                                        <option value="">Choose</option>--}}
{{--                                        @for($i=5; $i<=50; $i++)--}}
{{--                                            <option value="{{$i}}">{{$i}}cm.</option>--}}
{{--                                        @endfor--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="row">--}}
{{--                            <div class="col-md-4">--}}
{{--                                <div class="form-group mb-2">--}}
{{--                                    <label>Dress Size*</label>--}}
{{--                                    <select class="form-control" name="dress">--}}
{{--                                        <option value="">Choose</option>--}}
{{--                                        @foreach($arr as $a)--}}
{{--                                            <option value="{{$a}}">{{$a}}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-4">--}}
{{--                                <div class="form-group mb-2">--}}
{{--                                    <label>Hair Color*</label>--}}
{{--                                    <select class="form-control" name="hair">--}}
{{--                                        <option value="">Choose</option>--}}
{{--                                        <option>Bald</option>--}}
{{--                                        <option>Black</option>--}}
{{--                                        <option>Blonde</option>--}}
{{--                                        <option>Brown</option>--}}
{{--                                        <option>Gray</option>--}}
{{--                                        <option>White</option>--}}
{{--                                        <option>Red</option>--}}
{{--                                        <option>Colored</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-4">--}}
{{--                                <div class="form-group mb-2">--}}
{{--                                    <label>Eyes color*</label>--}}
{{--                                    <select class="form-control" name="eyes">--}}
{{--                                        <option value="">Choose</option>--}}
{{--                                        <option>Brown</option>--}}
{{--                                        <option>Black</option>--}}
{{--                                        <option>Green</option>--}}
{{--                                        <option>Blue</option>--}}
{{--                                        <option>Honey</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="row mt-2">--}}
{{--                            <div class="col-md-3">--}}
{{--                                <div class="mb-2 form-check">--}}
{{--                                    <input type="checkbox" class="form-check-input" name="other[]"--}}
{{--                                           value="fitness">--}}
{{--                                    <label class="form-check-label" for="flexCheckDefault">--}}
{{--                                        Fitness--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-3">--}}
{{--                                <div class="mb-2 form-check">--}}
{{--                                    <input type="checkbox" class="form-check-input" name="other[]"--}}
{{--                                           value="tatoo">--}}
{{--                                    <label class="form-check-label" for="flexCheckDefault">--}}
{{--                                        Tatoo--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-3">--}}
{{--                                <div class="mb-2 form-check">--}}
{{--                                    <input type="checkbox" class="form-check-input" name="other[]"--}}
{{--                                           value="piercing">--}}
{{--                                    <label class="form-check-label" for="flexCheckDefault">--}}
{{--                                        Piercing--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-3">--}}
{{--                                <div class="mb-2 form-check">--}}
{{--                                    <input type="checkbox" class="form-check-input" name="other[]"--}}
{{--                                           value="silicone">--}}
{{--                                    <label class="form-check-label" for="flexCheckDefault">--}}
{{--                                        Silicone--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}



                        <div class="form-check">
                            <input required class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                <a target="_blank" href="{{route('terms')}}"> {{__('main.iagree_terms')}} </a>
                            </label>
                        </div>

                        <div class="d-grid gap-2 mx-auto col-4 mt-4">
                            <button type="submit" class="btn btn-dark">{{__('main.sign_up')}}</button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@include('footer')
