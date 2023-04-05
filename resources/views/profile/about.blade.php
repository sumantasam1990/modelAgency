@extends('header')
@section('content')

    <div class="row">
        <div class="col-md-6">
            <form action="{{route('about.me.post')}}" method="post">
                @csrf

                <label class="fw-semibold">{{__('main.About_me')}}</label>
                <textarea rows="6" name="about" class="form-control" placeholder="{{__('main.Write_about_yourself')}}">{{auth()->user()->about}}</textarea>
                <div class="d-grid gap-2 col-4 mt-3 ">
                    <button type="submit" class="btn btn-dark">{{__('main.Save')}}</button>
                </div>
            </form>
        </div>
    </div>

@endsection
