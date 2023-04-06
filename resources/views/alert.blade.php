<div class="row">
    <div class="col-10 mx-auto">
        @if (session('msg'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
{{--                <h4 class="alert-heading"><i class="bi bi-check2-circle"></i> Success!</h4>--}}
                <strong>{!! session('msg') !!}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('err'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
{{--                <h4 class="alert-heading"><i class="bi bi-info-circle"></i> Error!</h4>--}}
                <strong>{{ session('err') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>
</div>

@auth()
@if(Auth::user()->subscribed === 0 && Auth::user()->email != 'admin@admin.com')
    <div class="row">
        <div class="col-12">
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <h4 class="alert-heading fw-bold"><i class="bi bi-check2-circle"></i> PREMIUM ACCOUNT!</h4>
                <h5 class="fs-5 fw-semibold">Go to premium account only for R$100/month. You can participate to contest and get chance to win prize.</h5>
                <a class="btn btn-info mt-2 fw-bold text-uppercase" href="{{route('subscription.now')}}">{{__('main.subscribe')}}</a>
            </div>
        </div>
    </div>
@endif
@endauth
