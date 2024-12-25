
<style>
    .ql-container {
        height: 200px;
    }

    .ql-editor {
        min-height: 100% !important;
    }

    input[type="file"] {
        display: block;
    }

    .imageThumb {
        max-height: 75px;
        border: 2px solid;
        margin-left: 10px;
        margin-bottom: 3px;
        padding: 1px;
        cursor: pointer;
    }

    .pip {
        display: inline-block;
        margin: 10px 10px 0 0;
    }


    .cropper-container {
        width: 100% !important;
    }

    .modal-header {
        position: relative;
    }

    .modal-header .closeCrop {
        position: absolute;
        top: 13px;
        right: 15px;
    }

    label#thumbnail_image-error {
        position: absolute;
        top: 9rem !important
    }

  

    input#nepali-datepicker {
        width: 100% !important;
        height: 50% !important;
        border-radius: 0.2rem !important;
        border: 0.1px solid rgb(236, 231, 231);
        padding-left: 0.5rem !important;
    }
    input#nepali-datepicker {
        width: 100% !important;
        height: 50% !important;
        border-radius: 0.2rem !important;
        border: 0.1px solid rgb(236, 231, 231);
        padding-left: 0.5rem !important;
    }
   
</style>
<div class="row">
        <div class="col-xl-4">
            <div class="card custom-card">
                <form action="{{route('admin.price-setting.save')}}" method="POST" id="RoomPrice"
                    enctype="multipart/form-data">
                    <div class="card-body">

                        <div class="row gy-4">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <select class="form-select category " aria-label="Default select example" id="Category" name="category_id">
                         <option value="">Select  Room Category </option>
                             @foreach ($category as $roomcategory)
                       <option value="{{ $roomcategory->id }}" 
                                ${selectedCategory == '{{ $roomcategory->id }}' ? 'selected' : ''}>
                                {{ $roomcategory->category }}
                       </option>
                                 @endforeach
                            </select>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <select class="form-select season " aria-label="Default select example" id="season" name="season_id">
                         <option value="">Select Season </option>
                             @foreach ($season as $seasoncategory)
                       <option value="{{ $seasoncategory->id }}" 
                                ${selectedCategory == '{{ $seasoncategory->id }}' ? 'selected' : ''}>
                                {{ $seasoncategory->name }}
                       </option>
                                 @endforeach
                            </select>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 mb-2">
                                <label for="order_number" class="form-label">price <span
                                        class="required-field">*</span></label>
                                <input type="hidden" name="id" value="" id="id">
                                <input type="text" class="form-control" id="price" placeholder="Enter price..."
                                    name="price">
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 mb-2">
                                <label for="order_number" class="form-label">order number <span
                                        class="required-field">*</span></label>
                                <input type="text" class="form-control" id="order_number" placeholder="Enter order..."
                                    name="order">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <button type="button" class="btn btn-primary savePrice"><i class="fa fa-save"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                     Season List
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
                                        <table id="RoomPriceTable"
                                            class="table table-bordered text-nowrap w-100 dataTable no-footer mt-3"
                                            aria-describedby="datatable-basic_info">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Category Name</th>
                                                    <th>Season Name</th>
                                                    <th>Order</th>
                                                    <th>price</th>
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
        var RoomPriceTable;
        $(document).ready(function(){
            $('.savePrice').off('click')
        $('.savePrice').on('click',function(){
            console.log('clicked')
                showLoader();
                $('#RoomPrice').ajaxSubmit({
                    success: function(response){
                        if(response.type==='Success'){
                            $('.savePrice').html('<i class="fa fa-save"></i> Save');
                            showNotification(response.message,'success');
                            $('#RoomPrice')[0].reset();
                            RoomPriceTable.draw();
                            $('#id').val('');
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
        })
        RoomPriceTable = $('#RoomPriceTable').DataTable({
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
                        "data": "category_name"
                    },
                    {
                        "data": "season_name"
                    },
                    {
                        "data":'order'
                    },
                    {
                        "data":'price'
                    },
                    {
                        "data": "action"
                    },
                ],
                "ajax": {
                    "url": '{{route('admin.price-setting.list')}}',
                    "type": "POST",
                    "data": function(d) {
                        var type = $('#trashed_file').is(':checked') == true ? 'trashed' :
                            'nottrashed';
                        d.type = type;
                    }
               }
        })

        $(document).off('click','.deletePrice');
        $(document).on('click','.deletePrice',function(){
            var type = $('#trashed_file').is(':checked')== true ? ' trashed': 'nottrashed';
            Swal.fire({
                title: type === "nottrashed"? "Are you sure you want to delete this Season":
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
                    var url = '{{route('admin.price-setting.delete')}}'
                    $.post(url,data,function(response){
                        if(response){
                            if(response.type==='success'){
                                showNotification(response.message, response.type)
                                RoomPriceTable.draw();
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
        
        $('#trashed_file').off('change');
            $('#trashed_file').on('change', function(e) {
                RoomPriceTable.draw();
            });
       

        $(document).off('click','.editRoomPrice');
        $(document).on('click','.editRoomPrice',function(){
            var id = $(this).data('id');
            var order = $(this).data('order');
            var price = $(this).data('price');
            var category_id = $(this).data('category_name');
            var Season_name = $(this).data('season_name');
                 $('#RoomPrice input[name = "id"]').val(id);
                $('#RoomPrice input[name = "order"]').val(order);
                $('#RoomPrice input[name = "price"]').val(price);
                $('#RoomPrice select[name = "category_id"]').val(category_id);
                $('#RoomPrice select[name = "season_id"]').val(Season_name);
            if ($('#id').val()) {
                $('.saveData').removeClass('btn-success').addClass('btn-primary').html(
                     '<i class="fa fa-save"></i> Update Season');
                } else {
                    $('.saveData').removeClass('btn-primary').addClass('btn-success').html(
                     '<i class="fa fa-save"></i> Save ');
                }
        });

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
                    var url = '{{route('admin.price-setting.restore')}}'
                    $.post(url,data,function(response){
                        if(response){
                        if(response.type==="success"){
                            showNotification(response.message,'success');
                            RoomPriceTable.draw();
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
    });
    </script>