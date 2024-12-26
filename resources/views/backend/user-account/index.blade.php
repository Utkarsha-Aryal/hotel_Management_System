@extends('backend.layouts.main')

@section('title')
User Account
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
        <h5 class="page-title fs-21 mb-1">User Account</h5>
    </div>
    <div class="d-flex my-xl-auto right-content">
        <div class="pe-1 mb-xl-0">
            <button type="button" class="btn btn-primary edit data-id=" data-bs-toggle="modal" data-bs-target="#modal"><i class="fa fa-add"></i> Add</button>
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
                    Users List
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
                                                <th>User Name</th>
                                                <th>Email </th>
                                                <th>Gender</th>
                                                <th>Mobile Number</th>
                                                <!-- <th>Role</th> -->
                                                <th>Address</th>
                                                <th>Image</th>
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
            'columnDefs': [{
                    "targets": 0, // your case first column
                    "className": "text-center",
                    "width": "4%"
                },
                {
                    "targets": 2,
                    "className": "text-right",
                }
            ],
            "aoColumns": [{
                    "data": "sno"
                },
                {
                    "data": "name"
                },
                {
                    "data": "email"
                },
                {
                    "data":"gender"
                },
                {
                    "data": "mobile_number"
                },
                {
                    "data": "address"
                },
                {
                    "data": "image"
                },
                {
                    "data": "action"
                },
            ],
            "ajax": {
                "url": '{{ route("admin.account.list") }}',
                "type": "POST",
                "data": function(d) {
                    var type = $('#trashed_file').is(':checked') == true ? 'trashed' :
                        'nottrashed';
                    d.type = type;
                }
            },
            "initComplete": function() {
                // Ensure text input fields in the header for specific columns with placeholders
                this.api().columns([1, 2]).every(function() {
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


        // Edit user account
        $(document).off('click', '.edit');
        $(document).on('click', '.edit', function() {
            var id = $(this).data('id');
            var url = '{{route("admin.account.form")}}';
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
            table.draw();
        });
        // view trashed items-ends

        // Delete user account
        $(document).off('click', '.delete');
        $(document).on('click', '.delete', function() {
            var type = $('#trashed_file').is(':checked') == true ? 'trashed' :
                'nottrashed';

            Swal.fire({
                title: type === "nottrashed" ? "Are you sure you want to delete this user?" : "Are you sure you want to delete permanently  this item",
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
                    var url = '{{route("admin.account.delete")}}';
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

        // Regenerate user account
        $(document).off('click', '.regenerate');
        $(document).on('click', '.regenerate', function() {
            Swal.fire({
                title: "Are you sure you want to restore this user?",
                text: "This will restore the user account.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#28a745",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Regenerate it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    showLoader();
                    var id = $(this).data('id');
                    var data = {
                        id: id,
                        type: 'regenerate'
                    };
                    var url = '{{route("admin.account.regenerate")}}';
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