@extends('header')
@section('content')

    <div class="row mb-4">
        <div class="col-md-8">
            <h4 class="fw-bold fs-4 mb-1">{{__('main.notifications')}}</h4>
            <p class="text-black-50 mb-3 fs-6">{{__('main.notifications_results')}}</p>

            <div class="row mt-3">
                <div class="col-md-10">
                    @if(count($data) === 0)

                    @endif
                    @foreach($data as $contest)
                        <div class="sec-box mb-3">
                            <div class="d-flex text-center">
                                <div class="flex-grow-1 ms-3">
                                    <h4 class="fw-bold fs-4 text-black">{{$contest['contest_name']}}</h4>

                                    <p class="text-dark fw-bold mb-1">
                                        {{__('main.start_contest')}} {{$contest['start']}},
                                        {{__('main.end_contest')}}: {{$contest['end']}}
                                    </p>

                                    <div class="row mt-2">
                                        @if($contest['winners'][0]['user_id'] != null)


                                            @foreach($contest['winners'] as $winner)
                                                <div class="col-md-12 mx-auto">
{{--                                                    <a href="{{route('profile', [$winner['username']])}}">--}}
{{--                                                        <img src="{{asset('storage/image/' . $winner['user_image']['image_path'])}}" class="img-fluid img-thumbnail profile-photo" alt="">--}}
{{--                                                    </a>--}}
                                                    <p class="fs-5">
                                                        <span class="fw-bold">{{__('main.total_vote')}}: <span class="fw-bold">{{$winner['total_votes']}}</span>
                                                    </p>
                                                    @if($winner['rank'] > 0 && $winner['rank'] < 4 && $winner['total_votes'] > 0)
{{--                                                        <p>--}}
{{--                                                            <span class="badge bg-warning fw-bold fs-6">--}}
{{--                                                                <i class="fa-solid fa-trophy"></i>--}}
{{--                                                                You Won--}}
{{--                                                            </span>--}}
{{--                                                        </p>--}}
                                                    @if($contest['bank_status'] == null)
                                                        <p class="fw-semibold mt-2">
                                                            @php
                                                                $winnerRank = $winner['rank'] ?? '';
                                                                $winnerContest = $contest['contest_name'] ?? '';
                                                                $winnerPrize = $winner['prize'] ?? '';
                                                                $renderedColumnValue = str_replace('[rank]', $winnerRank, $text_win->value);
                                                                $renderedColumnValue = str_replace('[contest_name]', $winnerContest, $renderedColumnValue);
                                                                $renderedColumnValue = str_replace('[prize]', 'R$'.$winnerPrize, $renderedColumnValue);
                                                            @endphp
                                                            {!! $renderedColumnValue !!}

                                                        </p>
                                                        @else
                                                        <p class="fw-semibold mt-2">
                                                            @php
                                                                $winnerRank = $winner['rank'] ?? '';
                                                                $winnerContest = $contest['contest_name'] ?? '';
                                                                $winnerPrize = $winner['prize'] ?? '';
                                                                $renderedColumnValue = str_replace('[rank]', $winnerRank, $text_prize_sent->value);
                                                                $renderedColumnValue = str_replace('[contest_name]', $winnerContest, $renderedColumnValue);
                                                                $renderedColumnValue = str_replace('[prize]', 'R$'.$winnerPrize, $renderedColumnValue);
                                                            @endphp
                                                            {!! $renderedColumnValue !!}

                                                        </p>
                                                        @endif
                                                    @else
                                                        <p class="mt-2 fw-semibold">
                                                            @php
                                                                $winnerRank = $winner['total_votes'] ?? '';
                                                                $winnerContest = $contest['contest_name'] ?? '';
                                                                $renderedColumnValue = str_replace('[total_votes]', $winnerRank, $text_lose->value);
                                                                $renderedColumnValue = str_replace('[contest_name]', $winnerContest, $renderedColumnValue);
                                                            @endphp
                                                            {!! $renderedColumnValue !!}
                                                        </p>
                                                        <p><i class="fa-regular fa-face-frown fs-1"></i></p>
                                                    @endif
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

@endsection
