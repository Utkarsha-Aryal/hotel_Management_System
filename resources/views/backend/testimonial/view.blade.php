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
                            <th scope="row">Name</th>
                            <td>{{ $testimonialDetails->name }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Designation</th>
                            <td>{{ $testimonialDetails->designation }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Image</th>
                            <?php
                            $image = asset('images/no-image.jpg');
                            if (!empty($testimonialDetails->image)) {
                                $image = asset('storage/testimonial/' . $testimonialDetails->image);
                            }
                            ?>
                            <td><img src="{{ $image }}" height="100px" alt="Image">
                        </tr>
                        <tr>
                            <th scope="row">Review</th>
                            <td>{{ $testimonialDetails->review }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Rating</th>
                            <td>{{ $testimonialDetails->rating }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
