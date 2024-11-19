<style>
    .iconpicker-popover.popover.bottom {
        opacity: 1;
    }
</style>

    <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">
        
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
    
    </div>

    <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <form action="{{route('admin.account.save')}}" method="POST" id="userForm" enctype="multipart/form-data">
            <input type="hidden" name="id" id="id" value="{{@$prevUserAccount->id}}">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                    <label for="name" class="form-label">Full Name <span class="required-field">*</span></label>
                    <input type="text" class="form-control" id="name" name="name"
                        placeholder="Enter full name..." value="{{@$prevUserAccount->full_name}}">
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                    <label for="email" class="form-label">Email <span class="required-field">*</span></label>
                    <input type="email" class="form-control" id="email" name="email"
                        placeholder="Enter user email..." value="{{@$prevUserAccount->email}}">
                </div>
            </div>
            <div class="row mt-2">

                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                    <label for="mobile_number" class="form-label">Mobile Number </label>
                    <input type="mobile_number" class="form-control" id="mobile_number" name="mobile_number"
                        placeholder="Enter user mobile number..." value="{{@$prevUserAccount->phone_number}}">
                </div>

                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                    <input type ="hidden" name= "role" value="2">
                    <input type="hidden" class="form-control" id="role" value="Admin" disabled>
                    <label for="gender" class="form-label">Gender<span class="required-field">*</span></label>
            <select class="form-control" id="gender" name="gender" required>
                <option value="">Select Gender</option>
                <option value="male" {{ @$prevUserAccount->gender == 'male' ? 'selected' : '' }}>Male</option>
                 <option value="female" {{ @$prevUserAccount->gender == 'female' ? 'selected' : '' }}>Female</option>
            </select>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <label for="email" class="form-label">Address </label>
                    <textarea class="form-control mt-1" id="address" name="address" rows="2" placeholder="Enter address...">{{ @$prevUserAccount->address }}</textarea>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="row">
                        <label for="image" class="form-label">Image </label>
                        <div class="relative" id="edit-image">
                            <div class="profile-user">
                                <label for="image" class="fe fe-camera profile-edit text-primary absolute"></label>
                            </div>
                            <input type="file" class="image" id="image"
                                style="position: absolute; clip: rect(0, 0, 0, 0); pointer-events: none;"
                                accept="image/*" name="image">

                            <div class="img-rectangle mt-2">
                                <?php
                                $photo = asset('images/no-image.jpg');
                                if(!empty(@$prevUserAccount->image)){
                                    $photo = asset('storage/user-account/' . $prevUserAccount->image);
                                }
                                ?>
                            
                                <img src="{{ $photo }}" alt="Default Image" id="img_introduction" class="_image">
                            </div>
                        </div>
                        <div class="row mt-2 ms-1">
                            <p class="p-0 m-0">Accepted Format :<span class="text-muted"> jpg/jpeg/png</span></p>
                            <p class="p-0 m-0">File size :<span class="text-muted"> (300x475) in pixels</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveUser"><i class="fa fa-save"></i>
        @if (empty(@$prevUserAccount->id))
                Save
            @else
                Update
            @endif
        </button>
    </div>

   
<script>
    $(document).ready(function() {
        $('#image').on('change', function(event) {
            const selectedFile = event.target.files[0];

            if (selectedFile) {
                $('._image').attr('src', URL.createObjectURL(selectedFile));
            }
        });

        $('#userForm').validate({
            rules: {
                name: "required",
                email: "required",
                role: "required",
                image: {
                    required: function(){
                        var id = $('#id').val();
                        return id==="";
                    }
                }
            },
            message: {
                name: {
                    required: "Please enter full name"
                },
                email: {
                    required: "Please enter email"
                },
                role: {
                    required: "Please enter user role"
                },
                photo: {
                    required: "This field is required."
                },
                address:{
                    required: "This field is required "
                }

            },
            highlight: function(element) {
                $(element).addClass('border-danger')
            },
            unhighlight: function(element) {
                $(element).removeClass('border-danger')
            },
        });

       //Save user data
        $('#saveUser').off('click');
        $('#saveUser').on('click', function() {
            if ($('#userForm').valid()) {
                showLoader();

                $('#userForm').ajaxSubmit({
                    success: function(response) {
                        if (response.type === 'success') {
                            showNotification(response.message, 'success');
                            table.draw();
                            $('#userForm')[0].reset();
                            $('#id').val('');
                            $('#modal').modal('hide');
                            hideLoader();
                            console.log('success');
                        } else {
                            showNotification( response.message,'error');
                            table.draw();
                            hideLoader();
                        }
                        hideLoader();
                    },
                    error: function(xhr) {
                        hideLoader();
                        console.log('eroor2');
                        var response = xhr.responseJSON;
                        if (response) {
                            showNotification(response.message || 'An error occurred',
                                'error');
                        } else {
                            showNotification('An error occurred', 'error');
                        }
                    }
                });
            }
        });
    });
</script>


