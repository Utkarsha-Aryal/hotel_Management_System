
<style>
    .tabs {
      display: flex;
      cursor: pointer;
      margin-top: 40px;
      background-color: #F1F1F1;
      padding: 10px;
      gap: 10px;
      .tab {
        flex: 1;
        padding: 10px;
        text-align: center;
        border-radius: 4px;
        border: none;
        background-color: #E6E6E6;
        font-size: 20px;
        font-weight: 500;
        &.active {
          border-bottom: 2px solid #E73C17;
        }
      }
    }

    .content {
      padding: 20px;
      display: none;
      &.active {
        display: block;
      }
    }
</style>



 <div class="row ">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Rooms List
                    </div>
                    <div class="row ms-0">
                        <div class="form-check col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <input class="form-check-input" type="checkbox" value="Y" id="trashed_file" name="trashed_file">

                            <label class="form-check-label"  for="trashed_file">
                                View Trashed
                            </label>
                            <select class="form-select category " aria-label="Default select example" id="Category_selected" name="category_id">
                        -<option value="">Select All </option>
                        <option value="" >
                           </option>
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
                                            class="table table-bordered text-nowrap w-100  no-footer">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th style="width: 20%;">Room no</th>
                                                    <th style="width: 2%;" >Floor no</th>

                                                    <th  style="width: 15%;"><select class="form-select smoking" id = "conditionsmoking" name='smoking'>
                            <option value=""> Wifi </option>
                            <option value="Y">Yes </option>
                            <option value="N">No</option>
                        </select></th>
                                                    <th  style="width: 20%;"><select class="form-select room_status" id="roomstatus" name='room_status'>
                            <option value=""> Air Conditioning</option>
                            <option value="Y">Yes </option>
                            <option value="N">No</option>
                        </select></th>
                                                    <th><select class="form-select room_status" id="roomstatus" name='room_status'>
                            <option value=""> Mini Bar</option>
                            <option value="Y">Yes </option>
                            <option value="N">No</option>
                        </select></th>
                                                    <th><select class="form-select room_status" id="roomstatus" name='room_status'>
                            <option value=""> Television</option>
                            <option value="Y">Yes </option>
                            <option value="N">No</option>
                        </select></th>
                        <th><select class="form-select room_status" id="roomstatus" name='room_status'>
                            <option value=""> Television</option>
                            <option value="Y">Yes </option>
                            <option value="N">No</option>
                        </select></th>
                        <th><select class="form-select room_status" id="roomstatus" name='room_status'>
                            <option value=""> Toiletries</option>
                            <option value="Y">Yes </option>
                            <option value="N">No</option>
                        </select></th>
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


