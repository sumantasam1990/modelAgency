@extends('header')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="sec-box text-center">
                <h4 class="fw-bold fs-4 mb-1">{{__('main.vote')}}</h4>
                <p class="text-black-50 mb-3 fs-6">{{__('main.vote_click_photo')}}</p>

                <livewire:vote />

            </div>
        </div>
    </div>

@endsection
