@extends('backend.layouts.main')

@section('title')
    Gallery
@endsection
<style>
    input#trashed_file {
        border: 1px solid rgb(0, 99, 198) !important
    }

    label#upload-image-error {
        position: absolute;
        top: 8.2rem !important
    }
</style>
@section('main-content')
    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div class="my-auto">
            <h5 class="page-title fs-21 mb-1">Gallery</h5>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Gallery</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header Close -->

    <!-- Start::row-1 -->
    <div class="row">
        <div class="col-xl-4">
            <div class="card custom-card">
                <form action="{{ route('admin.gallery.save') }}" method="POST" id="form"
                    enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <input type="hidden" name="id" value="" id="id">
                                <label for="name" class="form-label">Album Name <span
                                        class="required-field">*</span></label>
                                <input type="text" class="form-control" id="name" placeholder="Enter album name"
                                    name="name">
                            </div>
                        </div>

                        <div class="row">
                            <div class="row mt-3 d-flex align-items-center">
                                <div class="col-6">
                                    <label for="image" class="form-label">Thumnnail Image <span
                                            class="required-field">*</span></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-10 relative" id="edit-image">

                                    <div class="profile-user">
                                        <label for="upload-image"
                                            class="fe fe-camera profile-edit text-primary absolute"></label>
                                    </div>
                                    <input type="file" class="upload-image" id="upload-image"
                                        style="position: absolute; clip: rect(0, 0, 0, 0); pointer-events: none;"
                                        accept="image/*"name="image">
                                    <input type="hidden" class="form-control croppedImg" id="croppedImg" name="croppedImg">
                                    <img src="{{ asset('/no-image.jpg') }}" width="160px" alt="Default Image"
                                        class='_image'>
                                </div>
                            </div>
                            <div class="row ms-1 mt-4">
                                <p class="p-0 m-0">Accepted Format :<span class="text-muted"> jpg/jpeg/png</span></p>
                                <p class="p-0 m-0">File size :<span class="text-muted"> (300x475) in pixels</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <button type="button" class="btn btn-primary saveData"><i class="fa fa-save"></i> Create
                            album</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Gallery List
                    </div>
                    <div class="row ms-0">
                        <div class="form-check col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <input class="form-check-input" type="checkbox" value="Y" id="trashed_file"
                                name="trashed_file">
                            <label class="form-check-label" for="trashed_file">
                                View Trashed
                            </label>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div id="datatable-basic_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 mb-3">
                                    <div class="dataTables_length" id="datatable-basic_length">
                                        <table id="table"
                                            class="table table-bordered text-nowrap w-100 dataTable no-footer mt-3"
                                            aria-describedby="datatable-basic_info">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Album Name</th>
                                                    <th>Thumbnail Image</th>
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
        </div>
    </div>
    <!--End::row-1 -->
    <!-- Modal -->

    <div class="modal fade" id="imageModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                {{-- Content goes here --}}
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var table;
        $(document).ready(function() {
            //add image
            $(document).on('click', '.addImageButton', function() {
                var id = $(this).data('id');
                var data = {
                    id: id
                };
                var url = '{{route('admin.gallery.image.index')}}';
                $.post(url, data, function(response) {
                    $('#imageModel .modal-content').html(response);
                    $('#imageModel').modal('show');
                });
            });

            


            table = $('#table').DataTable({
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
                    "sEmptyTable": "<p class='no_data_message'>No data available.</p>"
                },
                "aoColumnDefs": [{
                    "bSortable": false,
                    "aTargets": [1]
                }],
                "aoColumns": [{
                        "data": "sno"
                    },
                    {
                        "data": "name"
                    },
                    {
                        "data": "image"
                    },

                    {
                        "data": "action"
                    },
                ],
                "ajax": {
                    "url": '{{ route('admin.gallery.list') }}',
                    "type": "POST",
                    "data": function(d) {
                        var type = $('#trashed_file').is(':checked') == true ? 'trashed' :
                            'nottrashed';
                        d.type = type;
                    }
                },
                "initComplete": function() {
                    // Ensure text input fields in the header for specific columns with placeholders
                    this.api().columns([1]).every(function() {
                        var column = this;
                        var input = document.createElement("input");
                        var columnName = column.header().innerText.trim();
                        // Append input field to the header, set placeholder, and apply CSS styling
                        $(input).appendTo($(column.header()).empty())
                            .attr('placeholder', columnName).css('width',
                                '100%') // Set width to 100%
                            .addClass(
                                'search-input-highlight') // Add a CSS class for highlighting
                            .on('keyup change', function() {
                                column.search(this.value).draw();
                            });
                    });
                }
            });
            //upload slider image-start
            $('#upload-image').on('change', function(event) {
                var selectedFile = event.target.files[0];
                if (selectedFile) {
                    $('._image').attr('src', URL.createObjectURL(selectedFile));
                }
            });
            //upload slider image-end

            $('#form').validate({
                rules: {
                    name: 'required',
                    image: {
                        required: function() {
                            var id = $('#id').val();
                            return id === '';
                        }
                    }
                },
                message: {
                    name: 'This is required field.',
                    image: 'This is required field.',
                },
                highlight: function(element) {
                    $(element).addClass('border-danger')
                },
                unhighlight: function(element) {
                    $(element).removeClass('border-danger')
                },
            });


            // Save Gallery
            $('.saveData').off('click')
            $('.saveData').on('click', function(e) {
                if ($('form').valid()) {
                    showLoader();
                    $('#form').ajaxSubmit(function(response) {
                        var result = JSON.parse(response);
                        if (result) {
                            if (result.type === 'success') {
                                $('.saveData').html('<i class="fa fa-save"></i> Create album');
                                showNotification(result.message, 'success');
                                hideLoader();
                                table.draw();
                                $('#form')[0].reset();
                                $('#id').val('');
                                $('._image').attr('src', "{{ asset('/no-image.jpg') }}");
                            } else {
                                showNotification(result.message, 'error');
                                hideLoader();
                            }
                        } else {
                            hideLoader();
                        }
                    });
                }
            });
            // Edit Gallery
            $(document).on('click', '.editGallery', function(e) {
                e.preventDefault();
                var id = $(this).data('id')
                $('#id').val(id);
                $('#name').val($(this).data('name'));
                var imageUrl = $(this).data('image');
                $('._image').attr('src', `{{ asset('/storage/gallery-image') }}/${imageUrl}`);
                $('#id').val(id);
                if ((id)) {
                    $('.saveData').html('<i class="fa fa-save"></i> Update album');
                }
            });


            // view trashed items-start
            $('#trashed_file').off('change');
            $('#trashed_file').on('change', function(e) {
                table.draw();
            });

            // view trashed items-end


            // Delete gallery
            $(document).on('click', '.deleteGallery', function(e) {
                e.preventDefault();
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
                        var type = $('#trashed_file').is(':checked') == true ? 'trashed' :
                            'nottrashed';
                        var data = {
                            id: id,
                            type: type,
                        };
                        var url = '{{ route('admin.gallery.delete') }}';
                        $.post(url, data, function(response) {
                            var rep = JSON.parse(response);
                            if (rep) {
                                showNotification(rep.message, rep.type)

                                if (rep.type === 'success') {
                                    table.draw();
                                    $('#service-form')[0].reset();
                                    $('#id').val('');
                                }
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
