@extends('backend.layouts.main')

@section('title')
    About Us
@endsection

@section('styles')
    <style>
        .relative {
            position: relative;
            width: 150px !important;
            padding-right: 0 !important;
        }

        .absolute {
            position: absolute;
            right: 0 !important;
        }

        .ql-container {
            height: 200px;
        }

        .ql-editor {
            min-height: 100% !important;
        }

        input#admission_open {
            border: 1px solid rgb(176, 176, 176) !important
        }
    </style>
@endsection

@section('main-content')
    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div>
            <h4 class="mb-0">About Us</h4>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">About Us</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Introduction</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- End Page Header -->

    <!-- row -->
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.aboutus.update') }}" id="about-us-form" enctype="multipart/form-data"
                method="POST">
                <div class="row">
                    <div class="form-group col-10">
                        <label for="introduction">Introduction of organization <span class="required-field">*</span></label>
                        <textarea class="form-control mt-2" id="introduction" name="introduction" rows="8"
                            placeholder="Enter introduction...">{{ @$aboutusData['introduction'] }}</textarea>
                    </div>

                    <div class="form-group col-2">
                        <div class="row">
                            <div class="mt-2">
                                <label for="img_introduction">Introduction image</label>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="relative" id="edit-image">
                                <div class="profile-user">
                                    <label for="edit_img_introduction"
                                        class="fe fe-camera profile-edit text-primary absolute"></label>
                                </div>
                                <input type="file" class="edit_img_introduction" id="edit_img_introduction"
                                    style="position: absolute; clip: rect(0, 0, 0, 0); pointer-events: none;"
                                    accept="image/*" name="img_introduction">
                                <input type="hidden" class="form-control croppedImgIntroduction"
                                    id="croppedImgIntroduction" name="croppedImgIntroduction">
                                <div class="img-rectangle">
                                    @if (!empty($aboutusData['img_introduction']))
                                        <img alt=""
                                            src={{ asset('/storage/aboutus') . '/' . @$aboutusData['img_introduction'] }}
                                            alt="img" id="img_introduction">
                                    @else
                                        <img src="{{ asset('/images/no-image.jpg') }}" alt="Default Image"
                                            id="img_introduction">
                                    @endif

                                </div>
                            </div>
                            <div class="row mt-2 ms-1">
                                <p class="p-0 m-0">Accepted Format :<span class="text-muted"> jpg/jpeg/png</span></p>
                                <p class="p-0 m-0">File size :<span class="text-muted"> 512KB</span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-3">
                        <label for="founder_name">Founder Name </label>
                        <input type="text" class="form-control mt-1" id="founder_name" name="founder_name"
                            value="{{ @$aboutusData['founder_name'] }}" placeholder="Enter Founder Name">
                    </div>
                    <div class="form-group col-7">
                        <label for="founder_message">Message <span class="required-field">*</span></label>
                        <textarea class="form-control mt-2" id="founder_message" name="founder_message" rows="8"
                            placeholder="Enter founder message...">{{ @$aboutusData['founder_message'] }}</textarea>
                    </div>

                    <div class="form-group col-2">
                        <div class="row">
                            <div class="mt-2">
                                <label for="founder_image">Founder Image</label>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="relative" id="edit-image">
                                <div class="profile-user">
                                    <label for="edit_img_founder"
                                        class="fe fe-camera profile-edit text-primary absolute"></label>
                                </div>
                                <input type="file" class="edit_img_founder" id="edit_img_founder"
                                    style="position: absolute; clip: rect(0, 0, 0, 0); pointer-events: none;"
                                    accept="image/*" name="founder_image">

                                <div class="img-rectangle">
                                    @if (!empty($aboutusData['founder_image']))
                                        <img alt=""
                                            src={{ asset('/storage/aboutus') . '/' . @$aboutusData['founder_image'] }}
                                            alt="img" id="founder_image">
                                    @else
                                        <img src="{{ asset('/images/no-image.jpg') }}" alt="Default Image"
                                            id="founder_image">
                                    @endif

                                </div>
                            </div>
                            <div class="row mt-2 ms-1">
                                <p class="p-0 m-0">Accepted Format :<span class="text-muted"> jpg/jpeg/png</span></p>
                                <p class="p-0 m-0">File size :<span class="text-muted"> 512KB</span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-10">
                        <label for="vision">Vision<span class="required-field">*</span></label>
                        <textarea class="form-control mt-2" id="vision" name="vision" rows="8" placeholder="Enter message...">{{ @$aboutusData['vision'] }}</textarea>
                    </div>
                    <div class="form-group col-2">
                        <div class="row">
                            <div class="mt-2">
                                <label for="vision_image">Vision Image</label>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="relative" id="edit-image">
                                <div class="profile-user">
                                    <label for="edit_vision_image"
                                        class="fe fe-camera profile-edit text-primary absolute"></label>
                                </div>
                                <input type="file" class="edit_vision_image" id="edit_vision_image"
                                    style="position: absolute; clip: rect(0, 0, 0, 0); pointer-events: none;"
                                    accept="image/*" name="vision_image">

                                <div class="img-rectangle">
                                    @if (!empty($aboutusData['vision_image']))
                                        <img alt=""
                                            src={{ asset('/storage/aboutus') . '/' . @$aboutusData['vision_image'] }}
                                            alt="img" id="vision_image">
                                    @else
                                        <img src="{{ asset('/images/no-image.jpg') }}" alt="Default Image"
                                            id="vision_image">
                                    @endif

                                </div>
                            </div>
                            <div class="row mt-2 ms-1">
                                <p class="p-0 m-0">Accepted Format :<span class="text-muted"> jpg/jpeg/png</span></p>
                                <p class="p-0 m-0">File size :<span class="text-muted"> 512KB</span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-10">
                        <label for="mission">Mission <span class="required-field">*</span></label>
                        <textarea class="form-control mt-2" id="mission" name="mission" rows="8" placeholder="Enter mission...">{{ @$aboutusData['vision'] }}</textarea>
                    </div>

                    <div class="form-group col-2">
                        <div class="row">
                            <div class="mt-2">
                                <label for="mission_image">Mission Image</label>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="relative" id="edit-image">
                                <div class="profile-user">
                                    <label for="edit_mission_image"
                                        class="fe fe-camera profile-edit text-primary absolute"></label>
                                </div>
                                <input type="file" class="edit_mission_image" id="edit_mission_image"
                                    style="position: absolute; clip: rect(0, 0, 0, 0); pointer-events: none;"
                                    accept="image/*" name="mission_image">

                                <div class="img-rectangle">
                                    @if (!empty($aboutusData['mission_image']))
                                        <img alt=""
                                            src={{ asset('/storage/aboutus') . '/' . @$aboutusData['mission_image'] }}
                                            alt="img" id="mission_image">
                                    @else
                                        <img src="{{ asset('/images/no-image.jpg') }}" alt="Default Image"
                                            id="mission_image">
                                    @endif

                                </div>
                            </div>
                            <div class="row mt-2 ms-1">
                                <p class="p-0 m-0">Accepted Format :<span class="text-muted"> jpg/jpeg/png</span></p>
                                <p class="p-0 m-0">File size :<span class="text-muted"> 512KB</span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-3">
                        <label for="video_title">Video Title</label>
                        <input type="text" class="form-control mt-1" id="video_title" name="video_title"
                            value="{{ @$aboutusData['video_title'] }}" placeholder=" eg 1K / 500">
                    </div>
                    <div class="form-group col-3">
                        <label for="video_url" class="form-label">Video Link</label>
                        <input type="text" class="form-control" id="video_url" name="video_url"
                            placeholder="Enter video Link..." value="{{ @$aboutusData['video_url'] }}">
                    </div>

                </div>
                <div class="card-footer d-flex justify-content-end mt-3">
                    <button type="button" class="btn btn-primary" id="save_about"><i class="fa fa-save"></i>
                        Update</button>
                </div>
            </form>
        </div>
    </div>
    <!-- row close -->
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#edit_img_introduction').on('change', function(event) {
                var selectedFile = event.target.files[0];

                if (selectedFile) {
                    $('#img_introduction').attr('src', URL.createObjectURL(selectedFile));
                }
            });

            $('#edit_img_founder').on('change', function(event) {
                var selectedFile = event.target.files[0];

                if (selectedFile) {
                    $('#founder_image').attr('src', URL.createObjectURL(selectedFile));
                }
            });

            $('#edit_vision_image').on('change', function(event) {
                var selectedFile = event.target.files[0];

                if (selectedFile) {
                    $('#vision_image').attr('src', URL.createObjectURL(selectedFile));
                }
            });

            $('#edit_mission_image').on('change', function(event) {
                var selectedFile = event.target.files[0];

                if (selectedFile) {
                    $('#mission_image').attr('src', URL.createObjectURL(selectedFile));
                }
            });


            $('#about-us-form').validate({
                rules: {
                    introduction: "required",
                    founder_name: "required",
                    vision: "required",
                    mission: "required",
                    edit_img_introduction: "required",
                    founder_message: "required",
                    image: {
                        required: function() {
                            var id = $('#id').val();
                            return id === '';
                        }
                    },
                },
                message: {
                    introduction: {
                        required: "Please enter introduction"
                    },
                    edit_img_introduction: {
                        required: "Introduction image"
                    },
                    vision: {
                        required: "Please enter vision"
                    },
                    mission: {
                        required: "Please enter mission"
                    }
                },
                highlight: function(element) {
                    $(element).addClass('border-danger')
                },
                unhighlight: function(element) {
                    $(element).removeClass('border-danger')
                },
            });

            $('#save_about').off('click');
            $('#save_about').on('click', function(e) {
                if ($('#about-us-form').valid()) {
                    showLoader();
                    $('#about-us-form').ajaxSubmit({
                        success: function(response) {
                            if (response) {
                                hideLoader();
                                showNotification(response.message, response.type);
                            } else {
                                hideLoader();
                            }
                        },
                        error: function(xhr) {
                            hideLoader();
                            var response = xhr.responseJSON;
                            showNotification(response && response.message ? response.message :
                                'An error occurred', 'error');
                        }
                    });
                }
            });

        });
    </script>
@endsection
