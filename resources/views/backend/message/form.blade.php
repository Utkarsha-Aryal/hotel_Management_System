<style>
    .ql-container {
        height: 200px;
    }

    .ql-editor {
        min-height: 100% !important;
    }

    input[type="file"] {
        display: block;
    }

    .imageThumb {
        max-height: 75px;
        border: 2px solid;
        margin-left: 10px;
        margin-bottom: 3px;
        padding: 1px;
        cursor: pointer;
    }

    .pip {
        display: inline-block;
        margin: 10px 10px 0 0;
    }


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

    label#thumbnail_image-error {
        position: absolute;
        top: 9rem !important
    }

    #ndp-nepali-box {
        top: 60px !important;
        left: 10px !important;
    }

    input#nepali-datepicker {
        width: 100% !important;
        height: 50% !important;
        border-radius: 0.2rem !important;
        border: 0.1px solid rgb(236, 231, 231);
        padding-left: 0.5rem !important;
    }
</style>
<div class="modal-header">
    <h1 class="modal-title fs-5" id="staticBackdropLabel">Message</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form action="{{ route('admin.message.save') }}" method="POST" id="messageForm" enctype="multipart/form-data">

        <div class="row">
            <input type="hidden" name="id" id="id" value="{{ @$prevPost->id }}">
            <div class="col-xl-4 col-lg-3 col-md-3 col-sm-3">
                <label for="message_by" class="form-label">Message By<span class="required-field">*</span></label>
                <input type="text" class="form-control" id="message_by" name="message_by" placeholder="Message by..."
                    value="{{ @$prevPost->message_by }}">
            </div>
            <div class="col-xl-4 col-lg-3 col-md-3 col-sm-3">
                <label for="designation" class="form-label">Designation <span class="required-field">*</span></label>
                <input type="text" class="form-control" id="designation" name="designation"
                    placeholder="Enter designation..." value="{{ @$prevPost->designation }}">
            </div>
            <div class="col-xl-4 col-lg-3 col-md-3 col-sm-3">
                <label for="order_number" class="form-label">Order <span class="required-field">*</span></label>
                <input type="text" class="form-control" id="order_number" name="order_number"
                    placeholder="Enter order..." value="{{ @$prevPost->order_number }}">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <label for="message" class="form-label">Message <span class="required-field"></span></label>
                <div id="message" name="message">{!! @$prevPost->message !!}</div>
                <input type="hidden" name="message" id="quill-content">
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <label for="image">Image <span class="required-field"></span></label>
                        <div class="relative" id="edit-image">
                            <div class="profile-user">
                                <label for="thumbnail_image"
                                    class="fe fe-camera profile-edit text-primary absolute"></label>
                            </div>
                            <input type="file" class="thumbnail_image" id="thumbnail_image"
                                style="position: absolute; clip: rect(0, 0, 0, 0); pointer-events: none;"
                                accept="image/*"name="image">
                            <div class="img-rectangle mt-2">
                                @if (!empty($image))
                                    {!! $image !!}
                                @else
                                    <img src="{{ asset('images/no-image.jpg') }}" alt="Default Image"id="img_introduction"
                                        class="_image">
                                @endif
                            </div>
                        </div>
                        <div class="row mt-4 ms-1">
                            <p class="p-0 m-0">Accepted Format :<span class="text-muted"> jpg/jpeg/png</span></p>
                            <p class="p-0 m-0">File size :<span class="text-muted"> (300x475) in pixels</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary savemessage"><i class="fa fa-save"></i>
        @if (empty(@$prevPost->id))
            Save
        @else
            Update
        @endif
    </button>
</div>

<script>
    $(document).ready(function() {
        var quill = new Quill('#message', {
            theme: 'snow'
        });

        $('#thumbnail_image').on('change', function(event) {
            const selectedFile = event.target.files[0];

            if (selectedFile) {
                $('._image').attr('src', URL.createObjectURL(selectedFile));
            }
        });

        //validation
        $('#messageForm').validate({
            rules: {
                message_by: "required",
                designation: "required",
                order_number: "required",
                message:{
                    required: function(){
                        return !quill.root.innerHTML.trim().length;
                    }
                }
                
            },
            messages: {
                message_by: {
                    required: "This field is required."
                },
                designation: {
                    required: "This field is required."
                },
                message: {
                    required: "This field is required."
                },
                order_number: {
                    required: "This field is required."
                }
            },
            highlight: function(element) {
                $(element).addClass('border-danger')
            },
            unhighlight: function(element) {
                $(element).removeClass('border-danger')
            },
        });

        // Save news
        $('.savemessage').off('click');
        $('.savemessage').on('click', function() {
            if ($('#messageForm').valid()) {
                showLoader();
                var message = quill.root.innerHTML;
                $('#messageForm').find('#quill-content').val(message);
                $('#messageForm').ajaxSubmit({
                    success: function(response) {
                        if (response) {
                            if (response.type === 'success') {
                                showNotification(response.message, 'success');
                                messageTable.draw();
                                $('#messageForm')[0].reset();
                                $('#id').val('');
                                $('#messageModal').modal('hide');
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

        $('#Progran').trigger('change');

    });
</script>
