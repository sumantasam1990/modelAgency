<div>
    @if(count($data) === 0)
        <p class="fw-bold">
            {{__('main.vote_no_contest')}}
        </p>
        <p>
            <i class="fa-solid fa-check-to-slot fs-1"></i>
        </p>
    @endif
    @foreach($data as $d)
        <div vote-anim class="voting mt-2">
            <h4 class="fw-bold fs-3">
                {{$d->title}}
            </h4>

            <div class="voting-models mt-4">

                @foreach($data[0]->users as $model)
                    <div class="vote-container" style="pointer-events: {{$disabled ? 'none' : 'bounding-box'}}">
                        <img onclick="voteup({{$model->portfolio->id}})" style="cursor: pointer;" wire:click.stop.debounce.250ms="voteup({{$d->id}},{{$model->id}})" src="{{asset('storage/image/' . ($model->pivot->contest_photo == null ? $model->portfolio->file_name . '.' . $model->portfolio->ext : $model->pivot->contest_photo) )}}" class="img-fluid img-thumbnail image" alt="">
                        <div class="overlay" id="overlay_{{$model->portfolio->id}}" style="display: none;">
                            <a href="#" class="icon" title="User Profile">
                                <i class="fa-solid fa-heart"></i>
                            </a>
                        </div>
                        <h2 class="fw-bold fs-5 text-secondary mt-2 mb-2 text-center text-capitalize">{{$model->name}}</h2>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
