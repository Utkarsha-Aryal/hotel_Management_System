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
        $data = Room::getlist($post);
        $data = $data->map(function ($room) use ($post) {
            if ($post['type'] === "trashed") {
                $room->action = '
                    <a  href="javascript:;" class="restoreRow" data-id="' . $room->id . '"><i class="fa-solid fa-undo text-success"></i></a>|
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
        $rc = RoomCategory::all();
        $user = User::all();
        return response()->json(['data'=>$data,'rc'=>$rc,'user'=>$user]);
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
