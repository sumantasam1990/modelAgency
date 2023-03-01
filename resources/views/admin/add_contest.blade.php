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
                        <form action="{{route('add.contest.post')}}" method="post">
                            @csrf

                            <div class="mb-3">
                                <label>Model Category*</label>
                                <select class="form-control" name="category" id="my-select">
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

                            <!-- Modal -->
                            <div class="modal fade" id="rules" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Rules</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            <div class="mb-2">
                            <textarea name="rules" rows="8" class="form-control">
Allowed only to subscribers users.
They can vote only in other categories of contests.
The 3 most voted at the end of the contest will be the winners.
Everyone who fits the contest category will be participating automatically.
New entrants are allowed during the running of the contest.
The amount of votes will only be displayed at the end of the contest.
Users would not see all models that are participating in a contest category.</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-row justify-content-between mt-4">
                                <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#rules">Rules</button>
                                <button type="submit" class="btn btn-dark">Create Contest</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">

            <div id="my-div">
                <ul>
                    <!-- Display the data here -->
                </ul>
            </div>

                @foreach($contests as $category)
                <div class="sec-box mb-3 text-center">
                    <div class="header-box p-2 mb-2">
                        <h2 class="fs-4">List Of All <span class="fw-bold">{{$category->title}}</span> Contest</h2>
                    </div>
                    @foreach($category->contests as $contest)
                        <div class="sec-box mb-2">
                            <h4 class="fw-bold fs-4">{{$contest->title}}</h4>
                            <p class="text-black-50 mb-0">
                                Start: <span class="fw-bold">{{$contest->start}}</span>
                            </p>
                            <p class="text-black-50 mb-0">
                                End: <span class="fw-bold">{{$contest->end}}</span>, First Prize: <span class="fw-bold">{{$contest->prize_first}}</span>, Second Prize: <span class="fw-bold">{{$contest->prize_second}}</span>, Third Prize: <span class="fw-bold">{{$contest->prize_third}}</span>
                            </p>
                            <p class="text-dark mt-1 fw-bold">
                                Total Participants: <span class="fw-bold">{{$contest->user_participants_count}}</span>
                            </p>
                            <p>
                                <a onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm" href="{{route('contest.delete', [$contest->id])}}">Delete</a>
                            </p>
                        </div>
                    @endforeach
                </div>
                @endforeach

        </div>
    </div>

    <script>
        document.getElementById('my-select').addEventListener('change', function() {
            var value = this.value;
            if (value) {
                fetch('/model/contest/info/category/' + value)
                    .then(response => response.json())
                    .then(data => {
                        console.log(data)
                        var list = document.getElementById('my-div');
                        list.innerHTML = '<ul>';
                        data.forEach(function(user) {
                            list.innerHTML += '<li>' + user.title + '</li>';
                        });
                        list.innerHTML += '</ul>';
                    })
                    .catch(error => console.error(error));
            }
        });
    </script>



@endsection
