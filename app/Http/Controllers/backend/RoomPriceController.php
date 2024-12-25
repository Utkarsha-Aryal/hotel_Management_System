<?php

namespace App\Http\Controllers\backend;
use App\Models\RoomCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoomPrice;
use App\Http\Requests\RoomPriceRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Common;
class RoomPriceController extends Controller
{  
    public function save(RoomPriceRequest $request)
    {
        try {
            $post = $request ->all();
            $type = 'Success';
            $message = 'Records Saved sucessfully';
            DB::beginTransaction();
            $result = RoomPrice::saveData($post);
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

    public function list(Request $request)
    {
        try {
        $post = $request->all();
        $data = RoomPrice::getlist($post);
        $i = 0;
        $array = [];
        $type = 'success';
        $message = 'Records Saved successfully';
        $filtereddata = ($data['totalfilteredrecs'] > 0 ? $data['totalfilteredrecs'] : $data['totalrecs']);
        $totalrecs = $data['totalrecs'];
        unset($data['totalfilteredrecs']);
        unset($data['totalrecs']);
        foreach($data as $row)
        {
            $array[$i]['sno']=$i +1;
            $array[$i]['season_name'] = $row->seasonCategory->name;
            $array[$i]['category_name'] = $row->roomCategory->category;
            $array[$i]['order'] = $row->order_number;
            $array[$i]['price'] = $row->price;
            $action ="";
            if(!empty($post['type'])&&$post['type']!='trashed'){
                $action .= '<a href="javascript:;" class="editRoomPrice" title="Edit Data" data-id="' . $row->id . '" data-season_name="' . $row->season_id . '" data-category_name="' . $row->category_id . '" data-price="' . $row->price .'" data-order="'.$row->order_number.'" ><i class="fa-solid fa-pen-to-square text-primary"></i></a> |';

            }else if(!empty($post['type'])&&$post['type']=='trashed'){
                $action .= '<a href="javascript:;" class="restore" title="Restore Data" data-id="' . $row->id . '"><i class="fa-solid fa-undo text-success"></i></a> | ';
            }
            $action .= ' <a href="javascript:;" class="deletePrice" name="Delete Data" data-id="' . $row->id . '"><i class="fa fa-trash text-danger"></i></a>';
            $array[$i]["action"]  = $action;
            $i++;
        }
        if (!$filtereddata) $filtereddata = 0;
        if (!$totalrecs) $totalrecs = 0;
    }catch (QueryException $e){
        $array = [];
        $totalrecs = 0;
        $filtereddata = 0; 
    }catch(Exception $e){
        $array = [];
        $totalrecs = 0;
        $filtereddata = 0;
    }
    return response()->json(["recordsFiltered" => $filtereddata, "recordsTotal" => $totalrecs, "data" => $array,'type' => $type, 'message' => $message]);
    }

    public function delete(Request $request)
    {
        try
        {
            $type = 'success';
            $message = 'Record deleted successfully';
            $post = $request->all();
            $class = new RoomPrice();
            DB::beginTransaction();
            $result = Common::deleteDataFileDoesnotExists($post,$class);
            if(!$result){
                 throw new Exception("Couldn't delete record",1);
            }
            DB::commit();
        }catch(QueryException $e){
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
        try{
            $post = $request->all();
            $type = 'success';
            $message = 'Category restored successfully';
            DB::beginTransaction();
            $result = RoomPrice::restoreData($post);
            if(!$result){
                throw new Exception("Could not resotre Season . PLease try again.",1);
            }
            DB::commit();
        }catch(QueryException $e){
            DB::rollBack();
            $type = 'error';
            $message = $this->queryMessage;
        } catch(Exception $e){
            DB::rollBack();
            $type = 'error';
            $message = $e->getMessage();
        }
        return response()->json(['type'=>$type,'message'=>$message]);
    }

}
