<div>
    <li class="breadcrumb-item">

        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#configModal">
            Config
        </button>


        <div class="modal fade" id="configModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="userModalLabel">Config</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="userInfo">
                            @if ($data)
                                <p class="mb-1">Time of registration: <span class="fw-bold">{{ $data['user_registration'] }}</span></p>
                                <p class="mb-1">Time of subscription: <span class="fw-bold">{{ $data['user_registration'] }}</span></p>
                                <p class="mb-1">Total Contests: <span class="fw-bold">{{ $data['contest_total'] }}</p>
                                <p class="mb-1">Total contest won: <span class="fw-bold">{{ $data['contest_won'] }}</p>

                                <div class="d-grid gap-2 col-12 mt-3">
                                    <a onclick="return confirm('Are you sure?');" href="{{route('free.subscription', [$userId])}}" class="btn btn-dark btn-lg"><i class="fa-solid fa-gift"></i> &nbsp; Free Subscription</a>
                                </div>
                            @else
                                <p>Loading...</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </li>
</div>
