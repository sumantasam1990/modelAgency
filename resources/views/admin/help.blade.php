@extends('admin.header')
@section('content')

    <div class="row">
        <div class="col-md-4">
            <h4 class="fw-bold fs-4 mb-2">Help</h4>
            <form action="{{route('admin.faq.post')}}" method="post">
                @csrf

                <div class="mb-2">
                    <label class="mb-2">Title</label>
                    <input type="text" class="form-control" placeholder="Write your title" name="q">
                </div>
                <div class="mb-2 mt-3">
                    <label class="mb-2">Description</label>
                    <textarea rows="6" class="form-control" placeholder="Write the description..." name="a"></textarea>
                </div>

                <div class="d-grid gap-2 mx-auto col-12 mt-3">
                    <button type="submit" class="btn btn-dark">Save</button>
                </div>
            </form>
        </div>
        <div class="col-md-8">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr class="table-dark">
                        <th>Panel</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($faqs as $faq)
                        <tr>
                            <td>{{$faq->panel}}</td>
                            <td>{{$faq->question}}</td>
                            <td>{{$faq->answer}}</td>
                            <td>
                                <a onclick="return confirm('Are you sure?');" class="btn btn-outline-danger btn-sm" href="{{route('admin.delete.faq', [$faq->id])}}"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div>
                {{$faqs->links()}}
            </div>
        </div>
    </div>

@endsection
