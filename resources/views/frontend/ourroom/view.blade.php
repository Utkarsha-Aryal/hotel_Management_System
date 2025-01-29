@if ($type == 'error')
    <div class="modal-header bg-danger text-white">
        <h1 class="modal-title fs-5">
            <i class="bi bi-exclamation-circle"></i> Error
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body text-center">
        <p class="text-danger">{{ $message }}</p>
    </div>
@else
    <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">
            <i class="bi bi-info-circle"></i> Room Details
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <div class="mb-3">
                    <?php
                    $image = asset('images/no-image.jpg');
                    if (!empty($roomcategoryDetails->image)) {
                        $image = asset('storage/roomCategory/' . $roomcategoryDetails->image);
                    }
                    ?>
                    <img src="{{ $image }}" class="img-fluid rounded shadow-sm" alt="Room Image" style="max-height: 200px;">
                </div>

                <h4 class="fw-bold text-primary">{{ $roomcategoryDetails->category }}</h4>
                <p class="text-muted">
                    <strong>Maximum Occupancy:</strong> {{ $roomcategoryDetails->maximum_occupancy }} guests
                </p>
                <p class="text-muted">
                    <strong>Bed Type:</strong> {{ $roomcategoryDetails->bed_type }}
                </p>
            </div>
        </div>
    </div>
@endif
