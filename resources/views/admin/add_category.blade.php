@extends('admin.header')
@section('content')
    <div class="row admin-secondary-nav">
        <div class="col-12">
            <nav style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item {{ (request()->is('admin/category/contests')) ? 'active-admin' : '' }}" aria-current="page"><a class="text-decoration text-black" href="{{route('admin.category.contests')}}">Dashboard</a></li>
                    <li class="breadcrumb-item {{ (request()->is('admin/contest/winners')) ? 'active-admin' : '' }}" aria-current="page"><a class="text-decoration text-black" href="{{route('admin.winners')}}">Winners</a></li>
                    <li class="breadcrumb-item {{ (request()->is('admin/add/contest')) ? 'active-admin' : '' }}" aria-current="page"><a class="text-decoration text-black" href="{{route('add.contest')}}">Creator</a></li>
                    <li class="breadcrumb-item {{ (request()->is('admin/add/category')) ? 'active-admin' : '' }}" aria-current="page"><a class="text-decoration text-black" href="{{route('add.category')}}">Category</a></li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-10">
                    <div class="sec-box">
                        <form action="{{route('add.category.post')}}" method="post">
                            @csrf

                            <div class="mb-3">
                                <label>Category Name*</label>
                                <input type="text" name="cate_name" class="form-control" placeholder="eg. Female Teen">
                                @error('cate_name')
                                    <div class="text-danger fw-bold">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Age</label>
                                        <div class="row">
                                            <div class="col-6">
                                                <select name="age_from" class="form-control">
                                                    <option value="">from</option>
                                                    @for ($i = 1; $i <= 11; $i++)
                                                        <option value="{{ $i }}_m">{{ $i }} months</option>
                                                    @endfor
                                                        @for ($i = 1; $i <= 100; $i++)
                                                            <option value="{{ $i }}_y">{{ $i }} years</option>
                                                        @endfor
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <select name="age_to" class="form-control">
                                                    <option value="">to</option>
                                                    @for ($i = 1; $i <= 11; $i++)
                                                        <option value="{{ $i }}_m">{{ $i }} months</option>
                                                    @endfor
                                                    @for ($i = 1; $i <= 100; $i++)
                                                        <option value="{{ $i }}_y">{{ $i }} years</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Height(m)</label>
                                        <div class="row">
                                            <div class="col-6">
                                                <select class="form-control" name="height_from">
                                                    <option value="">from</option>
                                                    @for ($i = 0.1; $i <= 20; $i++)
                                                        @for ($j = 0; $j <= 9; $j++)
                                                            @php $value = $i + ($j / 10); @endphp
                                                            <option value="{{ $value }}">{{ $value }} meters</option>
                                                        @endfor
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <select class="form-control" name="height_to">
                                                    <option value="">to</option>
                                                    @for ($i = 0.1; $i <= 20; $i++)
                                                        @for ($j = 0; $j <= 9; $j++)
                                                            @php $value = $i + ($j / 10); @endphp
                                                            <option value="{{ $value }}">{{ $value }} meters</option>
                                                        @endfor
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label>Dress Size</label>
                                        <div class="row">
                                            <div class="col-10">
                                                <select name="dress_size[]" multiple class="form-control" style="height: 250px;">

                                                    @foreach($arr as $a)
                                                        <option value="{{$a}}">{{$a}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-4">
                                    <label>Gender</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="female" name="gender[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Female
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="male" name="gender[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Male
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="gender[]"
                                               value="male_trans">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Male trans
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="gender[]"
                                               value="female_trans">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Female trans
                                        </label>
                                    </div>
                                    @error('gender')
                                    <div class="text-danger fw-bold">{{$message}}</div>
                                    @enderror
                                </div>

{{--                                <div class="col-md-4">--}}
{{--                                    <label>Skin Color</label>--}}
{{--                                    <div class="form-check">--}}
{{--                                        <input class="form-check-input" type="checkbox" value="white" name="skin[]" id="flexCheckDefault">--}}
{{--                                        <label class="form-check-label" for="flexCheckDefault">--}}
{{--                                            White--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                    <div class="form-check">--}}
{{--                                        <input class="form-check-input" type="checkbox" value="brown" name="skin[]" id="flexCheckDefault">--}}
{{--                                        <label class="form-check-label" for="flexCheckDefault">--}}
{{--                                            Brown--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                    <div class="form-check">--}}
{{--                                        <input class="form-check-input" type="checkbox" value="black" name="skin[]" id="flexCheckDefault">--}}
{{--                                        <label class="form-check-label" for="flexCheckDefault">--}}
{{--                                            Black--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                                <div class="col-md-4">--}}
{{--                                    <label>Hair Color</label>--}}
{{--                                    <div class="form-check">--}}
{{--                                        <input class="form-check-input" type="checkbox" value="white" name="hair[]" id="flexCheckDefault">--}}
{{--                                        <label class="form-check-label" for="flexCheckDefault">--}}
{{--                                            White--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                    <div class="form-check">--}}
{{--                                        <input class="form-check-input" type="checkbox" value="black" name="hair[]" id="flexCheckDefault">--}}
{{--                                        <label class="form-check-label" for="flexCheckDefault">--}}
{{--                                            Black--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                    <div class="form-check">--}}
{{--                                        <input class="form-check-input" type="checkbox" value="blond" name="hair[]" id="flexCheckDefault">--}}
{{--                                        <label class="form-check-label" for="flexCheckDefault">--}}
{{--                                            Blond--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                    <div class="form-check">--}}
{{--                                        <input class="form-check-input" type="checkbox" value="color" name="hair[]" id="flexCheckDefault">--}}
{{--                                        <label class="form-check-label" for="flexCheckDefault">--}}
{{--                                            Color--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

                            </div>

                            <div class="d-grid gap-2 mx-auto col-5 mt-4">
                                <button type="submit" class="btn btn-dark">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            @foreach($data as $d)
                <div class="sec-box mb-2">
                    <h4 class="fw-bold fs-4">{{$d->title}}</h4>
                    <p class="text-black-50">
                        @php
                            $exp = explode(',', $d->_age);
                            $from = (int)$exp[0]/12;
                            $to = (int)$exp[1]/12;
                        @endphp
                        Age: {{$from}}, {{$to}}, Height: {{$d->_height}}, Gender: {{$d->_gender}}, Dress: {{$d->_dress}}
                    </p>
                    <p class="d-flex flex-column align-items-end">
                        <a onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm" href="{{route('category.delete', [$d->id])}}">Delete</a>
                    </p>
                </div>
            @endforeach
        </div>
    </div>

@endsection
