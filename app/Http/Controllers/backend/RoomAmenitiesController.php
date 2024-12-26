<?php

namespace App\Http\Controllers\backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use Illuminate\Support\Facades\DB;
use App\Models\RoomCategory;
use App\Http\Requests\RoomAmenitiesRequest;

class RoomAmenitiesController extends Controller
{
    public function index(){
        return view('backend.room.room-collection.index');
    }

    // load the two tabs tabs switch is done here
    public function loadTab(Request $request)
    {
        try {
            $post = $request->all();
            if ($post['tab'] == 'index') {
                $category = RoomCategory::get();
                 $data=[];
                 $data = [
                        'category'=>$category];
                        $data['type'] = 'success';
                        $data['message']='Successfullt get data.';
                    
                return view('backend.room.room-collection.room',$data);
            }else if($post['tab'] == 'amne'){
                return view('backend.room.room-collection.amnities');
            }
        } catch (Exception $e) {
            return response()->json(['message' => 'Error loading tab'], 500);
        }
    }

    // load the list of our-rooms table
    public function list(Request $request)
    {
        try
         {
            $post = $request->all();
            $data = Room::amnetieslist($post);
            return response()->json(['data'=>$data]);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function save(RoomAmenitiesRequest $request)
    {
        try {
            $post = $request->all();
            $type = 'success';
            $message = 'Records updated successfully';
            DB::beginTransaction();
            $result = Room::saveAmenities($post);
            if(!$result){
                throw new Exception('Could not update record',1);
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

}
