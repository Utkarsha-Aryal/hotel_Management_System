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
                            <th scope="row">Order</th>
                            <td>{{ $whyChooseUsDetails->order_number }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Title</th>
                            <td>{{ $whyChooseUsDetails->title }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Description</th>
                            <td>{{ $whyChooseUsDetails->description }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Affordability</th>
                            <td>{{ $whyChooseUsDetails->affordability }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Inspiring</th>
                            <td>{{ $whyChooseUsDetails->inspiring }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Icon</th>
                            <?php
                            $photo = asset('images/no-image.jpg');
                            if (!empty($whyChooseUsDetails->icon)) {
                                $photo = asset('storage/why-to-choose-us/' . $whyChooseUsDetails->icon);
                            }
                            ?>
                            <td><img src="{{ $photo }}" height="100px" alt="Image">
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Close View </button>
    </div>
@endif
