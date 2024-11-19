@if ($type == 'error')
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Error</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        {{ $message }}
    </div>
@else
    <div class="modal-header">
        <h5 class="modal-title">
            View 
            @if (!empty($postDetails->category))
                " {{ ucfirst($postDetails->category) }} "
            @endif
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="card-inner">
            <div class="nk-block">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Title</th>
                            <td>{{ $postDetails->title }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Order</th>
                            <td>{{ $postDetails->order_number }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Category</th>
                            <td>{{ $postDetails->roomCategory->category }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Room Number</th>
                            <td>{{ $postDetails->room_no }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Price</th>
                            <td>{{$postDetails->roomCategory->price}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Category Image</th>
                            <?php
                            $photo = asset('images/no-image.jpg');
                            if(!empty($postDetails->roomCategory->image)){
                                $photo = asset('storage/roomCategory/' . $postDetails->roomCategory->image);
                            }
                            ?>
                            <td><img src="{{ $photo }}" height="100px" alt="Image">
                        </tr>
                        <tr>
                            <th scope="row">Max Occupancy</th>
                            <td>{{ $postDetails->max_occupancy }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Featured Image</th>
                            <td>
                                @if (!empty($decodedFeatureImages))
                                    @foreach ($decodedFeatureImages as $featureImage)
                                        <img src="{{ asset('/storage/ourroom/' . $featureImage) }}" class="_feature-image imageThumb" alt="Feature Image" height="100px" width="100px">
                                    @endforeach
                                @else 
                                <img src="{{  asset('images/no-image.jpg') }}" height="100px" alt="Image">
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Overview</th>
                            <td>{!! $postDetails->details !!}</td>
                        </tr>
                        <!-- Room Features with Readonly Radio Buttons -->
                        <tr>
                            <th scope="row">WiFi</th>
                            <td>
                                <input type="radio" name="wifi" value="Y" {{ $postDetails->wifi == 'Y' ? 'checked' : '' }} disabled> Yes
                                <input type="radio" name="wifi" value="N" {{ $postDetails->wifi == 'N' ? 'checked' : '' }} disabled> No
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">AC</th>
                            <td>
                                <input type="radio" name="AC" value="Y" {{ $postDetails->AC == 'Y' ? 'checked' : '' }} disabled> Yes
                                <input type="radio" name="AC" value="N" {{ $postDetails->AC == 'N' ? 'checked' : '' }} disabled> No
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">TV</th>
                            <td>
                                <input type="radio" name="TV" value="Y" {{ $postDetails->TV == 'Y' ? 'checked' : '' }} disabled> Yes
                                <input type="radio" name="TV" value="N" {{ $postDetails->TV == 'N' ? 'checked' : '' }} disabled> No
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Minibar</th>
                            <td>
                                <input type="radio" name="minibar" value="Y" {{ $postDetails->minibar == 'Y' ? 'checked' : '' }} disabled> Yes
                                <input type="radio" name="minibar" value="N" {{ $postDetails->minibar == 'N' ? 'checked' : '' }} disabled> No
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Room Service</th>
                            <td>
                                <input type="radio" name="room_service" value="Y" {{ $postDetails->room_service == 'Y' ? 'checked' : '' }} disabled> Yes
                                <input type="radio" name="room_service" value="N" {{ $postDetails->room_service == 'N' ? 'checked' : '' }} disabled> No
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Private Bathroom</th>
                            <td>
                                <input type="radio" name="private_bathroom" value="Y" {{ $postDetails->private_bathroom == 'Y' ? 'checked' : '' }} disabled> Yes
                                <input type="radio" name="private_bathroom" value="N" {{ $postDetails->private_bathroom == 'N' ? 'checked' : '' }} disabled> No
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Balcony</th>
                            <td>
                                <input type="radio" name="balcony" value="Y" {{ $postDetails->balcony == 'Y' ? 'checked' : '' }} disabled> Yes
                                <input type="radio" name="balcony" value="N" {{ $postDetails->balcony == 'N' ? 'checked' : '' }} disabled> No
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Swimming Pool</th>
                            <td>
                                <input type="radio" name="swimming_pool" value="Y" {{ $postDetails->swimming_pool == 'Y' ? 'checked' : '' }} disabled> Yes
                                <input type="radio" name="swimming_pool" value="N" {{ $postDetails->swimming_pool == 'N' ? 'checked' : '' }} disabled> No
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Smoking Allowed</th>
                            <td>
                                <input type="radio" name="smoking_allowed" value="Y" {{ $postDetails->smoking_allowed == 'Y' ? 'checked' : '' }} disabled> Yes
                                <input type="radio" name="smoking_allowed" value="N" {{ $postDetails->smoking_allowed == 'N' ? 'checked' : '' }} disabled> No
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Pet Friendly</th>
                            <td>
                                <input type="radio" name="pet_friendly" value="Y" {{ $postDetails->pet_friendly == 'Y' ? 'checked' : '' }} disabled> Yes
                                <input type="radio" name="pet_friendly" value="N" {{ $postDetails->pet_friendly == 'N' ? 'checked' : '' }} disabled> No
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Laundry Service</th>
                            <td>
                                <input type="radio" name="laundry_service" value="Y" {{ $postDetails->laundry_service == 'Y' ? 'checked' : '' }} disabled> Yes
                                <input type="radio" name="laundry_service" value="N" {{ $postDetails->laundry_service == 'N' ? 'checked' : '' }} disabled> No
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close View</button>
    </div>
@endif
