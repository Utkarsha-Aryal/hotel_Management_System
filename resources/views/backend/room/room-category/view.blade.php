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
                            <th scope="row">Room Category</th>
                            <td>{{ $roomcategoryDetails->category }}</td>
                        </tr>
                        <tr>
                            <th scope="row">price</th>
                            <td>{{ $roomcategoryDetails->price }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Image</th>
                            <?php
                            $image = asset('images/no-image.jpg');
                            if (!empty($roomcategoryDetails->image)) {
                                $image = asset('storage/roomCategory/' . $roomcategoryDetails->image);
                            }
                            ?>
                            <td><img src="{{ $image }}" height="200px" alt="Image">
                        </tr>
                       
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
