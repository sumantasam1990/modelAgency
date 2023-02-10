@extends('header')
@section('content')

    <div class="row">
        <div class="col-md-8">
            <table class="table table-bordered table-striped">
                <thead>
                <tr class="fs-5">
                    <th>Category</th>
                    <th>Prize First (AVG)</th>
                    <th>Prize Second (AVG)</th>
                    <th>Prize Third (AVG)</th>
                    <th>Participants</th>
                </tr>
                </thead>
                <tbody>
                @foreach($totalParticipantsByCategory as $category)
                    <tr class="table-row">
                        <td class="fw-bold">
                            <a class="text-dark" href="{{route('admin.category.contests', [$category['category_id']])}}">{{$category['category_title']}}</a>
                        </td>
                        <td>${{$category['average_prize_first']}}</td>
                        <td>${{$category['average_prize_second']}}</td>
                        <td>${{$category['average_prize_third']}}</td>
                        <td class="fw-bold">{{$category['total_participants']}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
