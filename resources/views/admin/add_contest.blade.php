@extends('header')
@section('content')

    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-10">
                    <div class="sec-box">
                        <form action="{{route('add.contest.post')}}" method="post">
                            @csrf

                            <div class="mb-3">
                                <label>Model Category*</label>
                                <select class="form-control" name="category">
                                    <option value="">Select category</option>
                                    @foreach($data as $d)
                                        <option value="{{$d->id}}">{{$d->title}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Contest Name*</label>
                                <input type="text" class="form-control" name="contest_name" placeholder="eg. Male fashion contest">
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label>Contest Date*</label>
                                        <div class="row">
                                            <div class="col-6">
                                                <input type="date" name="date_from" class="form-control" placeholder="">
                                            </div>
                                            <div class="col-6">
                                                <input type="date" name="date_to" class="form-control" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label>Contest Price*</label>
                                        <div class="row">
                                            <div class="col-4">
                                                <input type="text" name="contest_price_first" class="form-control" placeholder="First place ($)">
                                            </div>
                                            <div class="col-4">
                                                <input type="text" name="contest_price_second" class="form-control" placeholder="Second place ($)">
                                            </div>
                                            <div class="col-4">
                                                <input type="text" name="contest_price_third" class="form-control" placeholder="Third place ($)">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="d-grid gap-2 mx-auto col-5 mt-4">
                                <button type="submit" class="btn btn-dark">Create Contest</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">

                @foreach($contests as $category)
                <div class="sec-box mb-3 text-center">
                    <div class="header-box p-2 mb-2">
                        <h2 class="fs-4">List Of All <span class="fw-bold">{{$category->title}}</span> Contest</h2>
                    </div>
                    @foreach($category->contests as $contest)
                        <div class="sec-box mb-2">
                            <h4 class="fw-bold fs-4">{{$contest->title}}</h4>
                            <p class="text-black-50 mb-0">
                                Start: <span class="fw-bold">{{$contest->start}}</span>, End: <span class="fw-bold">{{$contest->end}}</span>, First Prize: <span class="fw-bold">{{$contest->prize_first}}</span>, Second Prize: <span class="fw-bold">{{$contest->prize_second}}</span>, Third Prize: <span class="fw-bold">{{$contest->prize_third}}</span>
                            </p>
                            <p class="text-dark mt-0">
                                Total Participants: <span class="fw-bold">{{$contest->user_participants_count}}</span>
                            </p>
                            <p class="">
                                <a onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm" href="{{route('contest.delete', [$contest->id])}}">Delete</a>
                            </p>
                        </div>
                    @endforeach
                </div>
                @endforeach

        </div>
    </div>


@endsection
