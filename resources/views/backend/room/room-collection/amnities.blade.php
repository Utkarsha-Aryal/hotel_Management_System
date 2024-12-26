
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
                                                    <th >Room no</th>
                                                    <th style="width: 2%;" >Floor no</th>

                                                    <th><select class="form-select smoking" id = "conditionsmoking" name='smoking'>
                            <option value=""> Wifi </option>
                            <option value="Y">Yes </option>
                            <option value="N">No</option>
                        </select></th>
                                                    <th  ><select class="form-select room_status" id="roomstatus" name='room_status'>
                            <option value=""> AC</option>
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
                            <option value=""> hairdryer</option>
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
</div>

<script>
    $(document).ready(function(){
    reloadTable();
    function reloadTable(){
        $.ajax({
            type: 'POST',
            url: '{{route('admin.room-setting.list')}}',
            data: {
            _token: '{{ csrf_token() }}'
       },
       success:function(data){
        const tableBody = $('#roomCollection #read');
        tableBody.empty();
        if(Array.isArray(data.data) && data.data.length > 0){
            data.data.forEach((room,index)=>{
                tableBody.append(`
            <tr>
                <td>${index + 1}</td>
                <td>${room.room_no || ''}</td>
                <td>${room.floor_no || ''}</td>
                <td>
                    <select class="form-select wifi" id="smoking" name="smoking">
                        <option value="">Select Wifi</option>
                        <option value="Y" ${room.wifi === 'Y' ? 'selected' : ''}>Yes</option>
                        <option value="N" ${room.wifi === 'N' ? 'selected' : ''}>No</option>
                    </select>
                </td>
                <td>
                    <select class="form-select room_AC" name="room_AC">
                        <option value="">Select AC</option>
                        <option value="Y" ${room.AC === 'Y' ? 'selected' : ''}>Yes</option>
                        <option value="N" ${room.AC === 'N' ? 'selected' : ''}>No</option>
                    </select>
                </td>
                  <td>
                    <select class="form-select room_mini_bar" name="room_status">
                        <option value="">Select Mini Bar</option>
                        <option value="Y" ${room.Mini_Bar === 'Y' ? 'selected' : ''}>Yes</option>
                        <option value="N" ${room.Mini_Bar === 'N' ? 'selected' : ''}>No</option>
                    </select>
                </td>
                  <td>
                    <select class="form-select room_tv" name="room_status">
                        <option value="">Select TV</option>
                        <option value="Y" ${room.TV === 'Y' ? 'selected' : ''}>Yes</option>
                        <option value="N" ${room.TV === 'N' ? 'selected' : ''}>No</option>
                    </select>
                </td>
                   <td>
                    <select class="form-select room_hairdeyer" name="room_status">
                        <option value="">Select Mini Bar</option>
                        <option value="Y" ${room.hairdryer === 'Y' ? 'selected' : ''}>Yes</option>
                        <option value="N" ${room.hairdryer === 'N' ? 'selected' : ''}>No</option>
                    </select>
                </td>
                  <td>
                    <select class="form-select room_toiletries" name="room_status">
                        <option value="">Select Mini Bar</option>
                        <option value="Y" ${room.Toiletries === 'Y' ? 'selected' : ''}>Yes</option>
                        <option value="N" ${room.Toiletries === 'N' ? 'selected' : ''}>No</option>
                    </select>
                </td>
                <td>
                    <input type="hidden" class="form-control id" value="${room.id}">
                    <button class="btn btn-primary btn-sm update"><i class="fa fa-save"></i> update</button>

                </td>
            </tr>
        `);
            })

        }
       }

        })
    }
    $(document).off('click', '.update');
    $(document).on('click','.update',function(){
        const row = $(this).closest('tr');
        const data = {
            id: row.find('.id').val(),
            wifi: row.find('.wifi').val(),
            AC : row.find('.room_AC').val(),
            Mini_Bar: row.find('.room_mini_bar').val(),
            room_tv: row.find('.room_tv').val(),
            room_hairdeyer: row.find('.room_hairdeyer').val(),
            room_toiletries: row.find('.room_toiletries').val(),
        }
        const formData = new FormData();
        Object.keys(data).forEach(key => formData.append(key, data[key]));

        $.ajax({
                url: "{{ route('admin.room-setting.save') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.type === 'success') {
                        showNotification(response.message,'success');
                        row.find('.id').val(response.id);
                        reloadTable()
                    } else if (response.type === 'error'){
                        reloadTable()
                        showNotification(response.message,'error');
                    }
                },
                error: function (xhr) {
                    hideLoader();
            const errorMessage = xhr.responseJSON?.message || 'An unexpected error occurred.';
            showNotification(errorMessage, 'error');
            reloadTable()
                }
            });
    })    
})
</script>


