@extends('backend.layouts.main')

@section('title')
Our Values
@endsection

@section('styles')
<style>
    .iconpicker-popover.popover.bottom {
        opacity: 1;
    }
</style>
@endsection

@section('main-content')
<!-- Page Header -->
<div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
    <div class="my-auto">
        <h5 class="page-title fs-21 mb-1">Our Values</h5>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">About Us</a></li>
                <li class="breadcrumb-item active" aria-current="page">Our Values</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
            <form action="{{ route('admin.values.save') }}" method="POST" id="form" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row gy-4">

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <input type="hidden" name="id" value="" id="id">
                            <label for="title" class="form-label">Title <span class="required-field">*</span></label>
                            <input type="text" class="form-control" id="title" placeholder="Enter file name..." name="title">
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <label for="details" class="form-label">Details </label>
                            <textarea class="form-control" id="details" name="details" rows="3" placeholder="Enter Values..."></textarea>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group select-style">
                                <label for="order" class="form-label">Order <span class="required-field">*</span></label>
                                <input type="text" class="form-control" id="order" name="order" placeholder="Enter order..." value="">
                            </div>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <label for="meta_description" class="form-label">Meta Description </label>
                            <textarea class="form-control" id="meta_description" name="meta_description" rows="3" placeholder="Enter meta description..."></textarea>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <label for="meta_key" class="form-label">Meta Keywords</label>
                            <input type="text" class="form-control" id="meta_key" placeholder="Enter file name..." name="meta_keywords">
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
                    Values list
                </div>
                <div class="row ms-0">
                    <div class="form-check col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <input class="form-check-input" type="checkbox" value="Y" id="trashed_file" name="trashed_file">
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
                                    <table id="table" class="table table-bordered text-nowrap w-100 dataTable no-footer mt-3" aria-describedby="datatable-basic_info">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Title</th>
                                                <th>Details</th>
                                                <th>Order</th>
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
@endsection

@section('script')
<script>
    var table;
    $(document).ready(function() {
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
                [3]
            ],
            "bProcessing": true,
            "bServerSide": true,
            "oLanguage": {
                "sEmptyTable": "<p class='no_data_message'>No data available.</p>"
            },
            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [0,1,2,4]
            }],
            "aoColumns": [{
                    "data": "sno"
                },
                {
                    "data": "title"
                },
                {
                    "data": "details"
                },

                {
                    "data": "order",
                },
                {
                    "data": "action"

                },
            ],
            "ajax": {
                "url": "{{ route('admin.values.list') }}",
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

        $('#form').validate({
            rules: {

                title: "required",
                details: "required",
                order: "required",
            },
            message: {
                title: {
                    required: "This field is required."
                },

                details: {
                    required: "This field is required."
                },
                order: {
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


        // Save document item
        $('.saveData').off('click', );
        $('.saveData').on('click', function() {
            if ($('#form').valid()) {
                showLoader();
                $('#form').ajaxSubmit({
                    success: function(response) {
                        if (response) {
                            if (response.type === 'success') {
                                $('.saveData').html('<i class="fa fa-save"></i> Save');
                                showNotification(response.message, 'success');
                                hideLoader();
                                table.draw();
                                $('#form')[0].reset();
                                $('#id').val('');
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
                        showNotification(response && response.message ? response.message : 'An error occurred', 'error');
                    }
                });
            }
        });



        // update document file
        $(document).off('click', '.edit');
        $(document).on('click', '.edit', function() {
            var id = $(this).data('id');
            var title = $(this).data('title');
            var details = $(this).data('details');
            var order = $(this).data('order');
            $('#form input[name="id"]').val(id);
            $('#form input[name="title"]').val(title);
            $('#form textarea[name="details"]').val(details);
            $('#form input[name="order"]').val(order);
            $('.saveData').html('<i class="fa fa-save"></i> Update');
        });



        // view trashed items-start
        $('#trashed_file').off('change');
        $('#trashed_file').on('change', function(e) {
            table.draw();
        });
        // view trashed items-ends

        /* Starts::View Value Detail */
        $(document).off('click', '.viewValue');
        $(document).on('click', '.viewValue', function() {
            var id = $(this).data('id');
            var url = '{{ route("admin.values.view") }}';
            var data = {
                id: id
            };
            $.post(url, data, function(response) {
                $('#modal .modal-content').html(response);
                $('#modal').modal('show');
            });
        });
        /* Ends::View Value Detail */



        // Delete document file
        $(document).on('click', '.delete', function(e) {
            e.preventDefault();
            var type = $('#trashed_file').is(':checked') == true ? 'trashed' :
                'nottrashed';

            Swal.fire({
                title: type === "nottrashed" ? "Are you sure you want to delete this item?" : "Are you sure you want to delete permanently  this item?",
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
                    var url = "{{ route('admin.values.delete') }}";
                    $.post(url, data, function(response) {

                        if (response) {
                            showNotification(response.message, response.type);
                            if (response.type === 'success') {
                                table.draw();
                                $('#form')[0].reset();
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
                    var url = '{{ route("admin.values.restore") }}';
                    $.post(url, data, function(response) {
                        if (response) {
                            if (response.type === 'success') {
                                showNotification(response.message, 'success');
                                table.draw();
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