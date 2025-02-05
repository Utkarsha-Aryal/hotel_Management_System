
    <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">
            <i class="bi bi-info-circle"></i> Room Details
        </h5>
    </div>
    <div class="modal-body">
        <h2> You are now booking a <span id="category-name">{{ $category }}</span>  Room</h2>
            <form id = "booking" action = "{{route('booknow.save')}}" method="POST" enctype="multipart/form-data" class="main_form">
                @csrf
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" class="form-control" name = "name" id="name" placeholder="Enter your name">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" name = "email" id="email" placeholder="Enter your email">
                </div>

                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="text" class="form-control" name = "phone" id="phone" placeholder="Enter your phone number">
                    </div>
                    <button type="submit" class="btn btn-success">Submit Booking</button>
            </form>
    </div>
    
    <script>
  $(document).ready(function () {
    $('#booking').on('submit', function (e) {
        e.preventDefault();

        var formData = new FormData(this);
        formData.append('category', $('#category-name').text().trim()); // Add category dynamically

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.type === 'success') {
                    showNotification(response.message, 'success');
                    $('#booking')[0].reset();
                } else {
                    showNotification(response.message, 'error');
                }
            },
            error: function (xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    let errorMessages = '';
                    $.each(xhr.responseJSON.errors, function (key, value) {
                        errorMessages += value[0] + '\n';
                    });
                    showNotification(errorMessages, 'error');
                } else {
                    showNotification('An unexpected error occurred.', 'error');
                }
            }
        });
    });
});

    </script>