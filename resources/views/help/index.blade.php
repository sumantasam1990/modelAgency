@extends('header')
@section('content')
<div class="row">
    <h4 class="fw-bold fs-4 mb-3">Help</h4>
    <div class="col-md-6 sec-box">

        <div class="accordion accordion-flush" id="accordionFlushExample">
            @foreach($data as $d)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingOne-{{$d->id}}">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne-{{$d->id}}" aria-expanded="false" aria-controls="flush-collapseOne-{{$d->id}}">
                            {{$d->question}}
                        </button>
                    </h2>
                    <div id="flush-collapseOne-{{$d->id}}" class="accordion-collapse collapse" aria-labelledby="flush-headingOne-{{$d->id}}" >
                        <div class="accordion-body">
                            {{$d->answer}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
