@include('header')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" style="margin: 0; padding: 0;">
            <div class="left-sidebar">
                <h2 class="text-capitalize fs-5 fw-bold text-light" style="margin-left: 20px;">Maria Doe</h2>
                <p style="margin-top: -5px;">
                    <a class=" fs-6 fw-bold text-decoration-none text-capitalize" href="" style="color: #d2d2d2; margin-left: 20px;">My profile &nbsp; <i class="fa-solid fa-arrow-right"></i></a>
                </p>

                <ul class="mt-5">
                    <li><a href=""><i class="fa-solid fa-heart"></i> &nbsp; Contest</a> </li>
                    <li class="{{ (request()->is('model/portfolio')) ? 'active' : '' }}"><a href=""><i class="fa-solid fa-camera-retro"></i> &nbsp; Portfolio</a> </li>
                    <li><a href=""><i class="fa-solid fa-person-circle-question"></i> &nbsp; Help</a> </li>
                    <li><a href=""><i class="fa-solid fa-credit-card"></i> &nbsp; Subscription</a> </li>
                    @if(Auth::check())
                    <li><a href="{{route('logout')}}"><i class="fa-solid fa-arrow-right-to-bracket"></i> &nbsp; Sign Out</a> </li>
                    @else
                        <li class="active"><a href="{{route('register')}}"><i class="fa-solid fa-user-plus"></i> &nbsp; Register</a> </li>
                        <li><a href="{{route('login')}}"><i class="fa-solid fa-right-to-bracket"></i> &nbsp; Sign In</a> </li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="col-md-10">
            <div class="right-sidebar mt-5">
                @include('alert')
                <div class="row">
                    <div class="col-md-4">
                        <div class="sec-box">
                            <h4 class="fw-bold fs-4 mb-1">Photos</h4>
                            <p class="text-black-50 mb-3 fs-6">Max 12 photos you can upload. Only JPEG, JPG and PNG format are accepted.</p>
                            <form action="{{route('upload.image')}}" method="post" enctype="multipart/form-data">
                                @csrf

                                <input type="file" name="image" class="form-control">

                                <div class="d-grid gap-2 mx-auto col-4 mt-3">
                                    <button type="submit" class="btn btn-dark">Upload Photo</button>
                                </div>
                            </form>

                            <div class="uploaded-images mt-5">
                                <div class="row">
                                    @foreach($data->portfolios as $image)
                                    <div class="col-md-3 mb-2">
                                        <img src="{{asset('storage/image/' . $image->file_name . '.' . $image->ext)}}" class="img-fluid img-thumbnail img" alt="">
                                        <div class="d-grid gap-2 col-12 mt-2">
                                            <a onclick="return confirm('Are you sure?');" href="{{route('delete.photo', [$image->id])}}" class="btn btn-secondary btn-sm">
                                                <i class="fas fa-trash"></i> Delete
                                            </a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="sec-box">
                            <h4 class="fw-bold fs-4">Links</h4>
                            <form action="{{route('links.post')}}" method="post">
                                @csrf

                                <div class="row mt-3">
                                    <label class="fw-bold">Jobs</label>
                                    <div class="col-md-4">
                                        <input type="text" name="job_title" placeholder="Title" class="form-control" value="{{$links_jobs[0]->title ?? ''}}">
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" placeholder="URL" class="form-control" name="job_url" value="{{$links_jobs[0]->url ?? ''}}">
                                    </div>

                                    <label class="fw-bold mt-3">Awards</label>
                                    <div class="col-md-4">
                                        <input type="text" placeholder="Title" class="form-control" name="award_title" value="{{$links_awards[0]->title ?? ''}}">
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" placeholder="URL" class="form-control" name="award_url" value="{{$links_awards[0]->url ?? ''}}">
                                    </div>

                                    <label class="fw-bold mt-3">Dance</label>
                                    <div class="col-md-4">
                                        <input type="text" placeholder="Title" class="form-control" name="dance_title" value="{{$links_dance[0]->title ?? ''}}">
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" placeholder="URL" class="form-control" name="dance_url" value="{{$links_dance[0]->url ?? ''}}">
                                    </div>

                                    <label class="fw-bold mt-3">Music</label>
                                    <div class="col-md-4">
                                        <input type="text" placeholder="Title" class="form-control" name="music_title" value="{{$links_music[0]->title ?? ''}}">
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" placeholder="URL" class="form-control" name="music_url" value="{{$links_music[0]->url ?? ''}}">
                                    </div>

                                    <label class="fw-bold mt-3">Dramatics</label>
                                    <div class="col-md-4">
                                        <input type="text" placeholder="Title" class="form-control" name="drama_title" value="{{$links_drama[0]->title ?? ''}}">
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" placeholder="URL" class="form-control" name="drama_url" value="{{$links_drama[0]->url ?? ''}}">
                                    </div>

                                    <label class="fw-bold mt-3">Sports</label>
                                    <div class="col-md-4">
                                        <input type="text" placeholder="Title" class="form-control" name="sport_title" value="{{$links_sport[0]->title ?? ''}}">
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" placeholder="URL" class="form-control" name="sport_url" value="{{$links_sport[0]->url ?? ''}}">
                                    </div>

                                    <div class="mt-4 d-grid gap-2 mx-auto col-4">
                                        <button type="submit" class="btn btn-dark">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="sec-box">
                            <h4 class="fw-bold fs-4">Interests</h4>
                            <form action="{{route('add.interest')}}" method="post">
                                @csrf

                                <label>Interests*</label>
                                <textarea class="form-control" rows="8" placeholder="Write your interest here..." name="interest">{{$data->interest->content ?? ''}}</textarea>

                                <div class="mt-4 d-grid gap-2 mx-auto col-4">
                                    <button type="submit" class="btn btn-dark">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
@include('footer')
