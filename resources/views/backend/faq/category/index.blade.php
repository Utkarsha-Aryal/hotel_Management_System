@extends('backend.layouts.main')

@section('title')
FAQ Category
@endsection

@section('styles')
<style>
    label#upload-image-error {
        position: absolute;
        top: 8.2rem !important
    }
</style>
@endsection

@section('main-content')
<!-- Page Header -->
<div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
    <div class="my-auto">
        <h5 class="page-title fs-21 mb-1">FAQ Category</h5>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">FAQ</a></li>
                <li class="breadcrumb-item active" aria-current="page">FAQ Category</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header Close -->

<!-- Start::row-1 -->
<div class="row">
    <div class="col-xl-4">
        <div class="card custom-card">
            <form action="{{ route('admin.faq.category.save') }}" method="POST" id="faqForm">
                <input type="hidden" name="id" value="" id="id">

                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <label for="name" class="form-label">FAQ Category Name <span class="required-field">*</span></label>
                            <input type="text" class="form-control" id="name" placeholder="Enter faq eg:Main Questions" value="" name="name">
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <label for="order_number" class="form-label">FAQ Category Order <span class="required-field">*</span></label>
                            <input type="text" class="form-control" id="order_number" placeholder="FAQ Category Order" value="" name="order_number">
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <button type="button" class="btn btn-success saveData"><i class="fa fa-save"></i> Create FAQ</button>

                </div>
            </form>
        </div>
    </div>
    <div class="col-xl-8">
        <div class="card custom-card">
            <div class="card-header justify-content-between">
                <div class="card-title">
                    FAQ Category List
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
                                    <table id="faqTable" class="table table-bordered text-nowrap w-100 dataTable no-footer mt-3" aria-describedby="datatable-basic_info">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>FAQ Category </th>
                                                <th> Order </th>
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
    var faqTable;
    $(document).ready(function() {
        faqTable = $('#faqTable').DataTable({
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
                [2]
            ],
            "bSort": true,
            "bProcessing": true,
            "bServerSide": true,
            "oLanguage": {
                "sEmptyTable": "<p class='no_data_message'>No data available.</p>"
            },
            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [0,1,3]
            }],
            "aoColumns": [{
                    "data": "sno"
                },
                {
                    "data": "name"
                },
                {
                    "data": "order_number"
                },
                {
                    "data": "action"
                },
            ],
            "ajax": {
                "url": '{{ route("admin.faq.category.list") }}',
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


        $('#faqForm').validate({
            rules: {
                name: 'required',
                order_number: 'required',
            },
            message: {
                name: 'This is required field.',
                order_number: 'This is required field.',
            },
            highlight: function(element) {
                $(element).addClass('border-danger')
            },
            unhighlight: function(element) {
                $(element).removeClass('border-danger')
            },
        });


        // Save FAQ
        $('.saveData').off('click')
        $('.saveData').on('click', function() {
            if ($('#faqForm').valid()) {
                showLoader();

                // Submit the form using AJAX
                $('#faqForm').ajaxSubmit({
                    success: function(response) {
                        if (response.type === 'success') {
                            $('.saveData').html('<i class="fa fa-save"></i> Create FAQ');
                            showNotification(response.message, 'success');
                            faqTable.draw();
                            $('#faqForm')[0].reset();
                            $('#id').val('');
                            $('.saveData').removeClass('btn-primary').addClass('btn-success').html('<i class="fa fa-save"></i> Create FAQ');
                        } else {
                            showNotification(response.message, 'error');
                            hideLoader();

                        }
                        hideLoader();
                    },
                    error: function(xhr) {
                        var response = xhr.responseJSON;
                        showNotification(response && response.message ? response.message : 'Something went wrong. Please try again later', 'error');
                        hideLoader();
                    }
                });
            }
        });

        // Edit FAQ
        $(document).on('click', '.editFAQ', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            $('#id').val(id);
            $('#name').val($(this).data('name'));
            $('#order_number').val($(this).data('order_number'));

            if ($('#id').val()) {
                $('.saveData').removeClass('btn-success').addClass('btn-primary').html('<i class="fa fa-save"></i> Update FAQ');
            } else {
                $('.saveData').removeClass('btn-primary').addClass('btn-success').html('<i class="fa fa-save"></i> Create FAQ');
            }
        });


        // view trashed items-start
        $('#trashed_file').off('change');
        $('#trashed_file').on('change', function(e) {
            faqTable.draw();
        });
        // view trashed items-end

        // Delete FAQ
        $(document).off('click', '.deleteFAQ');
        $(document).on('click', '.deleteFAQ', function() {
            var type = $('#trashed_file').is(':checked') == true ? 'trashed' :
                'nottrashed';
            Swal.fire({
                title: type === "nottrashed" ? "Are you sure you want to delete this item" : "Are you sure you want to delete permanently  this item",
                text: "You won't be able to revert it!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DB1F48",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    showLoader();
                    var id = $(this).data('id');
                    var data = {
                        id: id,
                        type: type,
                    };
                    var url = '{{ route("admin.faq.category.delete") }}';
                    $.post(url, data, function(response) {
                        if (response) {
                            if (response.type === 'success') {
                                showNotification(response.message, response.type)
                                faqTable.draw();
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

         // Restore
         $(document).off('click', '.restore');
        $(document).on('click', '.restore', function() {
            Swal.fire({
                title: "Are you sure you want to restore this category?",
                text: "This will restore the category.",
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
                    var url = '{{ route("admin.faq.category.restore") }}';
                    $.post(url, data, function(response) {
                        if (response) {
                            if (response.type === 'success') {
                                showNotification(response.message, 'success');
                                faqTable.draw();
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