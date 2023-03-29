@extends('header')
@section('content')

    <div class="row">
        <div class="col-md-6">
            <form action="{{route('about.me.post')}}" method="post">
                @csrf

                <label class="fw-semibold">About Me</label>
                <textarea rows="6" name="about" class="form-control" placeholder="Write about yourself...">{{auth()->user()->about}}</textarea>
                <div class="d-grid gap-2 col-4 mt-3 ">
                    <button type="submit" class="btn btn-dark">Save</button>
                </div>
            </form>
        </div>
    </div>

@endsection
