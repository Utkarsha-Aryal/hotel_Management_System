
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

  
.datepickss{
    position: relative;
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
    #ndp-nepali-box {
        top: 50px !important;
        left: 10px !important;
    }
   
</style>
<div class="row">
        <div class="col-xl-4">
            <div class="card custom-card">
                <form action="{{route('admin.season-setting.save')}}" method="POST" id="RoomPrice"
                    enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row gy-4">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <input type="hidden" name="id" value="" id="id">
                                <label for="name" class="form-label">Season Category <span class="required-field">*</span></label>
                                <input type="text" class="form-control" id="name" placeholder="Enter Season name"
                                    name="Season_Name">
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 mb-2">
                                <label for="order_number" class="form-label">Order <span
                                        class="required-field">*</span></label>
                                <input type="text" class="form-control" id="order_number" placeholder="Enter order..."
                                    name="order">
                            </div>
                            <div class="col-xl-12 col-lg-6 col-md-6 col-sm-6 datepick">
                                <label for="maximum occupancy" class="form-label">Start Date <span class="required-field">*</span></label>
                                <input type="text" id="nepali-datepicker-work-order" name="start_date" class="form-control" placeholder="Select start date">
                            </div>
                            <div class="col-xl-12 col-lg-6 col-md-6 col-sm-6 datepickss">
                                <label for="maximum occupancy" class="form-label">End Date <span class="required-field">*</span></label>
                                <input type="text" id="nepali-datepicker-work-completion" name="end_date" class="form-control nepali-datepicker" placeholder="Select end date">
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
                                        <table id="SeasonTable"
                                            class="table table-bordered text-nowrap w-100 dataTable no-footer mt-3"
                                            aria-describedby="datatable-basic_info">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Season Name</th>
                                                    <th>Order</th>
                                                    <th>start date</th>
                                                    <th>end date</th>
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
        var SeasonTable; 
    $(document).ready(function(){
        $("#nepali-datepicker-work-order").nepaliDatePicker({
            container: ".datepick"
        });
        $("#nepali-datepicker-work-completion").nepaliDatePicker({
            container: ".datepickss"
        });
        
        $('#RoomPrice').validate({
            rules:{
                Season_Name:'required',
                order:'required',
                start_date:'required',
                end_date:'required'
            },
            messages: {
                Season_Name:{
                    required: "Please enter the season name"
                },
                order:{
                    required: "Please enter the order number"
                },
                start_date:{
                    required: "Please enter when the season starts"
                },
                end_date:{
                    required: "Please enter when the season ends"
                }
            },
            highlight: function(element) {
                $(element).addClass('border-danger')
            },
            unhighlight: function(element) {
                $(element).removeClass('border-danger')
            },
        })




        $('.saveData').off('click')
        $('.saveData').on('click',function(){
            console.log('clicked')
            if($('#RoomPrice').valid()){
                showLoader();
                $('#RoomPrice').ajaxSubmit({
                    success: function(response){
                        if(response.type==='Success'){
                            SeasonTable.draw();
                            $('.saveData').html('<i class="fa fa-save"></i> Save');
                            showNotification(response.message,'success');
                            $('#RoomPrice')[0].reset();
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
        }
    })

        SeasonTable = $('#SeasonTable').DataTable({
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
                        "data": "season_name"
                    },
                    {
                        "data": "order"
                    },
                    {
                        "data":'start_date'
                    },
                    {
                        "data":'end_date'
                    },
                    {
                        "data": "action"
                    },
                ],
                "ajax": {
                    "url": '{{route('admin.season-setting.list')}}',
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

        $(document).off('click','.editRoomCategory');
        $(document).on('click','.editRoomCategory',function(){
            var id = $(this).data('id');
            var order = $(this).data('order');
            var start_date = $(this).data('start_date');
            var end_date = $(this).data('end_date');
            var Season_name = $(this).data('season_name');
                 $('#RoomPrice input[name = "id"]').val(id);
                $('#RoomPrice input[name = "order"]').val(order);
                $('#RoomPrice input[name = "start_date"]').val(start_date);
                $('#RoomPrice input[name = "Season_Name"]').val(Season_name);
                $('#RoomPrice input[name = "end_date"]').val(end_date);
            if ($('#id').val()) {
                $('.saveData').removeClass('btn-success').addClass('btn-primary').html(
                     '<i class="fa fa-save"></i> Update Season');
                } else {
                    $('.saveData').removeClass('btn-primary').addClass('btn-success').html(
                     '<i class="fa fa-save"></i> Save ');
                }
        });

        $('#trashed_file').off('change');
            $('#trashed_file').on('change', function(e) {
                SeasonTable.draw();
            });

        $(document).off('click','.deleteRoomCategory');
        $(document).on('click','.deleteRoomCategory',function(){
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
                    var url = '{{route('admin.season-setting.delete')}}'
                    $.post(url,data,function(response){
                        if(response){
                            if(response.type==='success'){
                                showNotification(response.message, response.type)
                                SeasonTable.draw();
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
                    var url = '{{route('admin.season-setting.restore')}}'
                    $.post(url,data,function(response){
                        if(response){
                        if(response.type==="success"){
                            showNotification(response.message,'success');
                            SeasonTable.draw();
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

    })
</script>