<div>
    <div class="mb-2">
        <h4 class="fw-bold text-black-50 fs-6 mt-2">State</h4>
        <select class="form-control" name="state" wire:model="selectedState">
            <option value="">Select State</option>
            @foreach($states as $state)
                <option value="{{$state->id}}">{{$state->nome}}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-2">
        <h4 class="fw-bold text-black-50 fs-6 mt-2">City</h4>
        <select class="form-control" name="city[]" multiple wire:model="selectedCity">
            @foreach ($cities as $city)
                <option value="{{ $city->id }}">{{ $city->nome }}</option>
            @endforeach
        </select>
    </div>
</div>
