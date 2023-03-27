@extends('header')
@section('content')

    <form action="{{route('update.profile')}}" method="post" class="row mb-3">
        @csrf

        <div class="col-md-6">
            <h4 class="fw-bold fs-4 mb-3">Update Account</h4>
            <div class="form-group mb-2">
                <label>Name*</label>
                <input type="text" name="_name" value="{{$user->name ?? ''}}" placeholder="eg. John doe" class="form-control @error('_name') is-invalid @enderror">
                @if ($errors->has('_name'))
                    <span class="text-danger">{{ $errors->first('_name') }}</span>
                @endif
            </div>

            <div class="row">

                <livewire:state-city-select-box :selectedState="$user->state" :selectedCity="$user->city" />

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
                <div class="col-6">
                    <div class="form-group mb-2">
                        <label>District*</label>
                        <input type="text" name="_district" value="{{$user->district ?? ''}}" placeholder="" class="form-control @error('_district') is-invalid @enderror">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group mb-2">
                        <label>WhatsApp*</label>
                        <input type="text" name="_wp" value="{{$user->wp ?? ''}}" placeholder="" class="form-control @error('_wp') is-invalid @enderror">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group mb-2">
                        <label>Gender*</label>
                        <select class="form-control @error('_gender') is-invalid @enderror" name="_gender">
                            <option value="" selected>Select</option>
                            <option {{$user->gender == 'Female' ? 'selected' : ''}}>Female</option>
                            <option {{$user->gender == 'Male' ? 'selected' : ''}}>Male</option>
                            <option value="male_trans" {{$user->gender == 'male_trans' ? 'selected' : ''}}>Male trans</option>
                            <option value="female_trans" {{$user->gender == 'female_trans' ? 'selected' : ''}}>Female trans</option>
                        </select>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group mb-2">
                        <label>Civil Status*</label>
                        <select class="form-control @error('_civil_status') is-invalid @enderror" name="_civil_status">
                            <option value="">Choose</option>
                            <option {{$user->civil == 'Single' ? 'selected' : ''}}>Single</option>
                            <option {{$user->civil == 'Married' ? 'selected' : ''}}>Married</option>
                        </select>
                    </div>
                </div>
            </div>

            <h4 class="fw-bold fs-4 mt-3">Body Characteristics</h4>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group mb-2">
                        <label>Age*</label>
                        <input type="date" name="_age" value="{{$user->age}}" placeholder="d/m/Y" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-2">
                        <label>Height(m)*</label>
                        <select class="form-control" name="_height">
                            <option value="">Choose</option>
                            @for ($i = 0.1; $i <= 20; $i++)
                                @for ($j = 0; $j <= 9; $j++)
                                    @php $value = $i + ($j / 10); @endphp
                                    <option {{$user->height === $value ? 'selected' : ''}} value="{{ $value }}">{{ $value }} meters</option>
                                @endfor
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-2">
                        <label>Skin color*</label>
                        <select class="form-control" name="_skin">
                            <option value="">Choose</option>
                            <option {{$user->skin ? 'selected' : ''}}>White</option>
                            <option {{$user->skin == 'Brown' ? 'selected' : ''}}>Brown</option>
                            <option {{$user->skin == 'Black' ? 'selected' : ''}}>Black</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group mb-2">
                        <label>Bust(cm)*</label>
                        <input type="number" name="bust" value="{{$user->bust ?? ''}}" placeholder="" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-2">
                        <label>Waist(cm)*</label>
                        <input type="number" name="waist" value="{{$user->waist}}" placeholder="" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-2">
                        <label>Hips(cm)*</label>
                        <input type="number" name="hips" value="{{$user->hips}}" placeholder="" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group mb-2">
                        <label>Dress Size*</label>
                        <select class="form-control" name="dress">
                            @foreach($arr as $a)
                                <option {{$user->dress == $a ? 'selected' : ''}} value="{{$a}}">{{$a}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-2">
                        <label>Hair Color(m)*</label>
                        <select class="form-control" name="hair">
                            <option value="">Choose</option>
                            <option {{$user->hair == 'White' ? 'selected' : ''}}>White</option>
                            <option {{$user->hair == 'Black' ? 'selected' : ''}}>Black</option>
                            <option {{$user->hair == 'Blond' ? 'selected' : ''}}>Blond</option>
                            <option {{$user->hair == 'Color' ? 'selected' : ''}}>Color</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-2">
                        <label>Eyes color*</label>
                        <select class="form-control" name="eyes">
                            <option value="">Choose</option>
                            <option {{$user->eyes == 'Blue' ? 'selected' : ''}}>Blue</option>
                            <option {{$user->eyes == 'Brown' ? 'selected' : ''}}>Brown</option>
                            <option {{$user->eyes == 'Green' ? 'selected' : ''}}>Green</option>
                            <option {{$user->eyes == 'Hazel' ? 'selected' : ''}}>Hazel</option>
                            <option {{$user->eyes == 'Black' ? 'selected' : ''}}>Black</option>
                            <option {{$user->eyes == 'Purple' ? 'selected' : ''}}>Purple</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-3">
                    <div class="mb-2 form-check">
                        <input type="checkbox" {{in_array('fitness', explode(',', $user->other)) ? 'checked' : ''}} class="form-check-input" name="other[]"
                               value="fitness">
                        <label class="form-check-label" for="flexCheckDefault">
                            Fitness
                        </label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-2 form-check">
                        <input type="checkbox" {{in_array('tatoo', explode(',', $user->other)) ? 'checked' : ''}} class="form-check-input" name="other[]"
                               value="tatoo">
                        <label class="form-check-label" for="flexCheckDefault">
                            Tatoo
                        </label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-2 form-check">
                        <input type="checkbox" {{in_array('piercing', explode(',', $user->other)) ? 'checked' : ''}} class="form-check-input" name="other[]"
                               value="piercing">
                        <label class="form-check-label" for="flexCheckDefault">
                            Piercing
                        </label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-2 form-check">
                        <input type="checkbox" {{in_array('silicone', explode(',', $user->other)) ? 'checked' : ''}} class="form-check-input" name="other[]"
                               value="silicone">
                        <label class="form-check-label" for="flexCheckDefault">
                            Silicone
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <h4 class="fw-bold fs-4 mt-3">Main Social Networks</h4>

            <div class="row mt-2">
                <div class="col-md-4">
{{--                    <input type="text" readonly name="social_insta_label" value="Instagram" class="form-control border-0 fw-bold">--}}
                    <select class="form-control" name="social_label">
                        <option value="">Choose</option>
                        <option>Instagram</option>
                        <option>Tiktok</option>
                        <option>Youtube</option>
                        <option>Twitter</option>
                        <option>Kwai</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="url" name="social_insta_url" value="{{$user->preferences['social']['insta']['url'] ?? ''}}" placeholder="URL" class="form-control">
                </div>
                <div class="col-md-4">
                    <select class="form-control" name="social_insta_follow">
                        <option {{isset($user->preferences['social']['insta']['follower']) && $user->preferences['social']['insta']['follower'] == '100 - 1000' ? 'selected' : ''}}>100 -1000</option>
                        <option {{isset($user->preferences['social']['insta']['follower']) && $user->preferences['social']['insta']['follower'] == '1k - 2k' ? 'selected' : ''}}>1k -2k</option>
                        <option {{isset($user->preferences['social']['insta']['follower']) && $user->preferences['social']['insta']['follower'] == '2k - 5k' ? 'selected' : ''}}>2k -5k</option>


                        <option {{isset($user->preferences['social']['insta']['follower']) && $user->preferences['social']['insta']['follower'] == '5k - 10k' ? 'selected' : ''}}>5k - 10k</option>
                        <option {{isset($user->preferences['social']['insta']['follower']) && $user->preferences['social']['insta']['follower'] == '11k - 50k' ? 'selected' : ''}}>11k - 50k</option>
                        <option {{isset($user->preferences['social']['insta']['follower']) && $user->preferences['social']['insta']['follower'] == '51k - 100k' ? 'selected' : ''}}>51k - 100k</option>
                        <option {{isset($user->preferences['social']['insta']['follower']) && $user->preferences['social']['insta']['follower'] == '101k - 1M' ? 'selected' : ''}}>101k - 1M</option>
                        <option {{isset($user->preferences['social']['insta']['follower']) && $user->preferences['social']['insta']['follower'] == '1M+' ? 'selected' : ''}}>1M+</option>
                    </select>
                </div>
            </div>




            <h4 class="fw-bold fs-4 mt-3">Bank Details</h4>

            <div class="row mt-2">
                <div class="col-md-6">
                    <input type="text" name="bank" value="{{ $user->configure_bank->value ?? '' }}" placeholder="Account number" class="form-control border-2 fw-bold">
                </div>
                <div class="col-md-6">
                    <input type="text" name="pix" value="{{ $user->configure_pix->value ?? '' }}" placeholder="Pix Email ID" class="form-control border-2 fw-bold">
                </div>
            </div>

            <div class="d-grid gap-2 mx-auto col-4 mt-4">
                <button type="submit" class="btn btn-dark">Update</button>
            </div>
        </div>
    </form>

@endsection
