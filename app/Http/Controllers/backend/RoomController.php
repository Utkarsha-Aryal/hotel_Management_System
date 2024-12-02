<?php

namespace App\Http\Controllers\backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomCategory;
use Illuminate\Support\Facades\DB;


class RoomController extends Controller
{
    public function index(){
        try{
        $category = RoomCategory::get();
        $data=[];
        $data = [
            'category'=>$category];
        $data['type'] = 'success';
        $data['message']='Successfullt get data.';
    } catch (QueryException $e){

        $data['type'] = 'error';
        $data['message'] = $this->queryMessage;

    } catch(Exception $e){

        $data['type']='error';
        $data['message']= $e->getMessage();
    }

        return view('backend.room.room-collection.index',$data);
    }

    public function save(Request $request)
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
        $rc = RoomCategory::all();
        return response()->json(['data'=>$data,'rc'=>$rc]);
    }
}
