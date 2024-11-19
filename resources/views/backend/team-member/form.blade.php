<style>
    .cropper-container {
        width: 100% !important;
    }

    .modal-header {
        position: relative;
    }

    .modal-header .closeCrop {
        position: absolute;
        top: 13px;
        right: 15px;
    }

    label#photo-error {
        position: absolute;
        top: 8.2rem !important
    }
</style>
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
        <h1 class="modal-title fs-5" id="staticBackdropLabel">
            {{ !empty(@$prevTeamMemeber->id) ? 'Update Existing Team Member Details' : 'Add New Team Member' }}
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <form id="form" method="POST" action="{{ route('admin.member.save') }}" enctype="multipart/form-data">
            <input type="hidden" id="id" name="id" value="{{ @$prevTeamMemeber->id }}">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                    <label for="name" class="form-label">Name <span class="required-field">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter name..."
                        value="{{ @$prevTeamMemeber->name }}">
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                    <label for="designation" class="form-label">Designation <span
                            class="required-field">*</span></label>
                    <input type="text" class="form-control" id="designation" name="designation"
                        placeholder="Enter Designation..." value="{{ @$prevTeamMemeber->designation }}">
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                    <label for="order_number" class="form-label">Order <span class="required-field">*</span></label>
                    <input type="number" class="form-control" id="order_number" name="order_number"
                        placeholder="Enter Order" value="{{ @$prevTeamMemeber->order_number }}">
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                    <label for="email" class="form-label">Email <span class="required-field"></span></label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email"
                        value="{{ @$prevTeamMemeber->email }}">
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                    <label for="phone_number" class="form-label">Phone Number <span
                            class="required-field"></span></label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number"
                        placeholder="Enter phone number" value="{{ @$prevTeamMemeber->phone_number }}">
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                    <label for="experience" class="form-label">Experience <span class="required-field"></span></label>
                    <input type="text" class="form-control" id="experience" name="experience"
                        placeholder="Enter experience" value="{{ @$prevTeamMemeber->experience }}">
                </div>
            </div>

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <label for="short_bio" class="form-label">Short Bio <span class="required-field"></span></label>
                <br>
                <textarea name="short_bio" class="form-control" id="" cols="70" rows="3"
                    placeholder="enter short bio">{{ @$prevTeamMemeber->short_bio }}</textarea>
            </div>

            <div class="row mt-3 ">
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                    <label for="facebook_url" class="form-label">Facebook Link</label>
                    <input type="text" class="form-control" id="facebook_url" name="facebook_url"
                        placeholder="Enter Facebook Link..." value="{{ @$prevTeamMemeber->facebook_url }}">
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                    <label for="instagram_url" class="form-label">Instagram link</label>
                    <input type="text" class="form-control" id="instagram_url" name="instagram_url"
                        placeholder="Enter instagram link..." value="{{ @$prevTeamMemeber->instagram_url }}">
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 ">
                    <label for="twitter_url" class="form-label">Twitter Link</label>
                    <input type="text" class="form-control" id="twitter_url" name="twitter_url"
                        placeholder="Enter Twitter link..." value="{{ @$prevTeamMemeber->twitter_url }}">
                </div>

            </div>
            <div class="row mt-3">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mt-2">
                    <div class="row">
                        <label class="form-label">Photo <span class="required-field"></span></label>
                        <div class="relative" id="edit-image">
                            <div class="profile-user">
                                <label for="photo" class="fe fe-camera profile-edit text-primary absolute"></label>
                            </div>
                            <input type="file" class="photo" id="photo"
                                style="position: absolute; clip: rect(0, 0, 0, 0); pointer-events: none;"
                                accept="image/*" name="photo">
                            <div class="img-rectangle mb-2">
                                <?php
                                $photo = asset('images/no-image.jpg');
                                if (!empty(@$prevTeamMemeber->photo)) {
                                    $photo = asset('storage/community/' . $prevTeamMemeber->photo);
                                }
                                ?>
                                <img src="{{ $photo }}" alt="Default Image" id="img_introduction"
                                    class="_image">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3 ms-2">
                        <p class="p-0 m-0">Accepted Format :<span class="text-muted"> jpg/jpeg/png</span></p>
                        <p class="p-0 m-0">File size :<span class="text-muted"> 512KB</span></p>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary saveData"><i class="fa fa-add"></i>
            @if (empty(@$prevTeamMemeber->id))
                Save
            @else
                Update
            @endif
        </button>
    </div>
@endif

<script>
    $(document).ready(function() {
        $('#photo').on('change', function(event) {
            const selectedFile = event.target.files[0];

            if (selectedFile) {
                $('._image').attr('src', URL.createObjectURL(selectedFile));
            }
        });


        $('#form').validate({
            rules: {
                name: "required",
                order_number: "required",
                designation: "required",
            },
            message: {
                name: {
                    required: "This field is required."
                },
                order_number: {
                    required: "This field is required."
                },
                designation: {
                    required: "This field is required."
                },  
            },
            highlight: function(element) {
                $(element).addClass('border-danger')
            },
            unhighlight: function(element) {
                $(element).removeClass('border-danger')
            },
        });

        // Save Team member details
        $('.saveData').off('click');
        $('.saveData').on('click', function(e) {
            if ($('#form').valid()) {
                showLoader();
                $('#form').ajaxSubmit({
                    success: function(response) {
                        if (response) {
                            if (response.type === 'success') {
                                showNotification(response.message, 'success');
                                table.draw();
                                $('#form')[0].reset();
                                $('#id').val('');
                                $('#modal').modal('hide');
                                hideLoader();
                            } else {
                                showNotification(response.message, 'error');
                                hideLoader();
                            }
                        }
                        hideLoader();
                    },
                    error: function(xhr) {
                        hideLoader();
                        var response = xhr.responseJSON;
                        showNotification(response ? response.message : 'An error occurred',
                            'error');
                    }
                });
            }
        });
    });
</script>
