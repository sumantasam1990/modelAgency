@extends('header')
@section('content')

    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-8">
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
                                        <label>Age*</label>
                                        <div class="row">
                                            <div class="col-6">
                                                <input type="text" name="age_from" class="form-control" placeholder="eg. 18">
                                            </div>
                                            <div class="col-6">
                                                <input type="text" name="age_to" class="form-control" placeholder="eg. 35">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Height*</label>
                                        <div class="row">
                                            <div class="col-6">
                                                <input type="text" name="height_from" class="form-control" placeholder="eg. 5'7">
                                            </div>
                                            <div class="col-6">
                                                <input type="text" name="height_to" class="form-control" placeholder="eg. 8'2">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label>Gender*</label>
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
                                        <input class="form-check-input" type="checkbox" value="other" name="gender[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Other
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label>Skin Color</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="white" name="skin[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            White
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="brown" name="skin[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Brown
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="black" name="skin[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Black
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label>Hair Color</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="white" name="hair[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            White
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="black" name="hair[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Black
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="blond" name="hair[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Blond
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="color" name="hair[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Color
                                        </label>
                                    </div>
                                </div>

                            </div>

                            <div class="d-grid gap-2 mx-auto col-5 mt-4">
                                <button type="submit" class="btn btn-dark">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
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
