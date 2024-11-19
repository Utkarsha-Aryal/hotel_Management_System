@extends('backend.layouts.main')

@section('title')
    Document
@endsection
@section('styles')
    <style>
    .iconpicker-popover.popover.bottom {
            opacity: 1;
        }

        /* For Chrome, Safari, Edge, and Opera */
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

     .invisible-file-input {

    visibility: hidden; /* Hides the element but keeps its space in the document flow */
    position: absolute; /* Removes from normal flow */
}
        /* For Firefox */
        input[type="number"] {
            -moz-appearance: textfield;
        }

        #file_input {
            display: none;

        }

        #drop-area {
            border: 2px dashed #ccc;
            border-radius: 4px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            position: relative;
            border-color: blue;
        }

        #drop-area.dragover {
            border-color: #333;
        }

        #file-name {
            display: block;
            margin-top: 10px;
            color: #333;
        }
    </style>
    </style>

    </style>
    </style>

    </style>
@endsection
@section('main-content')
    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div class="my-auto">
            <h5 class="page-title fs-21 mb-1">Documents</h5>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Main Contents</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Documents</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header Close -->

    <!-- Start::row-1 -->
    <div class="row">
        <div class="col-xl-4">
            <div class="card custom-card">
                <form action="{{ route('admin.document.save') }}" method="POST" id="form"
                    enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row gy-4">

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <input type="hidden" name="id" value="" id="id">
                                <label for="title" class="form-label">Title <span class="required-field">*</span></label>
                                <input type="text" class="form-control" id="title" placeholder="Enter file name..."
                                    name="title">
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <label for="details" class="form-label">Details <span class="required-field">*</span>
                                </label>
                                <textarea class="form-control" id="details" name="details" rows="3" placeholder="Enter about file..."></textarea>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <label for="order" class="form-label">Order <span class="required-field">*</span>
                                </label>
                                <input type="number" class="form-control" id="order" name="order" rows="3"
                                    placeholder="Enter order number"></input>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <label for="formFile" class="form-label">Attach File <span
                                        class="required-field">*</span></label>
                                <div id="drop-area" name="drop" class="drop-area">
                                    <p id="drop-text">Drag & drop a file here, or click to select one</p>
                                    <span id="file-name"></span>
                                </div>
                                <input class="form-control invisible-file-input" type="file" id="file_input"
                                        style="display: block; "name="file">


                            </div>
                            <div class="row mt-2 ms-1">
                                <p class="p-0 m-0">Accepted File :<span class="text-muted"> PDF</span></p>
                                <p class="p-0 m-0">File size :<span class="text-muted"> Less Than 2MB</span></p>
                            </div>
                            <div class="col-4 d-flex"id="edit_image">
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
                        File list
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
                                                    <th>File Name</th>
                                                    <th>About file</th>
                                                    <th>order</th>
                                                    <th>File</th>
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
                        "data": "title"
                    },
                    {
                        "data": "details"
                    },
                    {
                        "data": "order"

                    },

                    {
                        "data": "file",
                        "render": function(data) {
                            var url = '{{ asset('storage/document/') }}' + '/' + data;
                            return '<a class="btns primary_blue_btn" href="' + url +
                                '" target="_blank"><i class="fa-solid fa-file-pdf"></i>Open</a>';
                        }
                    },
                    {
                        "data": "action"

                    },
                ],
                "ajax": {
                    "url": '{{ route('admin.document.list') }}',
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

            // Save document item

            //upload File

            $('#file_input').on('change', function(event) {
                var selectedFile = event.target.files[0];

                if (selectedFile) {
                    $('.edit_image').hide();
                }
            });
            //end upload file

            $('#form').validate({
                rules: {

                    title: "required",
                    details: "required",
                    order: "required",
                    file: {
                        required: function() {
                            var id = $('#id').val();
                            return id === '';
                        }
                    },

                },
                message: {
                    title: {
                        required: "This field is required."
                    },

                    details: {
                        required: "This field is required."
                    },
                    file: {
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
                    $('#form').ajaxSubmit(function(response) {
                        var result = JSON.parse(response);
                        if (result) {
                            if (result.type === 'success') {
                                $('.saveData').html('<i class="fa fa-save"></i> Save');
                                showNotification(result.message, 'success');
                                hideLoader();
                                table.draw();
                                $('#form')[0].reset();
                                $('#id').val('');
                                $('.edit_image').hide();
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
            // update document file
            $(document).on('click', '.edit', function(e) {
                e.preventDefault();

                $('#id').val($(this).data('id'));
                $('#title').val($(this).data('title'));
                $('#details').val($(this).data('details'));
                $('#order').val($(this).data('order'));
                var currentFileName = $(this).data('file')
                $('#edit_image').html('');

                // Dynamically add the image to the div
                $('#edit_image').append('<a href="{{ asset('storage/document/') }}/' + currentFileName +
                    '" target="_blank"><img src="{{ asset('pdf.png') }}" width="100px" alt="Default Image" class="edit_image"></a>'
                );
                $('.saveData').html('<i class="fa fa-save"></i> Update');
            });



            // view trashed items-start
            $('#trashed_file').off('change');
            $('#trashed_file').on('change', function(e) {
                table.draw();
            });
            // view trashed items-ends



            // Delete document file
            $(document).on('click', '.delete', function(e) {
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
                        var url = '{{ route('admin.document.delete') }}';
                        $.post(url, data, function(response) {
                            var rep = JSON.parse(response);
                            if (rep) {
                                showNotification(rep.message, rep.type);
                                if (rep.type === 'success') {
                                    table.draw();
                                    $('#form')[0].reset();
                                    $('#id').val('');
                                }
                            }
                        });
                    }
                });
            });

            $(document).off('click', '.restore');
            $(document).on('click', '.restore', function() {
                Swal.fire({
                    title: "Are you sure you want to restore this document?",
                    text: "This will restore the document.",
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
                        var url = '{{ route('admin.document.restore') }}';
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




<script>
document.addEventListener('DOMContentLoaded', function () {
    const dropArea = document.getElementById('drop-area');
    const fileInput = document.getElementById('file_input');
    const fileNameSpan = document.getElementById('file-name');
    const dropText = document.getElementById('drop-text');
     const saveButton = document.querySelector('.saveData');


    // Prevent default behaviors for drag and drop
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
    });

    // Highlight drop area when file is dragged over
    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, () => dropArea.classList.add('highlight'), false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, () => dropArea.classList.remove('highlight'), false);
    });

    // Handle file drop
    dropArea.addEventListener('drop', handleDrop, false);

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;

        // Only one file is expected in this case
        if (files.length > 0) {
            const file = files[0];

            // Validate file type (only pdf)
            if (file.type !== 'application/pdf') {
                alert('Only PDF files are allowed!');
                return;
            }

            // Assign the file to the input element
            fileInput.files = files;

            // Update the displayed file name
            fileNameSpan.textContent = file.name;
            dropText.style.display = 'none';
        }
    }

    // Handle clicking on the drop area to trigger file input
    dropArea.addEventListener('click', function () {
        fileInput.click();
    });

    // Update file name when selected via input
    fileInput.addEventListener('change', function () {
        if (fileInput.files.length > 0) {
            fileNameSpan.textContent = fileInput.files[0].name;
            dropText.style.display = 'none';
        }
    });

        saveButton.addEventListener('click', function () {
        fileNameSpan.textContent = '';  
        dropText.style.display = 'block';  
        dropText.textContent = 'Drag & drop a file here, or click to select one';  
        dropArea.classList.remove('highlight');
    });



})
</script>

