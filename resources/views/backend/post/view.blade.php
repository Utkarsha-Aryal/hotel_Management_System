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
        <h5 class="modal-title">View @if (!empty($postDetails->category))
                " {{ ucfirst($postDetails->category) }} "
            @endif
        </h5>
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
                            <th scope="row">Title</th>
                            <td>{{ $postDetails->title }}</td>
                        </tr>
                        <tr>
                            <th>
                                Meta Keywords
                            </th>
                            <td>{{ $postDetails->meta_keywords }}</td>
                        </tr>

                        <tr>
                        <th>
                                Meta Description
                            </th>
                            <td>{{ $postDetails->meta_description }}</td>

                        </tr>


                        <tr>
                            <th scope="row">Category</th>
                            <td>{{ $postDetails->category }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Image</th>
                            <?php
                            $photo = asset('images/no-image.jpg');
                            if (!empty($postDetails->image)) {
                                $photo = asset('storage/post/' . $postDetails->image);
                            }
                            ?>
                            <td><img src="{{ $photo }}" height="100px" alt="Image">
                        </tr>
                        <tr>
                            <th scope="row">Featured Image</th>
                            <td>
                                @if (!empty($decodedFeatureImages))
                                    @foreach ($decodedFeatureImages as $featureImage)
                                        <div id="feature_image">

                                            <img src="{{ asset('/storage/post') . '/' . $featureImage }}"
                                                class="_feature-image imageThumb" alt="Feature Image" / height="100px"
                                                width="100px">

                                        </div>
                                    @endforeach
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Overview</th>
                            <td>{!! $postDetails->details !!}</td>
                        </tr>
                        @if ($postDetails->category == 'event')
                            <tr>
                                <th scope="row">Author</th>
                                <td>{{ strip_tags($postDetails->author) }}</td>
                            </tr>

                            <tr>
                                <th scope="row">Published Date</th>
                                <td>{{ strip_tags($postDetails->published_date) }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Close View </button>
    </div>
@endif
