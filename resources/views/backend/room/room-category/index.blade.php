@extends('backend.layouts.main')
 @section('title')
 Room Category
 @endsection
 @section('main-content')
 <!-- Page Header -->
 <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div class="my-auto">
            <h5 class="page-title fs-21 mb-1">Room Category</h5>
        </div>
    </div>
<style>
.no-spinner::-webkit-outer-spin-button,
.no-spinner::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

</style>

    <!-- Modal -->
    <div class="modal fade" id="testimonialModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
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
                <form action="{{route('admin.rooms.save')}}" method="POST" id="RoomCategory"
                    enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row gy-4">

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <input type="hidden" name="id" value="" id="id">
                                <label for="name" class="form-label">Room Category <span class="required-field">*</span></label>
                                <input type="text" class="form-control" id="name" placeholder="Enter Room name"
                                    name="category">
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 mb-2">
                                <label for="order_number" class="form-label">Order <span
                                        class="required-field">*</span></label>
                                <input type="text" class="form-control" id="order_number" placeholder="Enter order..."
                                    name="order">
                            </div>
                            <div class="col-xl-12 col-lg-6 col-md-6 col-sm-6">
                                <label for="maximum occupancy" class="form-label">Maximum occupancy <span class="required-field">*</span></label>
                                <input type="text" class="form-control"  placeholder="Enter maximum occupancy"name="maximum_occupancy">
                            </div>

                            <div class="col-xl-12 col-lg-6 col-md-6 col-sm-6">
                                <label for="bed_type" class="form-label"> Bed type <span class="required-field">*</span></label>
                                <select  class="form-select" name="bed_type" id="bed_type">
                                    <option value="">Select Bed type</option>
                                    <option value="Single Bed">Single Bed</option>
                                    <option value="Double Bed">Double Bed</option>
                                    <option value="Queen Bed">Queen Bed</option>
                                    <option value="King Bed">King Bed</option>
                                    <option value="Twin Bed">Twin Bed</option>
                                </select>
                            </div>

                            <div class="row mt-2">
                                <label for="review" class="form-label">Photo</label>
                                <div class="col-10 relative" id="edit-image">

                                    <div class="profile-user">
                                        <label for="file_input"
                                            class="fe fe-camera profile-edit text-primary absolute"></label>
                                    </div>
                                    <img id="upload-image" src="{{ asset('/images/no-image.jpg') }}" width="160px"
                                        alt="Default Image" class='_image'>
                                </div>
                                <input type="file" class="file_input" id="file_input"
                                        style="position: absolute; clip: rect(0, 0, 0, 0); pointer-events: none;"
                                        accept="image/*" name="image">
                            </div>
                            <div class="row mt-4 ms-1">
                                <p class="p-0 m-0">Accepted Format :<span class="text-muted"> jpg/jpeg/png</span></p>
                                <p class="p-0 m-0">File size :<span class="text-muted"> 512KB </span></p>
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
                        Room Categories List
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
                                        <table id="roomCategoryTable"
                                            class="table table-bordered text-nowrap w-100 dataTable no-footer mt-3"
                                            aria-describedby="datatable-basic_info">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Room Category</th>
                                                    <th>Order</th>
                                                    <th>Bed Type</th>
                                                    <th>Image</th>
                                                    <th>Maximum Occupancy</th>
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

    <script>
    var RoomCategoryTable;
    $(document).ready(function(){
        RoomCategoryTable = $('#roomCategoryTable').DataTable({
            "sPaginationType": "full_numbers",
            "bSearchable": false,
            "lengthMenu":[
                [5,10,15,20,25,-1],
                [5,10,15,20,25,"All"]
            ],
            'iDisplayLength':15,
            "sDom": 'ltipr',
            "bAutoWidth": false,
            "aaSorting":[
                [2]
            ],
            'bSort': true,
            'bProcessing':true,
            "bServerSide": true,
            "oLanguage": {
                "sEmptyTable": "<p class='no_data_message'>No data available.</p>"
            },
            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [0, 1,3,4,5]
             }],
             "aoColumns": [{
                        "data": "sno"
                    },
                    {
                        "data": "Room_Category"
                    },
                    {
                        "data": "order"
                    },
                    {
                        "data":'bed_type'
                    },
                    {
                        "data":'image'
                    },
                    {
                        "data":'maximum_occupancy'

                    },
                    {
                        "data": "action"
                    },
                ],
                "ajax": {
                    "url": '{{route('admin.rooms.list')}}',
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
        })
        //upload image
        $('#file_input').on('change', function(event) {
                var selectedFile = event.target.files[0];
                if (selectedFile) {
                    $('._image').attr('src', URL.createObjectURL(selectedFile));
                }
            });
         //end upload image

        // save data
        $('.saveData').off('click')
        $('.saveData').on('click',function(){
            console.log('clicked')
            if($('#RoomCategory').valid()){
                showLoader();
                $('#RoomCategory').ajaxSubmit({
                    success: function(response){
                        if(response.type==='success'){
                            RoomCategoryTable.draw();
                            $('.saveData').html('<i class="fa fa-save"></i> Create Room Category');
                            showNotification(response.message,'success');
                            $('#RoomCategory')[0].reset();
                            $('#id').val('');
                            $('.saveData').removeClass('btn-primary').addClass('btn-success').html('<i class="fa fa-save"></i> Create Room Category');
                            $('._image').attr('src', "{{ asset('/images/no-image.jpg') }}");

                        }else{
                            showNotification(response.message,'error');
                            hideLoader();
                        }
                        hideLoader();
                                    },
                                    error: function(xhr) {
                    hideLoader();
                    var response = xhr.responseJSON;

                    // Check if there are validation errors
                    if (response && response.errors) {
                        var errorMessages = '';

                        // Loop through all the validation errors and concatenate them
                        $.each(response.errors, function(field, messages) {
                            messages.forEach(function(message) {
                                // Escape HTML and concatenate with newline
                                errorMessages += escapeHtml(message) + '\n';
                            });
                        });

                        // Show all errors in the notification, or a default message if there are no errors
                        showNotification(errorMessages || 'An error occurred', 'error');
                    } else {
                        // If there are no specific validation errors, show a generic error message
                        showNotification(response ? response.message : 'An error occurred', 'error');
                    }
                }


                })
            }

        })


        $('#RoomCategory').validate({
            rules:{
                category : 'required',
                bed_type:"required",
                maximum_occupancy: 'required',
                image:{
                    required: function() {
                        var id = $('#id').val();
                        return id === '';
                    }
                },
                order:'required'
            },
            messages: {
    category: {
        required: "The title field is required."
    },
    maximum_occupancy: {
        required: "The maximum occupancy field is required to be filled"
    },
    order: {
        required: "The order number field is required."
    },
    image: {
        required: "Please insert image."
    },
    bed_type: {
        required: "Please select one of the options "
    },
    order: {
        required: 'Please enter the order number'
    }

},
highlight: function(element) {
                $(element).addClass('border-danger')
            },
            unhighlight: function(element) {
                $(element).removeClass('border-danger')
            },
        })
        
        // Edit Program
        $(document).off('click','.editRoomCategory');
        $(document).on('click','.editRoomCategory',function(){
            var id = $(this).data('id');
            var image = $(this).data('image');
            var order = $(this).data('order');
            var maximum_occupancy = $(this).data('maximum_occupancy');
            var bed_type = $(this).data('bed_type');
            var category = $(this).data('category');
            console.log(category);
            $('#RoomCategory input[name = "id"]').val(id);
                $('#RoomCategory input[name = "order"]').val(order);
                $('#RoomCategory select[name = "bed_type"]').val(bed_type);
                $('#RoomCategory input[name = "category"]').val(category);
                $('#RoomCategory input[name = "maximum_occupancy"]').val(maximum_occupancy);
                $('#RoomCategory ._image').attr('src', image);
            if ($('#id').val()) {
                $('.saveData').removeClass('btn-success').addClass('btn-primary').html(
                     '<i class="fa fa-save"></i> Update ');
                } else {
                    $('.saveData').removeClass('btn-primary').addClass('btn-success').html(
                     '<i class="fa fa-save"></i> Create ');
                }
        });
        // view trashed items-start
        $('#trashed_file').off('change');
            $('#trashed_file').on('change', function(e) {
                RoomCategoryTable.draw();
            });
            // view trashed items-end

        // Delete Room category
        $(document).off('click','.deleteRoomCategory');
        $(document).on('click','.deleteRoomCategory',function(){
            var type = $('#trashed_file').is(':checked')== true ? ' trashed': 'nottrashed';
            Swal.fire({
                title: type === "nottrashed"? "Are you sure you want to delete this category":
                    "Are you sure you want to delete permanently this category",
                text: "You won't be alble to revert it!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DB1F48",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Delete it!"
            }).then((result)=>{
                if(result.isConfirmed){
                    showLoader();
                    var id = $(this).data('id');
                    var data ={
                        id: id,
                        type: type,
                    };
                    var url = '{{route('admin.rooms.delete')}}'
                    $.post(url,data,function(response){
                        if(response){
                            if(response.type==='success'){
                                showNotification(response.message, response.type)
                                RoomCategoryTable.draw();
                                hideLoader();
                            }else{
                                showNotification(response.message,'error');
                                hideLoader();
                            }
                        }
                    })
                }
            })
        })

        // Restore
        $(document).off('click','.restore');
        $(document).on('click','.restore',function(){
            Swal.fire({
                title: 'Are you sure you want to restore this category?',
                text: 'This will restore the category',
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#28a745",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Restore it!"
            }).then((result)=>{
                if(result.isConfirmed){
                    showLoader();
                    var id = $(this).data('id');
                    var data = {
                        id: id,
                        type: 'restore'
                    };
                    var url = '{{route('admin.rooms.restore')}}'
                    $.post(url,data,function(response){
                        if(response){
                        if(response.type==="success"){
                            showNotification(response.message,'success');
                            RoomCategoryTable.draw();
                            hideLoader();
                        }else{
                            showNotification(response.message,'error');
                            hideLoader();
                        }
                    }
                })
                }
            })
        })

        $(document).off('click','.viewRoomCategory');
        $(document).on('click','.viewRoomCategory',function(){
            var id = $(this).data('id');
            var url = '{{route('admin.rooms.view')}}';
            var data = {
                    id: id
                };
             $.post(url, data, function(response) {
                 $('#testimonialModal .modal-content').html(response);
                 $('#testimonialModal').modal('show');
            });

        })

    })

</script>

 @endsection
