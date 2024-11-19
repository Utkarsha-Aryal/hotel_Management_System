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
                            <td>{{ $TeamMemberDetails->name }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Email</th>
                            <td>{{ $TeamMemberDetails->email }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Order</th>
                            <td>{{ $TeamMemberDetails->order_number }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Designation</th>
                            <td>{{ $TeamMemberDetails->designation }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Short Bio</th>
                            <td>{{ $TeamMemberDetails->short_bio }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Experience</th>
                            <td>{{ $TeamMemberDetails->experience }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Phone number</th>
                            <td>{{ $TeamMemberDetails->phone_number }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Image</th>
                            <?php
                            $image = asset('images/no-image.jpg');
                            if (!empty($TeamMemberDetails->photo)) {
                                $photo = asset('storage/community/' . $TeamMemberDetails->photo);
                            }
                            ?>
                            <td><img src="{{ $photo }}" height="100px" alt="Image">
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
