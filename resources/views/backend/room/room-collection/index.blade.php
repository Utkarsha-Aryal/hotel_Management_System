@extends('backend.layouts.main')

@section('title')
    Rooms
@endsection
<style>
    input#trashed_file {
        border: 1px solid rgb(0, 99, 198) !important
    }
.no-spinner::-webkit-outer-spin-button,
.no-spinner::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
</style>
@section('main-content')
    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div class="my-auto">
            <h5 class="page-title fs-21 mb-1">Our Rooms</h5>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Main Contents</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Our Rooms</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <div class="pe-1 mb-xl-0">
                <button type="button" class="btn btn-primary addNewsButton" id ="addRow" ><i class="fa fa-add"></i> Add Row</button>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="postModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                {{-- Content goes here --}}
            </div>
        </div>
    </div>
    <!-- Page Header Close -->
    <!-- Start::row-1 -->
    {{-- crop modal-start --}}

    <div class="modal cropModel fade" id="cropModel" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
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
                                <img id="image" src="#" style="height: 200px; width: 250px;">
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
    </div>
    {{-- crop modal-end --}}

    <div class="row ">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Rooms List
                    </div>
                    <div class="row ms-0">
                        <div class="form-check col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <input class="form-check-input" type="checkbox" value="Y" id="trashed_file"
                                name="trashed_file">
                            <label class="form-check-label" for="trashed_file">
                                View Trashed
                            </label>
                            <select class="form-select category " aria-label="Default select example" id="Category_selected" name="category_id">
                        -<option value="">Select All </option>
                             @foreach ($category as $roomcategory)
                        <option value="{{ $roomcategory->id }}" 
                            @if (isset($prevPost) && $prevPost->category_id == $roomcategory->id) selected @endif>
                        {{ $roomcategory->category }}
                           </option>
                    @endforeach
                    </select>

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div id="datatable-basic_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 mb-3">
                                    <div class="Table" id="">
                                        <table id="roomCollection"
                                            class="table table-bordered text-nowrap w-100 dataTable no-footer mt-3">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Category</th>
                                                    <th>Order</th>
                                                    <th>Max Occupancy</th>
                                                    <th>Room no</th>
                                                    <th>Floor no</th>
                                                    <th>Room view</th>
                                                    <th>Smoking</th>
                                                    <th>Room Status</th>
                                                    <th>Room Size</th>
                                                    <th>Posted By</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="write">
                                                <!-- rows will be dynamically populated -->
                                            </tbody>
                                            <tbody id="read">
                                                

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
    {{-- crop image-start --}}
    <script>
        var cropper;
        $(document).ready(function() {

            //cancel Crop Model --Start
            $('.cancelCrop').off('click', '');
            $('.cancelCrop').on('click', function(e) {

                var thumbnail_image = $('.thumbnail_image')[0].files[0];
                $('._image').attr('src', URL.createObjectURL(thumbnail_image));
                $('#cropModel').modal('hide');
            });
            //close Model --End

            //to pass image url to crop model ---Start
            $('.thumbnail_image').off('change');
            $('.thumbnail_image').on("change", function(e) {
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

            // Add new Row
            let counter = 1;
            $('#addRow').on('click',function(){
                $('#roomCollection  #write').append(`
                <tr>
                <td>#</td>
                    <td>
                    <select class="form-select category " aria-label="Default select example" id="Category" name="category_id">
                        -<option value="">Select Category </option>
                             @foreach ($category as $roomcategory)
                        <option value="{{ $roomcategory->id }}" 
                            @if (isset($prevPost) && $prevPost->category_id == $roomcategory->id) selected @endif>
                        {{ $roomcategory->category }}
                           </option>
                    @endforeach
                    </select>
                    </td>
                    <td><input type="number" class="form-control order no-spinner" name = "order"  placeholder="Order"></td>
                    <td><input type="number" class="form-control maximum_occupancy no-spinner" name ="maximum_occupancy" placeholder="Max Occupancy"></td>
                     <td><input type="number" class="form-control room_no no-spinner" placeholder="Room no" name = "room_no"></td>
                    <td><input type="number" class="form-control floor_no no-spinner" placeholder="floor no" name="floor_no"></td>
                     <td><input type="text" class="form-control room_view " placeholder="Room view" name = 'name = 'room_view'></td>
                     <td><select class="form-select smoking" id = "smoking" name='smoking'>
                            <option value="">Select Smoking </option>
                            <option value="Y">Allowed </option>
                            <option value="N">Not Allowed</option>
                        </select></td>
                    <td><select class="form-select room_status" name='room_status'>
                            <option value="">Select Room Status</option>
                            <option value="Available">Available </option>
                            <option value="Occupied">Occupied</option>
                            <option value="Maintenance">Maintenance</option>
                            <option value="Blocked">Blocked</option>
                        </select>
                    </td>

                    <td>
                    <input type="number" class="form-control room_size" name = "room_size" placeholder = "Room Size">
                    </td>
                    <td>
                     @if (Auth::user()) {{ Auth::user()->full_name }} @endif
                    </td>
                    <td>
                        <input type="hidden" class="form-control id">
                        <button class="btn btn-success btn-sm saveRow">Save</button>
                    </td>

                </tr>

                `);
            })
        });
    </script>

    <script>
        var RoomTable;
        $(document).ready(function() {
            // Save Row
        $(document).on('click', '.saveRow', function () {
            const row = $(this).closest('tr');
            const data = {
                id: row.find('.id').val(),
                category: row.find('.category').val(),
                order: row.find('.order').val(),
                room_no: row.find('.room_no').val(),
                maximum_occupancy: row.find('.maximum_occupancy').val(),
                room_view: row.find('.room_view').val(),
                floor_no: row.find('.floor_no').val(),
                smoking: row.find('.smoking').val(),
                room_status: row.find('.room_status').val(),
                room_size: row.find('.room_size').val()
            };

            if (!data.category || !data.order || !data.room_no || !data.maximum_occupancy || !data.room_view || !data.floor_no || !data.smoking || !data.room_status) {
                alert('All fields are required.');
                return;
            }

            const formData = new FormData();
            Object.keys(data).forEach(key => formData.append(key, data[key]));

            $.ajax({
                url: "{{ route('admin.room.save') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.type === 'success') {
                        showNotification(response.message,'success');
                        row.find('.id').val(response.id);
                        reloadTable()
                    } else {
                        showNotification(response.message,'error');
                    }
                },
                error: function () {
                    showNotification(response.message,'error');
                }
            });
        });

            $('.addNewsButton').on('click', function(e) {
                e.preventDefault();
                var url = '';
                $.post(url, function(response) {
                    $('#postModal .modal-content').html(response);
                    $('#postModal').modal('show');
                });
            });
            
            reloadTable()
 $('#Category_selected').change(function(){
reloadTable()

})  
    
function reloadTable() {
    let type = $('#trashed_file').is(':checked') ? 'trashed' : 'nottrashed';
    let category_id = $('#Category_selected').val(); // Ensure category_id is dynamically retrieved

    $.ajax({
        type: "POST",
        url: '{{ route('admin.room.list') }}',
        data: {
            _token: '{{ csrf_token() }}', // Include CSRF token for POST requests in Laravel
            type: type,
            category_id: category_id
        },
        success: function(data) {
            const tableBody = $('#roomCollection #read');
            const tableBody2 = $('#roomCollection #write');
            tableBody.empty();
            tableBody2.empty();

            if (data.data && data.data.length > 0) {
    data.data.forEach((room, index) => {
        
        let categoryOptions = '<option value="">Select Category</option>';
        data.rc.forEach(r => {
                        const isSelected = room.category_id === r.id ? 'selected' : '';
                        categoryOptions += `<option value="${r.id}" ${isSelected}>${r.category}</option>`;
                    });

        tableBody.append(`
            <tr>
                <td>${index + 1}</td>
                <td>
                    <select class="form-select category" aria-label="Default select example" id="Category" name="category_id">
                    
                        
                        ${categoryOptions}
                    </select>
                </td>
                <td><input type="number" class="form-control order no-spinner" name="order" placeholder="Order" value="${room.order_number || ''}"></td>
                <td><input type="number" class="form-control maximum_occupancy no-spinner" name="maximum_occupancy" placeholder="Max Occupancy" value="${room.max_occupancy || ''}"></td>
                <td><input type="number" class="form-control room_no no-spinner" name="room_no" placeholder="Room no" value="${room.room_no || ''}"></td>
                <td><input type="number" class="form-control floor_no no-spinner" name="floor_no" placeholder="Floor no" value="${room.floor_no || ''}"></td>
                <td><input type="text" class="form-control room_view" name="room_view" placeholder="Room view" value="${room.room_view || ''}"></td>
                <td>
                    <select class="form-select smoking" id="smoking" name="smoking">
                        <option value="">Select Smoking</option>
                        <option value="Y" ${room.smoking === 'Y' ? 'selected' : ''}>Allowed</option>
                        <option value="N" ${room.smoking === 'N' ? 'selected' : ''}>Not Allowed</option>
                    </select>
                </td>
                <td>
                    <select class="form-select room_status" name="room_status">
                        <option value="">Select Room Status</option>
                        <option value="Available" ${room.room_status === 'Available' ? 'selected' : ''}>Available</option>
                        <option value="Occupied" ${room.room_status === 'Occupied' ? 'selected' : ''}>Occupied</option>
                        <option value="Maintenance" ${room.room_status === 'Maintenance' ? 'selected' : ''}>Maintenance</option>
                        <option value="Blocked" ${room.room_status === 'Blocked' ? 'selected' : ''}>Blocked</option>
                    </select>
                </td>
                <td><input type="number" class="form-control room_size" name="room_size" placeholder="Room Size" value="${room.room_size || ''}"></td>
                <td>@if (Auth::user()) {{ Auth::user()->full_name }} @endif</td>
                <td>
                    <input type="hidden" class="form-control id" value="${room.id}">
                    <button class="btn btn-primary btn-sm saveRow">Update</button>
                    <button class="btn btn-danger btn-sm deleteRow">Delete</button>
                </td>
            </tr>
        `);
    });
} else {
    tableBody.append('<tr><td colspan="12">Data not found</td></tr>');
}

        },
        error: function(err) {
            console.error(err.responseText);
        }
    });
}
            // Edit news-start
            $(document).off('click', '.editNews');
            $(document).on('click', '.editNews', function() {
                var id = $(this).data('id');
                var url = '';
                var data = {
                    id: id
                };
                $.post(url, data, function(response) {
                    $('#feature_images').val('');
                    $('#postModal .modal-content').html(response);
                    $('#postModal').modal('show');
                });
            });
            //edit news -end

            // view trashed items-start
            $('#trashed_file').off('change');
            $('#trashed_file').on('change', function(e) {
                postTable.draw();
            });
            // view trashed items-ends


            // Delete news
            $(document).off('click', '.deleteNews');
            $(document).on('click', '.deleteNews', function() {

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
                        showLoader();
                        var id = $(this).data('id');
                        var data = {
                            id: id,
                            type: type,
                        };
                        var url = '';
                        $.post(url, data, function(response) {
                            //var result = JSON.parse(response);
                            if (response) {
                                if (response.type === 'success') {
                                    showNotification(response.message, 'success');
                                    postTable.draw();
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

            //Restore
            $(document).off('click', '.restore');
            $(document).on('click', '.restore', function() {
                Swal.fire({
                    title: "Are you sure you want to restore Post?",
                    text: "This will restore the Post.",
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
                        var url = '';
                        $.post(url, data, function(response) {
                            if (response) {
                                if (response.type === 'success') {
                                    showNotification(response.message, 'success');
                                    postTable.draw();
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

            //View Post
            $(document).off('click', '.viewPost');
            $(document).on('click', '.viewPost', function() {
                var id = $(this).data('id');
                var url = '';
                var data = {
                    id: id
                };
                $.post(url, data, function(response) {
                    $('#postModal .modal-content').html(response);
                    $('#postModal').modal('show');
                });
            });

        });
    </script>
@endsection
