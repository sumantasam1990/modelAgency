<li class="breadcrumb-item">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#userModalhjhhj" >
        About
    </button>

    <div class="modal fade" id="userModalhjhhj" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">About</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="userInfo">
                        @if ($data)
                            <p>{{ $data->about }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</li>
