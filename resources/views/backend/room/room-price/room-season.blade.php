
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
                <form action="" method="POST" id="RoomCategory"
                    enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row gy-4">

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <input type="hidden" name="id" value="" id="id">
                                <label for="name" class="form-label">Season Category <span class="required-field">*</span></label>
                                <input type="text" class="form-control" id="name" placeholder="Enter Season name"
                                    name="Season Name">
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 mb-2">
                                <label for="order_number" class="form-label">Order <span
                                        class="required-field">*</span></label>
                                <input type="text" class="form-control" id="order_number" placeholder="Enter order..."
                                    name="order">
                            </div>
                            <div class="col-xl-12 col-lg-6 col-md-6 col-sm-6 datepick">
                                <label for="maximum occupancy" class="form-label">Start Date <span class="required-field">*</span></label>
                                <input type="text" id="nepali-datepicker" name="start_date" class="form-control" placeholder="Select start date">
                            </div>
                            <div class="col-xl-12 col-lg-6 col-md-6 col-sm-6 datepick">
                                <label for="maximum occupancy" class="form-label">End Date <span class="required-field">*</span></label>
                                <input type="text" id="nepal" name="end_date" class="form-control nepali-datepicker" placeholder="Select end date">
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
                                        <table id="roomCategoryTable"
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
    $(document).ready(function(){
        showDatePicker();
        $('.nepali-datepicker').nepaliDatePicker();

                $('#nepali-datepicker').on('focus', function () {
            // Apply custom styles directly when the input is focused
            $('#ndp-nepali-box').css({
                'top': '60px',
                'left': '10px',
                'position': 'absolute' // Ensure positioning is correct
            });
        });

        $('#nepal').on('focus', function () {
            // Remove the custom styles when the input loses focus
            $('#ndp-nepali-box').css({
                'top': '320px',
                'left': '290px',
                'position': 'absolute'
            });
        });

    })
</script>