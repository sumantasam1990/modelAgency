<div>
    <div class="mb-2">
        <h4 class="fw-bold text-black-50 fs-6 mt-2">{{__('main.edit_profile_state')}}</h4>
        <select class="form-control" name="state" wire:model="selectedState">
            <option value="">{{__('main.edit_profile_select')}}</option>
            @foreach($states as $state)
                <option value="{{$state->id}}">{{$state->nome}}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-2">
        <h4 class="fw-bold text-black-50 fs-6 mt-2">{{__('main.edit_profile_city')}}</h4>
        <select class="form-control" name="city[]" {{$multiple == 'true' ? 'multiple' : ''}} wire:model="selectedCity">
            @foreach ($cities as $city)
                <option value="{{ $city->id }}">{{ $city->nome }}</option>
            @endforeach
        </select>
    </div>
</div>
