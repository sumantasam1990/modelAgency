@extends('header')
@section('content')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="sec-box">
                <h4 class="fw-bold fs-4 mb-1">Photos</h4>
                <p class="text-black-50 mb-3 fs-6">Max 12 photos you can upload. Only JPEG, JPG and PNG format are accepted.</p>
                <form action="{{route('upload.image')}}" method="post" enctype="multipart/form-data">
                    @csrf

                    <input type="file" name="image" class="form-control" onchange="showPreview(event)">
                    <small class="fw-bold text-black-50">* Try to upload 300X300 photo for better ranking.</small>

                    <h4 class="fs-6 fw-bold text-black-50 p-1 text-center">Preview</h4>
                    <div class="preview mx-auto">
                        <img id="file-preview">
                    </div>

                    <div class="d-grid gap-2 mx-auto col-4 mt-3">
                        <button type="submit" class="btn btn-dark">Upload Photo</button>
                    </div>
                </form>



                <div class="uploaded-images mt-5 mb-5">
                    <div class="row">
                        @foreach($data->portfolios as $image)
                        <div class="col-md-3 mb-2">
                            <img src="{{asset('storage/image/' . $image->file_name . '.' . $image->ext)}}" class="img-fluid img-thumbnail img" alt="">
                            <div class="d-grid gap-2 col-12 mt-2">
                                @if($image->profile_photo == 0)
                                    <a href="{{route('mark.profile.photo', [$image->id])}}" class="btn btn-dark">Mark it profile photo</a>
                                @endif

                                @if($image->contest_photo == 0)
                                    <a href="{{route('mark.contest.photo', [$image->id])}}" class="btn btn-light">Mark it contest photo</a>
                                @endif
                                <a onclick="return confirm('Are you sure?');" href="{{route('delete.photo', [$image->id])}}" class="btn btn-danger ">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
{{--        <div class="col-md-4">--}}
{{--            <div class="sec-box">--}}
{{--                <h4 class="fw-bold fs-4">Links</h4>--}}
{{--                <form action="{{route('links.post')}}" method="post">--}}
{{--                    @csrf--}}

{{--                    <div class="row mt-3">--}}
{{--                        <label class="fw-bold">Jobs</label>--}}
{{--                        <div class="col-md-4">--}}
{{--                            <input type="text" name="job_title" placeholder="Title" class="form-control" value="{{$links_jobs[0]->title ?? ''}}">--}}
{{--                        </div>--}}
{{--                        <div class="col-md-8">--}}
{{--                            <input type="text" placeholder="URL" class="form-control" name="job_url" value="{{$links_jobs[0]->url ?? ''}}">--}}
{{--                        </div>--}}

{{--                        <label class="fw-bold mt-3">Awards</label>--}}
{{--                        <div class="col-md-4">--}}
{{--                            <input type="text" placeholder="Title" class="form-control" name="award_title" value="{{$links_awards[0]->title ?? ''}}">--}}
{{--                        </div>--}}
{{--                        <div class="col-md-8">--}}
{{--                            <input type="text" placeholder="URL" class="form-control" name="award_url" value="{{$links_awards[0]->url ?? ''}}">--}}
{{--                        </div>--}}

{{--                        <label class="fw-bold mt-3">Dance</label>--}}
{{--                        <div class="col-md-4">--}}
{{--                            <input type="text" placeholder="Title" class="form-control" name="dance_title" value="{{$links_dance[0]->title ?? ''}}">--}}
{{--                        </div>--}}
{{--                        <div class="col-md-8">--}}
{{--                            <input type="text" placeholder="URL" class="form-control" name="dance_url" value="{{$links_dance[0]->url ?? ''}}">--}}
{{--                        </div>--}}

{{--                        <label class="fw-bold mt-3">Music</label>--}}
{{--                        <div class="col-md-4">--}}
{{--                            <input type="text" placeholder="Title" class="form-control" name="music_title" value="{{$links_music[0]->title ?? ''}}">--}}
{{--                        </div>--}}
{{--                        <div class="col-md-8">--}}
{{--                            <input type="text" placeholder="URL" class="form-control" name="music_url" value="{{$links_music[0]->url ?? ''}}">--}}
{{--                        </div>--}}

{{--                        <label class="fw-bold mt-3">Dramatics</label>--}}
{{--                        <div class="col-md-4">--}}
{{--                            <input type="text" placeholder="Title" class="form-control" name="drama_title" value="{{$links_drama[0]->title ?? ''}}">--}}
{{--                        </div>--}}
{{--                        <div class="col-md-8">--}}
{{--                            <input type="text" placeholder="URL" class="form-control" name="drama_url" value="{{$links_drama[0]->url ?? ''}}">--}}
{{--                        </div>--}}

{{--                        <label class="fw-bold mt-3">Sports</label>--}}
{{--                        <div class="col-md-4">--}}
{{--                            <input type="text" placeholder="Title" class="form-control" name="sport_title" value="{{$links_sport[0]->title ?? ''}}">--}}
{{--                        </div>--}}
{{--                        <div class="col-md-8">--}}
{{--                            <input type="text" placeholder="URL" class="form-control" name="sport_url" value="{{$links_sport[0]->url ?? ''}}">--}}
{{--                        </div>--}}

{{--                        <div class="mt-4 d-grid gap-2 mx-auto col-4">--}}
{{--                            <button type="submit" class="btn btn-dark">Save</button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </form>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="col-md-4">--}}
{{--            <div class="sec-box">--}}
{{--                <h4 class="fw-bold fs-4">Interests</h4>--}}
{{--                <form action="{{route('add.interest')}}" method="post">--}}
{{--                    @csrf--}}

{{--                    <label>Interests*</label>--}}
{{--                    <textarea class="form-control" rows="8" placeholder="Write your interest here..." name="interest">{{$data->interest->content ?? ''}}</textarea>--}}

{{--                    <div class="mt-4 d-grid gap-2 mx-auto col-4">--}}
{{--                        <button type="submit" class="btn btn-dark">Save</button>--}}
{{--                    </div>--}}
{{--                </form>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>

@endsection

<script>
    function showPreview(event){
        if(event.target.files.length > 0){
            var src = URL.createObjectURL(event.target.files[0]);
            var preview = document.getElementById("file-preview");
            preview.src = src;
            preview.style.display = "block";
        }
    }
</script>
