@extends('backend.layouts.main')

@section('title')
    Why To Choose Us ?
@endsection

@section('styles')
    <style>
        .iconpicker-popover.popover.bottom {
            opacity: 1;
        }

        label#file_input-error {
            position: absolute;
            top: 8.3rem !important;
            left: 1rem;
        }

        #edit-image {
            pointer-events: auto;
            cursor: pointer;
            /* Change cursor to pointer when hovering over edit-image */
        }
    </style>
@endsection

@section('main-content')
    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div class="my-auto">
            <h5 class="page-title fs-21 mb-1">Why To Choose Us ?</h5>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">About Us</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Why To Choose Us ?</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                {{-- Content goes here --}}
            </div>
        </div>
    </div>
    <!-- Page Header Close -->

    <!-- Start::row-1 -->
    <div class="row">
        <div class="col-xl-4">
            <div class="card custom-card">
                <form action="{{ route('admin.why.to.choose.us.save') }}" method="POST" id="why-to-choose-us-form">
                    <input type="hidden" name="id" id="id" value="">
                    <div class="card-body">
                        <div class="row gy-4">

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                <label for="title" class="form-label">Title <span class="required-field">*</span></label>
                                <input type="text" class="form-control" id="title"
                                    placeholder="Enter why to choose us title..." name="title">
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                <label for="order_number" class="form-label">Order <span
                                        class="required-field">*</span></label>
                                <input type="number" class="form-control" id="order_number" placeholder="Enter order..."
                                    name="order_number">
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <label for="description" class="form-label">Description <span
                                        class="required-field">*</span></label>
                                <textarea class="form-control" id="description" name="description" rows="3"
                                    placeholder="Enter why to choose us description..."></textarea>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <label for="affordability" class="form-label">Affordability<span
                                        class="required-field">*</span></label>
                                <textarea class="form-control" id="affordability" name="affordability" rows="3"
                                    placeholder="Enter why to choose us affordability..."></textarea>
                            </div>

            

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <label for="inspiring" class="form-label">Inspiring <span
                                        class="required-field">*</span></label>
                                <textarea class="form-control" id="inspiring" name="inspiring" rows="3"
                                    placeholder="Enter why to choose us inspiring..."></textarea>
                            </div>

                            <div class="row mt-2">
                                <label for="description" class="form-label">Icon <span
                                        class="required-field"></span></label>
                                <div class="col-10 relative" id="edit-image">

                                    <div class="profile-user">
                                        <label for="file_input"
                                            class="fe fe-camera profile-edit text-primary absolute"></label>
                                    </div>
                                    <input type="file" class="file_input" id="file_input"
                                        style="position: absolute; clip: rect(0, 0, 0, 0); pointer-events: none;"
                                        accept="image/*" name="icon">

                                    <div id="edit_image">
                                        <img src="{{ asset('/images/no-image.jpg') }}" width="160px" alt="Default Image"
                                            class='edit_image'>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4 ms-1">
                                <p class="p-0 m-0">Accepted Format :<span class="text-muted"> PNG</span></p>
                                <p class="p-0 m-0">File size :<span class="text-muted"> 512KB</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <button type="button" class="btn btn-primary saveData"><i class="fa fa-save"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Why To Choose Us List
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
                                        <table id="whyToChooseUsTable"
                                            class="table table-bordered text-nowrap w-100 dataTable no-footer mt-3"
                                            aria-describedby="datatable-basic_info">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Title</th>
                                                    <th>Image</th>
                                                    <th>Order</th>
                                                    <th>Action</th>
                                                </tr>
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
@endsection

@section('script')
    <script>
        var whyToChooseUsTable;
        $(document).ready(function() {
            whyToChooseUsTable = $('#whyToChooseUsTable').DataTable({
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
                    [3]
                ],
                "bProcessing": true,
                "bServerSide": true,
                "oLanguage": {
                    "sEmptyTable": "<p class='no_data_message'>No data available.</p>"
                },
                "aoColumnDefs": [{
                    "bSortable": false,
                    "aTargets": [0, 1, 2, 4]
                }],
                "aoColumns": [{
                        "data": "sno"
                    },
                    {
                        "data": "title"
                    },
                    {
                        "data": "icon"
                    },
                    {
                        "data": "order_number"
                    },
                    {
                        "data": "action"
                    },
                ],
                "ajax": {
                    "url": '{{ route('admin.why.to.choose.us.getlist') }}',
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

            //upload image

            $('#file_input').on('change', function(event) {
                var selectedFile = event.target.files[0];

                if (selectedFile) {
                    $('.edit_image').attr('src', URL.createObjectURL(selectedFile));
                }
            });
            //end upload image

            $('#why-to-choose-us-form').validate({
                rules: {
                    title: "required",
                    description: "required",
                    affordability: "required",
                    inspiring: "required",
                    order_number: "required",
                },
                message: {
                    title: {
                        required: "This field is required."
                    },
                    description: {
                        required: "This field is required."
                    },
                    affordability: {
                        required: "This field is required."
                    },
                    inspiring: {
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

            // Save testimonial
            $(document).off('click', '.saveData');
            $(document).on('click', '.saveData', function() {

                if ($('#why-to-choose-us-form').valid()) {
                    showLoader();
                    $('#why-to-choose-us-form').ajaxSubmit({
                        success: function(response) {
                            if (response) {
                                if (response.type === 'success') {
                                    $('.saveData').html('<i class="fa fa-save"></i> Save');
                                    showNotification(response.message, 'success');
                                    hideLoader();
                                    whyToChooseUsTable.draw();
                                    $('#why-to-choose-us-form')[0].reset();
                                    $('#id').val('');
                                    $('.edit_image').attr('src',
                                        '{{ asset('/images/no-image.jpg') }}');
                                } else {
                                    showNotification(response.message, 'error');
                                    hideLoader();
                                }
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

            // update editWhyToChooseUs
            $(document).on('click', '.editWhyToChooseUs', function(e) {
                e.preventDefault();
                var imageUrl = $(this).data('icon');
                $('#id').val($(this).data('id'));
                $('#title').val($(this).data('title'));
                $('#description').val($(this).data('description'));
                $('#affordability').val($(this).data('affordability'));
                $('#academics').val($(this).data('academics'));
                $('#inspiring').val($(this).data('inspiring'));
                $('#order_number').val($(this).data('order_number'));
                $('#icon').val($(this).data('icon'));
                var imageUrl = $(this).data('icon');
                $('#why-to-choose-us-form .edit_image').attr('src', imageUrl);
                $('.saveData').html('<i class="fa fa-save"></i> Update');
            });

            // view trashed items-start
            $('#trashed_file').off('change');
            $('#trashed_file').on('change', function(e) {
                whyToChooseUsTable.draw();
            });
            // view trashed items-ends

            /* Starts::View Training Detail */
            $(document).off('click', '.viewWhyChooseUs');
            $(document).on('click', '.viewWhyChooseUs', function() {
                var id = $(this).data('id');
                var url = '{{ route('admin.why.to.choose.us.view') }}';
                var data = {
                    id: id
                };
                $.post(url, data, function(response) {
                    $('#modal .modal-content').html(response);
                    $('#modal').modal('show');
                });
            });
            /* Ends::View Training Detail */

            // Delete Why To ChooseUs
            $(document).on('click', '.deleteWhyToChooseUs', function(e) {
                e.preventDefault();

                var type = $('#trashed_file').is(':checked') == true ? 'trashed' :
                    'nottrashed';

                Swal.fire({
                    title: type === "nottrashed" ? "Are you sure you want to delete this item" :
                        "Are you sure you want to delete permanently  this item",
                    text: "You won't be able to revert it!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DB1F48",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        var id = $(this).data('id');
                        var data = {
                            id: id,
                            type: type,
                        };
                        var url = '{{ route('admin.why.to.choose.us.delete') }}';
                        $.post(url, data, function(response) {
                            if (response) {
                                showNotification(response.message, response.type);
                                if (response.type === 'success') {
                                    whyToChooseUsTable.draw();
                                    $('#why-to-choose-us-form')[0].reset();
                                    $('#id').val('');
                                }
                            }
                        });
                    }
                });
            });

            // Restore
            $(document).off('click', '.restore');
            $(document).on('click', '.restore', function() {
                Swal.fire({
                    title: "Are you sure you want to restore this item?",
                    text: "This will restore the item.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#28a745",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Restore it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        showLoader();
                        var id = $(this).data('id');
                        var data = {
                            id: id,
                            type: 'restore'
                        };
                        var url = '{{ route('admin.why.to.choose.us.restore') }}';
                        $.post(url, data, function(response) {
                            if (response) {
                                if (response.type === 'success') {
                                    showNotification(response.message, 'success');
                                    whyToChooseUsTable.draw();
                                    hideLoader();
                                } else {
                                    showNotification(response.message, 'error');
                                    hideLoader();
                                }
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
