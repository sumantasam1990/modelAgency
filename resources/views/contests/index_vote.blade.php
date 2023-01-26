@extends('header')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="sec-box text-center">
                <h4 class="fw-bold fs-4 mb-1">Vote</h4>
                <p class="text-black-50 mb-3 fs-6">Click on the photo of the model to register your vote.</p>

                <livewire:vote />

            </div>
        </div>
    </div>

@endsection
