<link rel="stylesheet" href="{{ asset('backpanel/assets/css/cropper/cropper.css') }}">
<style>
    input#trashed_file_image,
    #external_link {
        border: 1px solid rgb(0, 99, 198) !important
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

    .trash {
        display: flex;
        justify-content: flex-end;
        gap: 0.5rem;
    }
</style>
<div class="modal-header">
    <h1 class="modal-title fs-5" id="staticBackdropLabel">Images - {{ @$title }}</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form id="imageForm" method="POST" action="{{ route('admin.gallery.image.save') }}" enctype="multipart/form-data">

        <div class="row ms-0">
            <div class="form-check col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <input class="form-check-input" type="checkbox" value="Y" id="external_link" name="external_link">
                <label class="form-check-label" for="external_link">
                    Add images from external link
                </label>
            </div>
        </div>

        <div class="row show_external_link_input"style="display: none">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <label for="link" class="form-label">Image Link <span class="required-field">*</span></label>
                <input type="text" class="form-control" name="image_link" id="image_link" value="" />
            </div>
        </div>

        <div class="row show_image_field">
            {{-- <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                <div class="row">
                    <label for="image" class="form-label">Image <span class="required-field">*</span></label>
                    <div class="relative mb-2" id="edit-image">
                        <div class="profile-user">
                            <label for="upload-image" class="fe fe-camera profile-edit text-primary absolute"></label>
                        </div>
                        <input type="hidden" name="gallery_id" id="gallery_id" value="{{ @$id }}">
                        <input type="hidden" name="id" id="edit_id" value="">
                        <input type="file" class="form-control upload-image" name="image" id="upload-image"
                            value="" style="position: absolute; clip: rect(0, 0, 0, 0); pointer-events: none;" />
                        <input type="hidden" class="form-control croppedImg" id="croppedImg" name="croppedImg">

                        <img src="{{ asset('/no-image.jpg') }}" width="160px" alt="Default Image" class='_image'>

                    </div>
                </div>
            </div> --}}
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="row">
                    <label class="form-label">Image <span class="required-field">*</span></label>
                    <input type="hidden" name="gallery_id" id="gallery_id" value="{{ @$id }}">
                    <input type="hidden" name="id" id="edit_id" value="">
                    <input type="file" class="form-control upload-image" name="image[]" id="upload-image"
                        value="" multiple />

                </div>
            </div>
            <div class="row ms-1 mt-2">
                <p class="p-0 m-0">Accepted Format :<span class="text-muted"> jpg/jpeg/png</span></p>
                <p class="p-0 m-0">File size :<span class="text-muted"> (300x475) in pixels</span></p>
            </div>
        </div>
        <div class="col-md-3 mt-2">
            <button class="btn btn-primary" id="saveImage"> <i class="fas fa-save"></i> Save</button>
        </div>
    </form>
    <div class="row ms-0">
        <div class="form-check col-xl-12 col-lg-12 col-md-12 col-sm-12 trash">
            <input class="form-check-input" type="checkbox" value="Y" id="trashed_file_image" name="trashed_file">
            <label class="form-check-label" for="trashed_file_image">
                View Trashed
            </label>
        </div>
    </div>
    <div class="row mt-4">
        <div class="table-responsive">
            <div id="datatable-basic_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                <div class="row">
                    <div class="col-sm-12 col-md-12 mb-3 mb-3">
                        <div class="dataTables_length" id="datatable-basic_length">
                            <table id="imageTable"
                                class="table table-bordered text-nowrap w-100 dataTable no-footer mt-3"
                                aria-describedby="datatable-basic_info">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Image</th>
                                        <th>External Link</th>
                                        <th>Action</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
</div>

{{-- crop modal-start --}}

{{-- <div class="modal cropModel fade" id="cropModel" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Crop Image</h5>
                <button type="button" class="closeCrop" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-md-12">
                            <img id="image" src="#" style="height: 300px; width: 300px;">
                        </div>
                        <div class="col-md-12">
                            <div class="preview"></div>
                        </div>
                    </div>
                </div>
                <div id="controls">
                    <button id="rotateLeft">Rotate Left</button>
                    <button id="rotateRight">Rotate Right</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn_btn cancel_btn cancelCrop" id="cancelCrop">Cancel</button>
                <button type="button" class="btn_btn submit_btn" id="cropImage">Crop</button>
            </div>
        </div>
    </div>
</div> --}}
{{-- crop modal-end --}}

{{-- cropper js -start --}}

{{-- <script>
    var cropper;
    $(document).ready(function() {

        //cancel Crop Model --Start
        $('.cancelCrop').off('click', '');
        $('.cancelCrop').on('click', function(e) {
            var file = $('.upload-image')[0].files[0];
            if (file) {
                $('._image').attr('src', URL.createObjectURL(file));
            }
            $('#cropModel').modal('hide');
        });
        //close Model --End

        //to pass image url to crop model ---Start
        $('.upload-image').off('change');
        $('.upload-image').on("change", function(e) {
            var files = e.target.files;
            var done = function(url) {
                $('#image').attr('src', url);
                $('#cropModel').modal('show');
            };
            var reader;
            var file;
            var url;

            if (files && files.length > 0) {
                file = files[0];
                if (URL) {
                    done(URL.createObjectURL(file));
                }
            }
        });
        //to pass image url to crop model ---End

        //to crop images---Start
        $('#cropModel').off('shown.bs.modal');
        $('#cropModel').on('shown.bs.modal', function() {
            var image = document.getElementById('image');

            cropper = new Cropper(image, {
                initailAspectRatio: 1,
                aspectRatio: 1,
                viewMode: 1,
                moveable: false,
                zoomOnWheel: false,

                preview: '.preview',
            });

            $("#rotateRight").on("click", e => {
                cropper.rotate(90);
            });

            $("#rotateLeft").on("click", e => {
                cropper.rotate(-90);
            });
        }).on('hidden.bs.modal', function() {
            cropper.destroy();
            cropper = null;
        });
        //to crop images---End

        //save crop image ---Start
        var base64data;
        $('#cropImage').off('click');
        $('#cropImage').on('click', function() {

            canvas = cropper.getCroppedCanvas({
                width: 160,
                height: 160,
            });
            canvas.toBlob(function(blob) {
                url = URL.createObjectURL(blob);
                $('._image').attr('src', url);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function() {
                    base64data = reader.result;
                    $('#cropModel').modal('hide');
                    $('#croppedImg').val(base64data);
                }
            })
        });
        //save crop image ---End
    });
</script> --}}

{{-- cropper js -end --}}

<script>
    $(document).ready(function() {

        //show/hide external link input
        $('#external_link').on('change', function() {
            if ($(this).is(':checked')) {
                $('.show_external_link_input').show();
                $('.show_image_field').hide();

            } else {
                $('.show_external_link_input').hide();
                $('.show_image_field').show();
            }
        });

        //show/hide external link input

        //upload image

        $('#image').on('change', function(event) {
            var selectedFile = event.target.files[0];

            if (selectedFile) {
                $('._image').attr('src', URL.createObjectURL(selectedFile));
            }
        });
        //end upload image


        // save Event image
        $('#saveImage').on('click', function(e) {
            e.preventDefault();
            showLoader();
            $('#imageForm').ajaxSubmit(function(response) {
                var rep = JSON.parse(response);
                if (rep) {
                    hideLoader();
                    showNotification(rep.message, rep.type);
                    if (rep.type === 'success') {
                        imageTable.draw();
                        // $('#imageForm')[0].reset();
                        $('#image_link').val('');
                        $('#upload-image').val('');
                        $('#edit_id').val('');
                        $('._image').attr('src', `{{ asset('/no-image.jpg') }}`);
                    }
                } else {
                    hideLoader();
                }
            });
        });
        //edit event image
        $(document).on('click', '.editImage', function(e) {
            e.preventDefault();
            var imageUrl = $(this).data('image');
            var editId = $(this).data('id');
            $('.image-url').html(imageUrl);
            $('#edit_id').val(editId);
            $('._image').attr('src', `{{ asset('/storage/gallery-image') }}/${imageUrl}`);
        });


        // view trashed items-start
        $('#trashed_file_image').off('change');
        $('#trashed_file_image').on('change', function(e) {
            imageTable.draw();
        });

        // view trashed items-end


        // Delete event
        $(document).on('click', '.deleteImage', function(e) {
            e.preventDefault();
            $('#imageModel').modal('hide');
            Swal.fire({
                title: "Are you sure you want to delete ?",
                text: "You won't be able to revert it!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DB1F48",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    var id = $(this).data('id');
                    var type = $('#trashed_file_image').is(':checked') == true ? 'trashed' :
                        'nottrashed';
                    var data = {
                        id: id,
                        type: type,
                    };
                    var url = '{{ route('admin.gallery.image.delete') }}';
                    $.post(url, data, function(response) {
                        var rep = JSON.parse(response);
                        if (rep) {
                            showNotification(rep.message, rep.type);
                            if (rep.type === 'success') {
                                $('#imageModel').modal('show');
                                imageTable.draw();
                            }
                        }
                    });
                }
            });
        });
    });
</script>


<script>
    var imageTable;
    var gallery_id = '{{ @$id }}';
    $(document).ready(function() {

        imageTable = $('#imageTable').DataTable({
            "sPaginationType": "full_numbers",
            "bSearchable": false,
            "lengthMenu": [
                [5, 10, 15, 20, 25, -1],
                [5, 10, 15, 20, 25, "All"]
            ],
            'iDisplayLength': 15,
            "sDom": 'ltipr',
            "bAutoWidth": false,
            "aaSorting": [
                [0, 'desc']
            ],
            "bSort": false,
            "bProcessing": true,
            "bServerSide": true,
            "oLanguage": {
                "sEmptyTable": "<p class='no_data_message text-center'>No data available.</p>"
            },
            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [1]
            }],
            "aoColumns": [{
                    "data": "sno"
                },
                {
                    "data": "image"
                },
                {
                    "data": "image_link"
                },
                {
                    "data": "action"
                },
            ],
            "ajax": {
                "url": '{{ route('admin.gallery.image.list') }}',
                "type": "POST",
                "data": function(d) {
                    var type = $('#trashed_file_image').is(':checked') == true ? 'trashed' :
                        'nottrashed';
                    d.gallery_id = gallery_id;
                    d.type = type;
                }
            }
        });
    });
</script>
