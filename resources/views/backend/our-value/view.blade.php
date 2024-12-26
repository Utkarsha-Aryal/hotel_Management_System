@if ($type == 'error')
<div class="modal-header">
    <h1 class="modal-title fs-5" id="staticBackdropLabel">
        Error
    </h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    {{ $message }}
</div>
@else
<div class="modal-header">
    <h5 class="modal-title">View Info</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    <em class="icon ni ni-cross"></em>
    </a>
</div>
<div class="modal-body">
    <div class="card-inner">
        <div class="nk-block">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Body</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">Full Name</th>
                        <td>{{$valueDetails->title}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Order</th>
                        <td>{{$valueDetails->order}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Details</th>
                        <td>{{strip_tags($valueDetails->details)}}</td>
                    </tr>

                    <tr>
                        <th scope="row">Meta Keywords</th>
                        <td>{{strip_tags($valueDetails->meta_keywords)}}</td>
                    </tr>

                    <tr>
                        <th scope="row">Meta Description</th>
                        <td>{{strip_tags($valueDetails->meta_description)}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
