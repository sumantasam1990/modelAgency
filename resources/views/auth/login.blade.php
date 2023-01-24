@include('header')
<div class="container-fluid h-100">
    <div class="row h-100">
        <div class="col-md-8 hero">

        </div>
        <div class="col-md-4 box h-100">
            @include('alert')
            <h1 class="fs-2 fw-bold text-capitalize">Access your model panel</h1>
            <form action="{{route('login.post')}}" method="post">
                @csrf
                <div class="form-group mb-3">
                    <label>Email*</label>
                    <input type="email" name="email" class="form-control" placeholder="eg. john@example.com">
                </div>
                <div class="form-group">
                    <label>Password*</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="d-grid gap-2 mx-auto col-8 mt-4">
                    <button type="submit" class="btn btn-dark">Sign In</button>
                    <a class="btn btn-light text-capitalize mt-4" href="{{route('register')}}">Create your account</a>
                </div>

            </form>
        </div>
    </div>
</div>
@include('footer')
