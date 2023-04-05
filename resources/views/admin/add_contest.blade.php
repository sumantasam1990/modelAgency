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
                                <select required class="form-control" name="category" id="my-select-hgvvhj">
                                    <option value="">Select category</option>
                                    @foreach($data as $d)
                                        <option value="{{$d->id}}">{{$d->title}}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <div class="text-danger fw-bold">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label>Contest Name*</label>
                                <input required type="text" class="form-control" name="contest_name" placeholder="eg. Male fashion contest">
                                @error('contest_name')
                                <div class="text-danger fw-bold">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label>Contest Date*</label>
                                        <div class="row">
                                            <div class="col-6">
                                                <input required type="date" name="date_from" class="form-control" placeholder="">
                                            </div>
                                            <div class="col-6">
                                                <input required type="date" name="date_to" class="form-control" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label>Contest Price*</label>
                                        <div class="row">
                                            <div class="col-4">
                                                <input required type="text" name="contest_price_first" class="form-control" placeholder="First place ($)">
                                            </div>
                                            <div class="col-4">
                                                <input required type="text" name="contest_price_second" class="form-control" placeholder="Second place ($)">
                                            </div>
                                            <div class="col-4">
                                                <input required type="text" name="contest_price_third" class="form-control" placeholder="Third place ($)">
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

{{--                @foreach($contests as $category)--}}
{{--                <div class="sec-box mb-3 text-center">--}}
{{--                    <div class="header-box p-2 mb-2">--}}
{{--                        <h2 class="fs-4">List Of All <span class="fw-bold">{{$category->title}}</span> Contest</h2>--}}
{{--                    </div>--}}
{{--                    @foreach($category->contests as $contest)--}}
{{--                        <div class="sec-box mb-2">--}}
{{--                            <h4 class="fw-bold fs-4">{{$contest->title}}</h4>--}}
{{--                            <p class="text-black-50 mb-0">--}}
{{--                                Start: <span class="fw-bold">{{$contest->start}}</span>--}}
{{--                            </p>--}}
{{--                            <p class="text-black-50 mb-0">--}}
{{--                                End: <span class="fw-bold">{{$contest->end}}</span>, First Prize: <span class="fw-bold">{{$contest->prize_first}}</span>, Second Prize: <span class="fw-bold">{{$contest->prize_second}}</span>, Third Prize: <span class="fw-bold">{{$contest->prize_third}}</span>--}}
{{--                            </p>--}}
{{--                            <p class="text-dark mt-1 fw-bold">--}}
{{--                                Total Participants: <span class="fw-bold">{{$contest->user_participants_count}}</span>--}}
{{--                            </p>--}}
{{--                            <p>--}}
{{--                                <a onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm" href="{{route('contest.delete', [$contest->id])}}">Delete</a>--}}
{{--                            </p>--}}
{{--                        </div>--}}
{{--                    @endforeach--}}
{{--                </div>--}}
{{--                @endforeach--}}

        </div>
    </div>

    <script>
        const selectElement = document.getElementById('my-select-hgvvhj');
        selectElement.addEventListener('change', getContests);

        function getContests() {
            const value = this.value;
            if (value) {
                fetch('/admin/contest/info/category/' + value)
                    .then(response => response.json())
                    .then(category => {
                        var list = document.getElementById('my-div');
                        list.innerHTML = '';
                        //categories.forEach(function(category) {
                        // create a new div for the category item
                        var categoryDiv = document.createElement('div');
                        categoryDiv.classList.add('sec-box');

                        categoryDiv.innerHTML = 'List Of All <span class="fw-bold">' + category.title + '</span> Contests';

                        // create a new div for the contests list
                        var contestsDiv = document.createElement('div');
                        contestsDiv.classList.add('contests');

                        // loop over the contests array and create a new div for each title
                        category.contests.forEach(function(contest) {

                            var contestDiv = document.createElement('div');
                            contestDiv.classList.add('contestt');
                            contestDiv.classList.add('fs-4');
                            contestDiv.classList.add('fw-bold');
                            contestDiv.innerHTML = contest.title;

                            var contestStart = document.createElement('p');
                            contestStart.classList.add('text-black-50');
                            contestStart.classList.add('mb-1');
                            contestStart.classList.add('fs-6');
                            contestStart.innerHTML = 'Start: ' + contest.start + ' End: ' + contest.end;

                            var prize = document.createElement('div');
                            prize.classList.add('list-on');
                            prize.innerHTML = 'First Prize: ' + contest.prize_first + ', Second Prize: ' + contest.prize_second + ', Third Prize: ' + contest.prize_third;
                            var participants = document.createElement('p');
                            participants.classList.add('participant');
                            participants.innerHTML = 'Total Participants: ' + contest.user_participants_count;
                            var rules = document.createElement('p');
                            rules.classList.add('rules');
                            rules.classList.add('text-black-50');
                            rules.innerHTML = contest.rules;


                            contestDiv.appendChild(contestStart);
                            //contestDiv.appendChild(contestEnd);
                            contestDiv.appendChild(prize);
                            contestDiv.appendChild(participants);
                            contestDiv.appendChild(rules);


                            contestsDiv.appendChild(contestDiv);
                        });

                        // append the contests div to the category div
                        categoryDiv.appendChild(contestsDiv);

                        // append the category div to the main div
                        list.appendChild(categoryDiv);
                        //});
                    })
                    .catch(error => console.error(error));
            }
        }
    </script>

<style>
    .category {
        margin-bottom: 20px;
    }

    .category::before {
        content: '';
        display: block;
        height: 2px;
        background-color: black;
        margin-bottom: 10px;
    }

    .contests {
        margin-left: 20px;
        border: 1px solid #eee;
        padding: 12px;
        border-radius: 8px;
        margin-top: 12px;
    }

    .contestt {
        margin-bottom: 10px;
        /*font-size: 20px;*/
    }

    .contestt .list-on {
        color: #1a1e21;
        font-weight: bold;
        font-size: 14px;
    }

    .contestt .participant {
        font-size: 15px;
    }

    .contestt .rules {
        font-size: 15px;
    }

</style>

@endsection
