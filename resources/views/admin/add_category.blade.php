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
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Age(in month)</label>
                                        <div class="row">
                                            <div class="col-6">
                                                <input type="text" name="age_from" class="form-control" placeholder="from">
                                            </div>
                                            <div class="col-6">
                                                <input type="text" name="age_to" class="form-control" placeholder="to">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Height(m)</label>
                                        <div class="row">
                                            <div class="col-6">
                                                <input type="text" name="height_from" class="form-control" placeholder="from">
                                            </div>
                                            <div class="col-6">
                                                <input type="text" name="height_to" class="form-control" placeholder="to">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label>Dress Size</label>
                                        <div class="row">
                                            <div class="col-10">
                                                <select class="form-control" name="dress_size[]" multiple>
                                                    <option value="">Choose</option>
                                                    <option {{request('dress_size_from') == "Small" ? 'selected' : ''}}>Small</option>
                                                    <option {{request('dress_size_from') == "Medium" ? 'selected' : ''}}>Medium</option>
                                                    <option {{request('dress_size_from') == "Large" ? 'selected' : ''}}>Large</option>
                                                    <option {{request('dress_size_from') == "XL" ? 'selected' : ''}}>XL</option>
                                                    <option {{request('dress_size_from') == "XXL" ? 'selected' : ''}}>XXL</option>
                                                    <option {{request('dress_size_from') == "XXXL" ? 'selected' : ''}}>XXXL</option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>

{{--                                    <input type="checkbox" name="all_filter" value="all_filter"> <strong>All</strong>--}}
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
                        age: <span class="fw-bold">{{$d->age}}</span>, height: <span class="fw-bold">{{$d->height}}</span>, gender: <span class="fw-bold">{{$d->gender}}</span>, skin color: <span class="fw-bold">{{$d->skin_color}}</span>, hair color: <span class="fw-bold">{{$d->hair_color}}</span>
                    </p>
                    <p class="d-flex flex-column align-items-end">
                        <a onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm" href="{{route('category.delete', [$d->id])}}">Delete</a>
                    </p>
                </div>
            @endforeach
        </div>
    </div>

@endsection
