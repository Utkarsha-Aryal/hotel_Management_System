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
    <h1 class="modal-title fs-5" id="staticBackdropLabel">Post</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<form action="{{ route('admin.post.save') }}" method="POST" id="postForm" enctype="multipart/form-data">
    <div class="container">
        <div class="row mb-3">
            <!-- Category Select -->
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                <input type="hidden" name="id" id="id" value="{{ @$prevPost->id }}">
                <label for="category" class="form-label">Category <span class="required-field">*</span></label>
                <select class="form-select" id="category" name="category" required>
                    <option value="">Select Category</option>
                    <option value="article" {{ !empty($prevPost->category) && $prevPost->category === 'article' ? 'selected' : '' }}>Article</option>
                    <option value="blog" {{ !empty($prevPost->category) && $prevPost->category === 'blog' ? 'selected' : '' }}>Blog</option>
                    <option value="event" {{ !empty($prevPost->category) && $prevPost->category === 'event' ? 'selected' : '' }}>Event</option>
                    <option value="news" {{ !empty($prevPost->category) && $prevPost->category === 'news' ? 'selected' : '' }}>News</option>
                    <option value="notice" {{ !empty($prevPost->category) && $prevPost->category === 'notice' ? 'selected' : '' }}>Notice</option>
                </select>
            </div>

            <!-- Title Input -->
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                <label for="title" class="form-label">Title <span class="required-field">*</span></label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Enter title..." value="{{ @$prevPost->title }}" required>
            </div>

            <!-- Date Picker -->
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 datepick">
                <label for="publish_date" class="form-label">Published Date <span class="required-field">*</span></label>
                <p>
                <input type="text" id="nepali-datepicker" name="published_date" class="form-control" placeholder="Select published date" value="{{ @$prevPost->published_date }}">
                </p>
            </div>
        </div>

        <!-- Details Input (Quill Editor) -->
        <!-- Details Input (Quill Editor) -->
<div class="row mb-3">
    <div class="col-12">
        <label for="details" class="form-label">Details</label>
        <div id="details">{!! @$prevPost->details !!}</div>
        <input type="hidden" name="details" id="quill-content">
    </div>

    <!-- Author Input -->
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
        <label for="author" class="form-label">Author<span class="required-field">*</span></label>
        <input type="text" class="form-control" id="author" name="author" placeholder="Enter author name" value="{{@$prevPost->author}}">
    </div>

    <!-- Meta Key Input -->
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
        <label for="meta_key" class="form-label">Meta Key</label>
        <input type="text" class="form-control" id="meta_key" name="meta_keywords" placeholder="Enter meta_key " value="{{ @$prevPost->meta_keywords }}">
    </div>
</div>

<!-- Meta Description -->
<div class="row mb-3">
    <div class="col-12">
        <label for="meta_description" class="form-label">Meta Description</label>
        <textarea name="meta_description" id="meta_description" class="form-control" placeholder="Enter the meta description"> {{ @$prevPost->meta_description }}</textarea>
    </div>
</div>


        <!-- Thumbnail Image Upload -->
        <div class="row mb-3">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <label for="thumbnail_image" class="form-label">Thumbnail Image <span class="required-field">*</span></label>
                <div class="relative" id="edit-image">
                    <div class="profile-user">
                        <label for="thumbnail_image" class="fe fe-camera profile-edit text-primary absolute"></label>
                    </div>
                    <input type="file" class="thumbnail_image" id="thumbnail_image" style="position: absolute; clip: rect(0, 0, 0, 0); pointer-events: none;" accept="image/*" name="image">
                    <input type="hidden" class="form-control croppedImg" id="croppedImg" name="croppedImg">
                    <div class="img-rectangle mt-2">
                        @if (!empty($image))
                            {!! $image !!}
                        @else
                            <img src="{{ asset('images/no-image.jpg') }}" alt="Default Image" id="img_introduction" class="_image">
                        @endif
                    </div>
                </div>
                <p class="text-muted mt-2">Accepted Format: jpg/jpeg/png | File size: (300x475) in pixels</p>
            </div>

            <!-- Feature Images Upload -->
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <label for="feature_images" class="form-label">Feature Images</label>
                <input type="file" class="form-control mt-2" name="feature_images[]" id="feature_images" multiple>
                <p class="text-muted mt-2">Multiple Images Can Be Uploaded | Accepted Format: jpg/jpeg/png</p>
                <div class="row">
                    @if (!empty($decodedFeatureImages))
                        @foreach ($decodedFeatureImages as $featureImage)
                            <div class="col-md-4 mb-3" id="feature_image">
                                <img src="{{ asset('/storage/post') . '/' . $featureImage }}" class="_feature-image imageThumb img-fluid" alt="Feature Image">
                                <button type="button" class="delete_feature_image btn btn-danger btn-sm mt-2" data-feature_image="{{ $featureImage }}">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        </div>
    </div>
</form>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary saveNews"><i class="fa fa-save"></i>
        @if (empty($id))
            Save
        @else
            Update
        @endif
    </button>
</div>


<script>
    $(document).ready(function() {
        showDatePicker();
        console.log(showDatePicker())
        var quill = new Quill('#details', {
            theme: 'snow'
        });
        // $("#datetime").datepicker();
        const today = new Date();
        const hours = today.getHours();
        const minutes = today.getMinutes();
        const currentTime =`${hours}h:${minutes}min`
        const formattedDate = today.toISOString().split('T')[0]
        const nepalidate = NepaliFunctions.AD2BS(formattedDate);
         if (!$('#nepali-datepicker').val()) {
            $('#nepali-datepicker').val(nepalidate);
        }

        //uploaded image preview start
        $("#feature_images").on("change", function(event) {
            // $(document).on("change", "#feature_images", function(event) {
            var images = event.target.files;
            var filesLength = images.length;
            for (var i = 0; i < filesLength; i++) {
                var f = images[i];
                var fileReader = new FileReader();
                fileReader.onload = (function(e) {
                    var file = e.target;
                    $("<span class=\"pip\">" +
                        "<img class=\"imageThumb\" src=\"" + e.target.result +
                        "\" title=\"" + file.name + "\"/>" +
                        "</span>").insertAfter("#feature_images");
                });
                fileReader.readAsDataURL(f);
            }
        });


        $(document).on("change", "#feature_images", function() {
            $('.pip').hide();
        });
        // uploaded image preview end

        $('#thumbnail_image').on('change', function(event) {
            const selectedFile = event.target.files[0];

            if (selectedFile) {
                $('._image').attr('src', URL.createObjectURL(selectedFile));
            }
        });

     
        //validation
        $('#postForm').validate({
            rules: {
                category: "required",
                title: "required",
                details: "required",
                image: {
                    required: function() {
                        var id = $('#id').val();
                        return id === '';
                    }
                },
                published_date:"required",
                author:'required'
            },
            message: {
                category: {
                    required: "This field is required."
                },
                title: {
                    required: "This field is required."
                },
                author: {
                    required: "This field is required."
                },
                published_date: {
                    required: "This field is required."
                },
                image: {
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

        // Save news
        $('.saveNews').off('click');
        $('.saveNews').on('click', function() {
            if ($('#postForm').valid()) {
                showLoader();
                var details = quill.root.innerHTML;
                $('#postForm').find('#quill-content').val(details);
                $('#postForm').ajaxSubmit({
                    success: function(response) {
                        if (response) {
                            if (response.type === 'success') {
                                showNotification(response.message, 'success');
                                postTable.draw();
                                $('#postForm')[0].reset();
                                $('#id').val('');
                                $('#postModal').modal('hide');
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

        $('#category').trigger('change');

        // $('.delete_feature_image').on('click', function() {
        //     var feature_image = $(this).data('feature_image');
        //     var id = $('#id').val();
        //     var url = '{{ route('admin.post.deletefeatureimage') }}';
        //     $.ajax({
        //         url: url,
        //         type: 'POST',
        //         data: {
        //             feature_image: feature_image,
        //             id: id,
        //         },
        //         success: function(response) {
        //             // Handle success message or update UI
        //             console.log(response);
        //             // Reload or update UI to reflect changes
        //         },
        //         error: function(xhr, status, error) {
        //             // Handle error
        //             console.error(error);
        //         }
        //     });
        // });

        // Delete feature image
        $('.delete_feature_image').off('click')
        $('.delete_feature_image').on('click', function() {
            var deleteButton = $(this);
            Swal.fire({
                title: "Are you sure you want to delete this item",
                text: "You won't be able to revert it!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DB1F48",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    showLoader();
                    var feature_image = $(this).data('feature_image');
                    var id = $('#id').val();
                    var url = '{{ route('admin.post.deletefeatureimage') }}';
                    var data = {
                        feature_image: feature_image,
                        id: id,
                    };
                    $.post(url, data, function(response) {
                        var result = JSON.parse(response);
                        if (result) {
                            if (result.type === 'success') {
                                showNotification(result.message, 'success');
                                deleteButton.closest('#feature_image').remove();
                                hideLoader();
                            } else {
                                showNotification(result.message, 'error');
                                hideLoader();
                            }
                        }
                    });
                }
            });
        });

    });
</script>
