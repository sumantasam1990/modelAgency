@extends('header')
@section('content')

    <div class="row mb-4">
        <div class="col-md-8">
            <h4 class="fw-bold fs-4 mb-1">My Results</h4>
            <p class="text-black-50 mb-3 fs-6">Results of contests you participated in..</p>

            <div class="row mt-3">
                <div class="col-md-10">
                    @if(count($data) === 0)
                        <p class="fw-bold">
                            No contest found.
                        </p>
                    @endif
                    @foreach($data as $contest)
                        <div class="sec-box mb-3">
                            <div class="d-flex text-center">
                                <div class="flex-grow-1 ms-3">
                                    <h4 class="fw-bold fs-4 text-black">{{$contest['contest_name']}} - <span class="text-black-50">{{$contest['start']}}</span></h4>

                                    <p class="text-danger fw-bold">
                                        Contest expiry: {{$contest['end']}}
                                    </p>

                                    <div class="row mt-4">
                                        @if($contest['winners'][0]['userId'] != null)
                                            <hr />

                                            @foreach($contest['winners'] as $winner)
                                                <div class="col-md-12 mx-auto">
                                                    <a href="{{route('profile', [$winner['username']])}}">
                                                        <img src="{{asset('storage/image/' . $winner['user_image']['image_path'])}}" class="img-fluid img-thumbnail profile-photo" alt="">
                                                    </a>
                                                    <p class="mt-3">
                                                        <span class="fw-bold">{{$winner['user_name']}}</span>  <br> Total votes: <span class="fw-bold">{{$winner['total_votes']}}</span>
                                                    </p>
                                                    @if($contest['winner'] === "Won")
                                                        <p>
                                                            <span class="badge bg-warning fw-bold fs-6">
                                                                <i class="fa-solid fa-trophy"></i>
                                                                You {{$contest['winner']}}
                                                            </span>
                                                        </p>
                                                    @if(!$contest['transfer'])
                                                        <p class="fw-semibold mt-2">
                                                            Congratulations on your <span class="fw-bold">{{$contest['rank'][0]['position'] ?? ''}}</span> place in the <span class="fw-bold">{{$contest['contest_name']}}</span> ! We would like fo inform
                                                            you that the prize payment will be sent to you shortly, through PagSeguro or PIX.
                                                            Subscription We will send you a message to confirm the payment has been sent. congratulation message
                                                            In a few days, we will publish your photo on our social networks, informing you of
                                                            Help your victory! It is important that you leave a thank you comment to your voters,
                                                            showing your gratitude for their contribution to your victory. We hope fo see you again in future editions!
                                                        </p>
                                                        @else
                                                        <p class="fw-semibold mt-2">
                                                            We inform you that the prize for <span class="fw-bold">{{$contest['rank'][0]['position'] ?? ''}}</span> place in <span class="fw-bold">{{$contest['contest_name']}}</span> has been sent to your
                                                            My Contests PagSeguro or PIX account. Please check your account to confirm receipt. prize sent message
                                                            Congratulations again on the award and achievement!
                                                        </p>
                                                        @endif
                                                    @endif
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="mt-2 fw-semibold">
                                                We would like to let you know that you received <span class="fw-bold">{{(int)$contest['total_votes']}}</span> votes in <span class="fw-bold">{{$contest['contest_name']}}</span> . Congratulations on participating and showing your talent on our platform! Thanks again for your participation and we wish you success in your next competition!
                                            </p>
                                            <p><i class="fa-regular fa-face-frown fs-1"></i></p>
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
