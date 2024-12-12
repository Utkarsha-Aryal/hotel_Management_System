<?php

namespace App\Http\Controllers\backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomCategory;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Common;
use App\Http\Requests\OurRoomRequest;


class RoomController extends Controller
{

    public function save(OurRoomRequest $request)
    {
        try {
            $post = $request->all();
            $type = 'success';
            $message = 'Records saved sucessfully';
            if(!empty($post['id'])){
                $message = 'Records updated sucessfully';
            }
            DB::beginTransaction();

            $result = Room::saveData($post);

            if(!$result){
                throw new Exception('Could not save record',1);
              
            }
            DB::commit();

        } catch (ValidationException $e) {
            $type = 'error';
            $message = $e->getMessage();
        } catch(QueryException $e){
            DB::rollBack();
            $type = 'error';
            $message = $e->getMessage();
        }catch (Exception $e){
            DB::rollBack();
            $type = "error";
            $message = $e->getMessage();

        }
        return response()->json(['type' => $type, 'message' => $message]);
    }

    public function list(Request $request)
    {
        $post = $request->all();
        // Fetch the rooms data based on the request
        $data = Room::getlist($post);
    
        // Apply the map function to modify the action field based on the request type
        $data = $data->map(function ($room) use ($post) {
            if ($post['type'] === "trashed") {
                $room->action = '
                    <a href="javascript:;" class="restoreRow" data-id="' . $room->id . '"><i class="fa-solid fa-undo text-success"></i></a>|
                    <a href="javascript:;" class="deleteRow" data-id="' . $room->id . '"><i class="fa fa-trash text-danger"></i></a>
                ';
            } else {
                $room->action = '
                    <a href="javascript:;" class="saveRow" data-id="' . $room->id . '"><i class="fa-solid fa-save text-primary"></i></a>|
                    <a href="javascript:;" class="deleteRow" data-id="' . $room->id . '"><i class="fa fa-trash text-danger"></i></a>
                ';
            }
            return $room;
        });
    
        // Fetch categories and users (assuming you have models for them)
        $categories = RoomCategory::all();
        $users = User::all();
    
        // Initialize the table rows HTML
        $tableRowsHtml = '';
    
        // Loop through the rooms and create the table rows HTML
        foreach ($data as $index => $room) {
            // Create category options
            $categoryOptions = '<option value="">Select Category</option>';
            foreach ($categories as $category) {
                $isSelected = ($room->category_id === $category->id) ? 'selected' : '';
                $categoryOptions .= "<option value='{$category->id}' {$isSelected}>{$category->category}</option>";
            }
    
            // Determine the posted by user
            $postedBy = 'Unknown';
            foreach ($users as $user) {
                if ($room->user_id === $user->id) {
                    $postedBy = $user->full_name;
                    break;
                }
            }
    
            // Generate the row HTML for each room
            $tableRowsHtml .= "
                <tr>
                    <td>" . ($index + 1) . "</td>
                    <td>
                        <select class='form-select category' name='category_id'>
                            {$categoryOptions}
                        </select>
                    </td>
                    <td><input type='number' class='form-control order no-spinner' name='order' placeholder='Order' value='{$room->order_number}'></td>
                    <td><input type='number' class='form-control maximum_occupancy no-spinner' name='maximum_occupancy' placeholder='Max Occupancy' value='{$room->max_occupancy}'></td>
                    <td><input type='number' class='form-control room_no no-spinner' name='room_no' placeholder='Room no' value='{$room->room_no}'></td>
                    <td><input type='number' class='form-control floor_no no-spinner' name='floor_no' placeholder='Floor no' value='{$room->floor_no}'></td>
                    <td><input type='text' class='form-control room_view' name='room_view' placeholder='Room view' value='{$room->room_view}'></td>
                    <td>
                        <select class='form-select smoking' name='smoking'>
                            <option value=''>Select Smoking</option>
                            <option value='Y' " . ($room->smoking === 'Y' ? 'selected' : '') . ">Yes</option>
                            <option value='N' " . ($room->smoking === 'N' ? 'selected' : '') . ">No</option>
                        </select>
                    </td>
                    <td>
                        <select class='form-select room_status' name='room_status'>
                            <option value=''>Select Room Status</option>
                            <option value='Available' " . ($room->room_status === 'Available' ? 'selected' : '') . ">Available</option>
                            <option value='Occupied' " . ($room->room_status === 'Occupied' ? 'selected' : '') . ">Occupied</option>
                            <option value='Maintenance' " . ($room->room_status === 'Maintenance' ? 'selected' : '') . ">Maintenance</option>
                            <option value='Blocked' " . ($room->room_status === 'Blocked' ? 'selected' : '') . ">Blocked</option>
                        </select>
                    </td>
                    <td><input type='number' class='form-control room_size' name='room_size' placeholder='Room Size' value='{$room->room_size}'></td>
                    <td>{$postedBy}</td>
                    <td>
                        <input type='hidden' class='form-control id' value='{$room->id}'>
                        {$room->action} <!-- Action buttons based on condition -->
                    </td>
                </tr>
            ";
        }
    
        // Return the HTML as a response along with categories and users data
        return response()->json([
            'html' => $tableRowsHtml,
            'categories' => $categories, // Passing the categories
            'users' => $users, // Passing the users
        ]);
    }
    
    
    public function delete(Request $request)
    {
        try
         {
            $type = 'success';
            $message = 'Record deleted sucessfully';
            $post = $request ->all();
            $class = new Room();

            DB::beginTransaction();
            $result = Common::deleteDataFileDoesnotExists($post,$class);
            if(!$result){
                throw new Exception("Couldn't delete record",1);
           }
           DB::commit();
        } catch(QueryException $e){
            DB::rollBack();
            $type ="error";
            $message = $this->queryMessage;
        }catch(Exception $e){
            DB::rollBack();
            $type = 'error';
            $message = $e->getMessage();

        }
        return response()->json(['type' => $type, 'message' => $message]);
    }

    public function restore(Request $request)
    {
        try {
            $post = $request->all();
            $type = 'success';
            $message = 'Restored sucessfully';
            DB::beginTransaction();
            $result = Room::restoreData($post);
            if(!$result){
                throw new Exception("Could not restore Category, Please try again",1);   
            }
            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            $type='error';
            $message = $this->queryMessage;
        }catch(Exception $e){
            DB::rollBack();
            $type = 'error';
            $message = $e->getMessage();
        }
        return response()->json(['type'=> $type,'message'=>$message]);
    }
}
