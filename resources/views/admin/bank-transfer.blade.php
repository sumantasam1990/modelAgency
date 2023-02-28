@extends('admin.header')
@section('content')
<div class="row">
    <div class="col-md-5 mx-auto">
        <div class="sec-box border">
            <h4 class="fs-4 fw-bold mb-1">Send Money</h4>
            <p class="fw-bold text-black-50">To: {{$data[0]->user->name}}</p>
            <form action="{{route('bank.transfer.post')}}" method="post">
                @csrf
                <input type="hidden" value="{{$contest_id}}" name="_contest">
                <input type="hidden" value="{{$id}}" name="_user">
                <input type="hidden" value="{{$prize}}" name="_prize">

                <label class="mb-2">Choose a payment method*</label>
                <select required class="form-control" name="_bank">
                    <option value="">Choose</option>
                    <option value="bank">Bank</option>
                    <option value="pix">Pix</option>
                </select>

                <div class="d-grid gap-2 mx-auto col-8 mt-3">
                    <button type="submit" class="btn btn-dark btn-lg">Send money</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
