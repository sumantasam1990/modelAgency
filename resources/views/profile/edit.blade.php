@extends('header')
@section('content')

    <form action="{{route('update.profile')}}" method="post" class="row mb-3">
        @csrf

        <div class="col-md-6">
            <h4 class="fw-bold fs-4 mb-3">{{__('main.edit_profile_update_account')}}</h4>
            <div class="form-group mb-2">
                <label>{{__('main.edit_profile_name')}}*</label>
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
                        <label>{{__('main.edit_profile_district')}}*</label>
                        <input type="text" name="_district" value="{{$user->district ?? ''}}" placeholder="" class="form-control @error('_district') is-invalid @enderror">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group mb-2">
                        <label>{{__('main.edit_profile_whatsapp')}}*</label>
                        <input type="text" name="_wp" value="{{$user->wp ?? ''}}" placeholder="" class="form-control @error('_wp') is-invalid @enderror">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group mb-2">
                        <label>{{__('main.edit_profile_gender')}}*</label>
                        <select class="form-control @error('_gender') is-invalid @enderror" name="_gender">
                            <option value="" selected>Select</option>
                            <option value="Female" {{$user->gender == 'Female' ? 'selected' : ''}}>{{__('main.edit_profile_female')}}</option>
                            <option value="Male" {{$user->gender == 'Male' ? 'selected' : ''}}>{{__('main.edit_profile_male')}}</option>
                            <option value="male_trans" {{$user->gender == 'male_trans' ? 'selected' : ''}}>{{__('main.edit_profile_male_trans')}}</option>
                            <option value="female_trans" {{$user->gender == 'female_trans' ? 'selected' : ''}}>{{__('main.edit_profile_female_trans')}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group mb-2">
                        <label>Civil Status*</label>
                        <select class="form-control @error('_civil_status') is-invalid @enderror" name="_civil_status">
                            <option value="">{{__('main.edit_profile_choose')}}</option>
                            <option {{$user->civil == 'Single' ? 'selected' : ''}} value="Single">{{__('main.edit_profile_single')}}</option>
                            <option {{$user->civil == 'Married' ? 'selected' : ''}} value="Married">{{__('main.edit_profile_married')}}</option>
                            <option value="relationship" {{$user->civil == 'relationship' ? 'selected' : ''}}>{{__('main.edit_profile_in_a_relationship')}}</option>
                        </select>
                    </div>
                </div>
            </div>

            <h4 class="fw-bold fs-4 mt-3">{{__('main.edit_profile_body_characteristics')}}</h4>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group mb-2">
                        <label>{{__('main.edit_profile_age')}}*</label>
                        <input type="date" name="_age" value="{{$user->age}}" placeholder="d/m/Y" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-2">
                        <label>{{__('main.edit_profile_height')}}*</label>
                        <select class="form-control" name="_height">
                            <option value="">{{__('main.choose')}}</option>
                            @foreach(range(20, 220) as $number)
                                <option {{$user->height == number_format($number / 100, 2) ? 'selected' : ''}} value="{{ number_format($number / 100, 2) }}">{{number_format($number / 100, 2)}} </option>
                            @endforeach

                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-2">
                        <label>{{__('main.edit_profile_skin_color')}}*</label>
                        <select class="form-control" name="_skin">
                            <option value="">{{__('main.choose')}}</option>
                            <option value="White" {{$user->skin == 'White' ? 'selected' : ''}}>{{__('main.edit_profile_white')}}</option>
                            <option {{$user->skin == 'Brown' ? 'selected' : ''}} value="Brown">{{__('main.edit_profile_brown')}}</option>
                            <option {{$user->skin == 'Black' ? 'selected' : ''}} value="Black">{{__('main.edit_profile_black')}}</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group mb-2">
                        <label>{{__('main.edit_profile_bust')}}*</label>
{{--                        <input type="number" name="bust" value="{{$user->bust ?? ''}}" placeholder="" class="form-control">--}}
                        <select class="form-control" name="bust">
                            <option value="">{{__('main.choose')}}</option>
                            <option value="Small" {{$user->bust == 'Small' ? 'selected' : ''}}>{{__('main.edit_profile_small')}}</option>
                            <option {{$user->bust == 'Medium' ? 'selected' : ''}} value="Medium">{{__('main.Medium')}}</option>
                            <option {{$user->bust == 'Large' ? 'selected' : ''}} value="Large">{{__('main.Large')}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-2">
                        <label>{{__('main.edit_profile_waist')}}*</label>
{{--                        <input type="number" name="waist" value="{{$user->waist}}" placeholder="" class="form-control">--}}

                        <select class="form-control" name="waist">
                            <option value="">{{__('main.choose')}}</option>
                            <option {{$user->waist == 'Thin' ? 'selected' : ''}} value="Thin">{{__('main.Thin')}}</option>
                            <option {{$user->waist == 'Medium' ? 'selected' : ''}} value="Medium">{{__('main.Medium')}}</option>
                            <option {{$user->waist == 'Large' ? 'selected' : ''}} value="Large">{{__('main.Large')}}</option>
                        </select>

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-2">
                        <label>{{__('main.edit_profile_hips')}}*</label>
{{--                        <input type="number" name="hips" value="{{$user->hips}}" placeholder="" class="form-control">--}}

                        <select class="form-control" name="hips">
                            <option value="">{{__('main.choose')}}</option>
                            <option {{$user->hips == 'Small' ? 'selected' : ''}} value="Small">{{__('main.edit_profile_small')}}</option>
                            <option {{$user->hips == 'Medium' ? 'selected' : ''}} value="Medium">{{__('main.Medium')}}</option>
                            <option {{$user->hips == 'Large' ? 'selected' : ''}} value="Large">{{__('main.Large')}}</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group mb-2">
                        <label>{{__('main.Dress_Size')}}*</label>
                        <select class="form-control" name="dress">
                            @foreach($arr as $a)
                                <option {{$user->dress == $a ? 'selected' : ''}} value="{{$a}}">{{$a}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-2">
                        <label>{{__('main.Hair_Color')}}*</label>
                        <select class="form-control" name="hair">
                            <option value="">{{__('main.choose')}}</option>
                            <option {{$user->hair == 'Bald' ? 'selected' : ''}} value="Bald">{{__('main.Bald')}}</option>
                            <option {{$user->hair == 'Black' ? 'selected' : ''}} value="Black">{{__('main.Black')}}</option>
                            <option {{$user->hair == 'Blonde' ? 'selected' : ''}} value="Blonde">{{__('main.Blond')}}</option>
                            <option {{$user->hair == 'Brown' ? 'selected' : ''}} value="Brown">{{__('main.Brown')}}</option>
                            <option {{$user->hair == 'Gray' ? 'selected' : ''}} value="Gray">{{__('main.Grey')}}</option>
                            <option {{$user->hair == 'White' ? 'selected' : ''}} value="White">{{__('main.White')}}</option>
                            <option {{$user->hair == 'Red' ? 'selected' : ''}} value="Red">{{__('main.Red')}}</option>
                            <option {{$user->hair == 'Colored' ? 'selected' : ''}} value="Colored">{{__('main.Colored')}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-2">
                        <label>{{__('main.Eyes_Color')}}*</label>
                        <select class="form-control" name="eyes">
                            <option value="">{{__('main.choose')}}</option>
                            <option {{$user->eyes == 'Brown' ? 'selected' : ''}} value="Brown">{{__('main.Brown')}}</option>
                            <option {{$user->eyes == 'Black' ? 'selected' : ''}} value="Black">{{__('main.Black')}}</option>
                            <option {{$user->eyes == 'Green' ? 'selected' : ''}} value="Green">{{__('main.Green')}}</option>
                            <option {{$user->eyes == 'Blue' ? 'selected' : ''}} value="Blue">{{__('main.Blue')}}</option>
                            <option {{$user->eyes == 'Honey' ? 'selected' : ''}} value="Honey">{{__('main.Honey')}}</option>
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
                            {{__('main.Fitness')}}
                        </label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-2 form-check">
                        <input type="checkbox" {{in_array('tatoo', explode(',', $user->other)) ? 'checked' : ''}} class="form-check-input" name="other[]"
                               value="tatoo">
                        <label class="form-check-label" for="flexCheckDefault">
                            {{__('main.Tatoo')}}
                        </label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-2 form-check">
                        <input type="checkbox" {{in_array('piercing', explode(',', $user->other)) ? 'checked' : ''}} class="form-check-input" name="other[]"
                               value="piercing">
                        <label class="form-check-label" for="flexCheckDefault">
                            {{__('main.Piercing')}}
                        </label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-2 form-check">
                        <input type="checkbox" {{in_array('silicone', explode(',', $user->other)) ? 'checked' : ''}} class="form-check-input" name="other[]"
                               value="silicone">
                        <label class="form-check-label" for="flexCheckDefault">
                            {{__('main.Silicone')}}
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <h4 class="fw-bold fs-4 mt-3">{{__('main.Main_Social_Networks')}}</h4>

            <div class="row mt-2">
                <div class="col-md-4">
                    <input type="text" readonly name="social_insta_label" value="Instagram" class="form-control border-0 fw-bold">
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
            <div class="row mt-2">
                <div class="col-md-4">
                    <input type="text" readonly name="social_tiktok_label" value="Tiktok" class="form-control border-0 fw-bold">
                </div>
                <div class="col-md-4">
                    <input type="url" name="social_tiktok_url" value="{{$user->preferences['social']['tiktok']['url'] ?? ''}}" placeholder="URL" class="form-control">
                </div>
                <div class="col-md-4">
                    <select class="form-control" name="social_tiktok_follow">
                        <option {{isset($user->preferences['social']['tiktok']['follower']) && $user->preferences['social']['tiktok']['follower'] == '100 - 1000' ? 'selected' : ''}}>100 -1000</option>
                        <option {{isset($user->preferences['social']['tiktok']['follower']) && $user->preferences['social']['tiktok']['follower'] == '1k - 2k' ? 'selected' : ''}}>1k - 2k</option>
                        <option {{isset($user->preferences['social']['tiktok']['follower']) && $user->preferences['social']['tiktok']['follower'] == '2k - 5k' ? 'selected' : ''}}>2k - 5k</option>

                        <option {{isset($user->preferences['social']['tiktok']['follower']) && $user->preferences['social']['tiktok']['follower'] == '5k - 10k' ? 'selected' : ''}}>5k - 10k</option>
                        <option {{isset($user->preferences['social']['tiktok']['follower']) && $user->preferences['social']['tiktok']['follower'] == '11k - 50k' ? 'selected' : ''}}>11k - 50k</option>
                        <option {{isset($user->preferences['social']['tiktok']['follower']) && $user->preferences['social']['tiktok']['follower'] == '51k - 100k' ? 'selected' : ''}}>51k - 100k</option>
                        <option {{isset($user->preferences['social']['tiktok']['follower']) && $user->preferences['social']['tiktok']['follower'] == '101k - 1M' ? 'selected' : ''}}>101k - 1M</option>
                        <option {{isset($user->preferences['social']['tiktok']['follower']) && $user->preferences['social']['tiktok']['follower'] == '1M+' ? 'selected' : ''}}>1M+</option>
                    </select>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-4">
                    <input type="text" name="social_other_label" value="{{$user->preferences['social']['other']['label'] ?? ''}}" placeholder="{{__('main.Name_of_social_media')}}" class="form-control fw-bold">

                </div>
                <div class="col-md-4">
                    <input type="url" name="social_other_url" value="{{$user->preferences['social']['other']['url'] ?? ''}}" placeholder="URL" class="form-control">
                </div>
                <div class="col-md-4">
                    <select class="form-control" name="social_other_follow">
                        <option {{isset($user->preferences['social']['other']['follower']) && $user->preferences['social']['other']['follower'] == '100 - 1000' ? 'selected' : ''}}>100 -1000</option>
                        <option {{isset($user->preferences['social']['other']['follower']) && $user->preferences['social']['other']['follower'] == '1k - 2k' ? 'selected' : ''}}>1k -2k</option>
                        <option {{isset($user->preferences['social']['other']['follower']) && $user->preferences['social']['other']['follower'] == '2k - 5k' ? 'selected' : ''}}>2k -5k</option>
                        <option {{isset($user->preferences['social']['other']['follower']) && $user->preferences['social']['other']['follower'] == '5k - 10k' ? 'selected' : ''}}>5k - 10k</option>
                        <option {{isset($user->preferences['social']['other']['follower']) && $user->preferences['social']['other']['follower'] == '11k - 50k' ? 'selected' : ''}}>11k - 50k</option>
                        <option {{isset($user->preferences['social']['other']['follower']) && $user->preferences['social']['other']['follower'] == '51k - 100k' ? 'selected' : ''}}>51k - 100k</option>
                        <option {{isset($user->preferences['social']['other']['follower']) && $user->preferences['social']['other']['follower'] == '101k - 1M' ? 'selected' : ''}}>101k - 1M</option>
                        <option {{isset($user->preferences['social']['other']['follower']) && $user->preferences['social']['other']['follower'] == '1M+' ? 'selected' : ''}}>1M+</option>
                    </select>
                </div>
            </div>

            <h4 class="fw-bold fs-4 mt-3">{{__('main.Bank_Details')}}</h4>

            @php
                $exp = explode(',', $user->configure_pix->value ?? '');
            @endphp
            <div class="row mt-2">
                <div class="col-md-6">
                    <label>{{__('main.Pix_name')}}</label>
                    <input type="text" name="pix_name" value="{{ $exp[0] ?? '' }}" placeholder="{{__('main.Pix_name')}}" class="form-control border-2 fw-bold">
                </div>
                <div class="col-md-6">
                    <label>{{__('main.Pix_email/code/phone')}}</label>
                    <input type="text" name="pix" value="{{ $exp[1] ?? '' }}" placeholder="{{__('main.Pix_email/code/phone')}}" class="form-control border-2 fw-bold">
                </div>
            </div>

            <div class="d-grid gap-2 mx-auto col-4 mt-4">
                <button type="submit" class="btn btn-dark">{{__('main.Update')}}</button>
            </div>
        </div>
    </form>

@endsection
