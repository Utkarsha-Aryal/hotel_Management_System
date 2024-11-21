@extends('backend.layouts.main')
@section('title', 'Room Category')
@section('main-content')

<!-- Page Header -->
<div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
    <div class="my-auto">
        <h5 class="page-title fs-21 mb-1">Room Category</h5>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header d-flex justify-content-between">
                <h6 class="card-title">Room Categories</h6>
                <button class="btn btn-primary btn-sm" id="addRow">Add Row</button>
            </div>
            <div class="card-body">
                <table id="roomCategoryTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Room Category</th>
                            <th>Order</th>
                            <th>Bed Type</th>
                            <th>Maximum Occupancy</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Rows will be dynamically populated --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    var RoomCategoryTable;

    $(document).ready(function () {
        // Initialize DataTable
        RoomCategoryTable = $('#roomCategoryTable').DataTable({
            "sPaginationType": "full_numbers",
            "lengthMenu": [
                [-1],
                [ "All"]
            ],
            "iDisplayLength": "-1",
            "bProcessing": true,
            "bServerSide": true,
            "ajax": {
                "url": '{{ route('admin.rooms.list') }}',
                "type": "POST",
                "data": function (d) {
                    d._token = "{{ csrf_token() }}";
                }
            },
            "columns": [
                { "data": "sno" },
                { "data": "Room_Category" },
                { "data": "order" },
                { "data": "bed_type" },
                {
                    "data": "maximum_occupancy"
                },
                {
                    "data": "image",
                },
                {
                    "data": "action",
                    "render": function (data, type, row) {
                        return `
                            <button class="btn btn-success btn-sm saveRow">Save</button>
                            <button class="btn btn-danger btn-sm deleteRow">Delete</button>
                        `;
                    }
                }
            ],
            "oLanguage": {
                "sEmptyTable": "<p class='no_data_message'>No data available.</p>"
            }
        });

        let counter = 1;

        // Add New Row
        $('#addRow').on('click', function () {
            $('#roomCategoryTable tbody').append(`
                <tr>
                    <td>${counter++}</td>
                    <td><input type="text" class="form-control category" placeholder="Enter Category"></td>
                    <td><input type="number" class="form-control order no-spinner" placeholder="Order"></td>
                    <td>
                        <select class="form-select bed_type">
                            <option value="">Select Bed Type</option>
                            <option value="Single Bed">Single Bed</option>
                            <option value="Double Bed">Double Bed</option>
                            <option value="Queen Bed">Queen Bed</option>
                            <option value="King Bed">King Bed</option>
                            <option value="Twin Bed">Twin Bed</option>
                        </select>
                    </td>
                    <td><input type="number" class="form-control maximum_occupancy no-spinner" placeholder="Max Occupancy"></td>
                    <td>
                        <input type="file" class="form-control image_upload">
                        <img src="{{ asset('/images/no-image.jpg') }}" class="image-preview" width="50">
                    </td>
                    <td>
                        <input type="hidden" class="form-control id">
                        <button class="btn btn-success btn-sm saveRow">Save</button>
                        <button class="btn btn-danger btn-sm deleteRow">Delete</button>
                    </td>
                </tr>
            `);
        });

        // Save Row
        $(document).on('click', '.saveRow', function () {
            const row = $(this).closest('tr');
            const data = {
                id: row.find('.id').val(),
                category: row.find('.category').val(),
                order: row.find('.order').val(),
                bed_type: row.find('.bed_type').val(),
                maximum_occupancy: row.find('.maximum_occupancy').val(),
                image: row.find('.image_upload')[0]?.files[0],
            };

            if (!data.category || !data.order || !data.bed_type || !data.maximum_occupancy) {
                alert('All fields are required.');
                return;
            }

            const formData = new FormData();
            Object.keys(data).forEach(key => formData.append(key, data[key]));

            $.ajax({
                url: "{{ route('admin.rooms.save') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.type === 'success') {
                        alert('Saved successfully!');
                        row.find('.id').val(response.id);
                        RoomCategoryTable.ajax.reload(); // Reload DataTable
                    } else {
                        alert(response.message);
                    }
                },
                error: function () {
                    alert('Error saving data.');
                }
            });
        });

        // Delete Row
        $(document).on('click', '.deleteRow', function () {
            const row = $(this).closest('tr');
            const id = row.find('.id').val();

            if (id) {
                if (confirm('Are you sure you want to delete this record?')) {
                    $.ajax({
                        url: "{{ route('admin.rooms.delete') }}",
                        type: "DELETE",
                        data: { id: id, _token: "{{ csrf_token() }}" },
                        success: function (response) {
                            if (response.type === 'success') {
                                alert('Deleted successfully!');
                                RoomCategoryTable.ajax.reload(); // Reload DataTable
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function () {
                            alert('Error deleting data.');
                        }
                    });
                }
            } else {
                row.remove();
            }
        });

        // Image Preview
        $(document).on('change', '.image_upload', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    $(this).siblings('.image-preview').attr('src', e.target.result);
                }.bind(this);
                reader.readAsDataURL(file);
            }
        });
    });
</script>

@endsection
