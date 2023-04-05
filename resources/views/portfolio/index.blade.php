@extends('header')
@section('content')
    <div class="row">
        <div class="col-12">
            <h4 class="fw-bold fs-4 mb-2">Photos*</h4>
        </div>
        <div class="col-md-6">
            <div class="sec-box">
                <p class="text-black-50 mb-1 fs-6">* Max 12 photos you can upload. Only JPEG, JPG and PNG format are accepted.</p>
                <p class="fw-bold text-black mb-3">* Try to upload 300X300 center photo for better ranking and visibility.</p>
                <form action="{{route('upload.image')}}" method="post" enctype="multipart/form-data">
                    @csrf

                    <input type="file" name="image" id="fileInput" class="form-control d-none" onchange="showPreview(event)">
                    <div class="d-grid gap-2 mx-auto col-sm-10 mt-3">
                        <button type="button" onclick="document.getElementById('fileInput').click()" href="" class="btn btn-secondary btn-lg"><i class="fa-solid fa-camera"></i> &nbsp; Add photo</button>
                    </div>

                    <h4 class="fs-6 fw-bold text-black-50 p-1 text-center preview-title" id="preview-title" style="display: none;">Preview</h4>
                    <div class="preview mx-auto" id="preview" style="display: none;">
                        <img id="file-preview">
                    </div>

                    <div class="d-grid gap-2 mx-auto col-sm-10 mt-3">
                        <button type="submit" class="btn btn-dark btn-lg"><i class="fa-solid fa-cloud-arrow-up"></i> &nbsp; Upload</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-6">
            <div class="uploaded-images mb-5">
                <div class="row">

                    @foreach($data->portfolios as $image)
                        <div class="col-md-6 col-6 col-sm-6 col-xl-6 col-xxl-6 mb-2">
                            <img src="{{asset('storage/image/' . $image->file_name . '.' . $image->ext)}}" class="img-fluid img-thumbnail img grid-photo" alt="">
                            <div class="d-grid gap-2 col-12 mt-2">
                                @if($image->profile_photo == 0)
                                    <a href="{{route('mark.profile.photo', [$image->id])}}" class="btn btn-dark btn-sm">Mark it profile photo</a>
                                @endif

                                @if($image->contest_photo == 0)
                                    <a href="{{route('mark.contest.photo', [$image->id, $contest_id ?? 0])}}" class="btn btn-light btn-sm">Mark it contest photo</a>
                                @endif

                                @if(count($data->portfolios) > 1 && $image->contest_photo === 0 && $image->profile_photo === 0)
                                    <a onclick="return confirm('Are you sure?');" href="{{route('delete.photo', [$image->id])}}" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                @endif

                                @if($image->contest_photo === 1 && $image->profile_photo === 1)
                                    <p class="fw-bold text-success text-center mb-1">Default</p>
                                    <p class="fst-italic fw-semibold text-dark fs-6">Mark another photo as profile and contest photo then you can delete the default photo.</p>
                                @endif

                            </div>
                        </div>

                    @endforeach
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
    // document.getElementById('fileInput').addEventListener('change', function() {
    //     var file = this.files[0];
    //     // Do something with the selected file
    // });

    function showPreview(event){
        if(event.target.files.length > 0){
            var src = URL.createObjectURL(event.target.files[0]);
            var preview = document.getElementById("file-preview");
            preview.src = src;
            document.getElementById("preview").style.display = "block";
            document.getElementById("preview-title").style.display = "block";
            preview.style.display = "block";
        }
    }
</script>
