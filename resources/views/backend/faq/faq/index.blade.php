@extends('backend.layouts.main')

@section('title')
FAQ
@endsection
@section('styles')
<style>
    .fa-eye {
        color: green;
        font-size: 1rem;
    }
</style>
@endsection


@section('main-content')
<!-- Page Header -->
<div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
    <div class="my-auto">
        <h5 class="page-title fs-21 mb-1">FAQ</h5>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">FAQ</a></li>
                <li class="breadcrumb-item active" aria-current="page">FAQ</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex my-xl-auto right-content">
        <div class="pe-1 mb-xl-0">
            <button type="button" class="btn btn-primary addFAQ data-id=" data-bs-toggle="modal" data-bs-target="#modal"><i class="fa fa-add"></i> Add FAQ</button>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {{-- Content goes here --}}
        </div>
    </div>
</div>
<!-- Page Header Close -->
<!-- Start::row-1 -->
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header justify-content-between">
                <div class="card-title">
                    FAQ List
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
                                                <th>FAQ Category</th>
                                                <th>Question</th>
                                                <th>Answer </th>
                                                <th>Order </th>
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
                [4]
            ],
            "bSort": true,
            "bProcessing": true,
            "bServerSide": true,
            "oLanguage": {
                "sEmptyTable": "<p class='no_data_message'>No data available.</p>"
            },
            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [0,1,2,3,5]
            }],
            "aoColumns": [{
                    "data": "sno"
                },
                {
                    "data": "faq_category"
                },
                {
                    "data": "question"
                },
                {
                    "data": "answer"
                },
                {
                    "data": "order_number"
                },
                {
                    "data": "action"
                },
            ],
            "ajax": {
                "url": '{{ route("admin.faq.list") }}',
                "type": "POST",
                "data": function(d) {
                    var type = $('#trashed_file').is(':checked') == true ? 'trashed' :
                        'nottrashed';
                    d.type = type;
                }
            },
            "initComplete": function() {
                // Ensure text input fields in the header for specific columns with placeholders
                this.api().columns([2]).every(function() {
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


        // addFAQ user account
        $(document).off('click', '.addFAQ');
        $(document).on('click', '.addFAQ', function() {
            var id = $(this).data('id');
            var url = '{{ route("admin.faq.form") }}';
            var data = {
                id: id
            };
            $.post(url, data, function(response) {
                $('#modal .modal-content').html(response);
                $('#modal').modal('show');
            });
        });

        // view trashed items-start
        $('#trashed_file').off('change');
        $('#trashed_file').on('change', function(e) {
            faqTable.draw();
        });
        // view trashed items-ends

        /* Starts::View Training Detail */
        $(document).off('click', '.viewFaq');
        $(document).on('click', '.viewFaq', function() {
            var id = $(this).data('id');
            var url = '{{ route("admin.faq.view") }}';
            var data = {
                id: id
            };
            $.post(url, data, function(response) {
                $('#modal .modal-content').html(response);
                $('#modal').modal('show');
            });
        });
        /* Ends::View Faq Detail */

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
                    var url = '{{ route("admin.faq.delete") }}';
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

         // Restore
         $(document).off('click', '.restore');
        $(document).on('click', '.restore', function() {
            Swal.fire({
                title: "Are you sure you want to restore this faq?",
                text: "This will restore the faq.",
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
                    var url = '{{ route("admin.faq.restore") }}';
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