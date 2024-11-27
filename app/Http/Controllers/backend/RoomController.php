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
        try {
            $post = $request->all();
            $data = Room::list($post);
            $i = 0;
            $array = [];
            $filtereddata = ($data['totalfilteredrecs'] > 0 ? $data['totalfilteredrecs'] : $data['totalrecs']);
            $totalrecs = $data['totalrecs'];
            unset($data['totalfilteredrecs']);
            unset($data['totalrecs']);
            foreach ($data as $row) {
                $array[$i]['sno'] = $i + 1;
                $array[$i]['category'] = $row->roomCategory->category;
                $array[$i]['posted_by'] = $row->postedBy->name;
                $array[$i]['order_number'] = $row->order_number;
                $array[$i]['max_occupancy'] = $row->max_occupancy;
                $array[$i]['room_no'] = $row->room_no;
                $array[$i]['floor_no'] = $row->floor_no;
                $array[$i]['room_view'] =$row->room_view;
                $array[$i]['smoking'] = $row->smoking;
                $array[$i]['room_status'] = $row->room_status;
                $array[$i]['room_size'] = $row->room_size;
           
                if (!empty($post['type']) && $post['type'] != 'trashed') {
                    $action .= ' <a href="javascript:;" class="viewPost" title="View Data" data-id="' . $row->id . '"><i class="fa-solid fa-eye" style="color: #008f47;"></i></i></a>';
                    $action .= '<span style="margin-left: 10px;"></span>'; //Space placement to sepearte from each other
                    $action .= '|';
                    $action .= '<span style="margin-left: 10px;"></span>'; //Space placement to sepearte from each other
                    $action .= '<a href="javascript:;" class="editNews" title="Edit Data" data-id="' . $row->id . '"><i class="fa-solid fa-pen-to-square text-primary"></i></a>';
                    $action .= '<span style="margin-left: 10px;"></span>'; //Space placement to sepearte from each other
                    $action .= '|';
                    $action .= '<span style="margin-left: 10px;"></span>'; //Space placement to sepearte from each other
                } else if (!empty($post['type']) && $post['type'] == 'trashed') {
                    $action .= '<a href="javascript:;" class="restore" title="Restore Data" data-id="' . $row->id . '"><i class="fa-solid fa-undo text-success"></i></a> ';
                    $action .= '<span style="margin-left: 10px;"></span>'; //Space placement to sepearte from each other
                    $action .= '|';
                    $action .= '<span style="margin-left: 10px;"></span>'; //Space placement to sepearte from each other
                }
                $action .= ' <a href="javascript:;" class="deleteNews" title="Delete Data" data-id="' . $row->id . '"><i class="fa fa-trash text-danger"></i></a>';
                $array[$i]['action'] = $action;
                $i++;
            }
            if (!$filtereddata)
                $filtereddata = 0;
            if (!$totalrecs)
                $totalrecs = 0;
        } catch (QueryException $e) {
            $array = [];
            $totalrecs = 0;
            $filtereddata = 0;
        } catch (Exception $e) {
            $array = [];
            $totalrecs = 0;
            $filtereddata = 0;
        }
        return response()->json(['recordsFiltered' => $filtereddata, 'recordsTotal' => $totalrecs, 'data' => $array]);
    }
}
