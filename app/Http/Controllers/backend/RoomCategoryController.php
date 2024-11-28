<?php

namespace App\Http\Controllers\backend;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\RoomCategory;
use Exception;
use Illuminate\Validation\ValidationException;
use App\Models\Common;
use Illuminate\Database\QueryException;
use App\Http\Requests\RoomCategoryRequest;

class RoomCategoryController extends Controller
{
     public function index()
    {
        return view('backend.room.room-category.index');
    }

    public function save(RoomCategoryRequest $request)
    {
        try {
            $post = $request->all();
            $type = 'success';
            $message = 'Records saved sucessfully';
            if(!empty($post['id'])){
                $message = 'Records updated sucessfully';
            }
            DB::beginTransaction();

            $result = RoomCategory::saveData($post);

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

    // list room category
    public function list(Request $request)
    {
        try {
            $post = $request->all();
            $data = RoomCategory::getlist($post);
            $i=0;
            $array=[];
            $filtereddata = ($data['totalfilteredrecs'] > 0 ? $data['totalfilteredrecs'] : $data['totalrecs']);
            $totalrecs = $data['totalrecs'];
            unset($data['totalfilteredrecs']);
            unset($data['totalrecs']);
            foreach($data as $row)
            {
                $array[$i]['sno']=$i +1;
                $array[$i]['Room_Category'] = $row->category;
                $array[$i]['maximum_occupancy'] = $row->maximum_occupancy;
                $array[$i]['order'] = $row->order_number;
                $array[$i]['bed_type'] = $row->bed_type;
                $image = asset('/images/no-image.jpg');
                if(!empty($row->image)&& file_exists(public_path('/storage/roomCategory/'. $row->image))){
                    $image = asset('/storage/roomCategory').'/'. $row-> image;
                }
                $array[$i]['image']='<img src=" '. $image. '" height="30px" width="30px" alt="' . ' image"/>';
                $action ="";
                if(!empty($post['type'])&&$post['type']!='trashed'){
                    $action .= ' <a href="javascript:;" class="viewRoomCategory" title="View Data" data-id="' . $row->id . '"><i class="fa-solid fa-eye" style="color: #008f47;"></i></i></a> |';
                    $action .= '<a href="javascript:;" class="editRoomCategory" title="Edit Data" data-id="' . $row->id . '" data-category="' . $row->category . '" data-maximum_occupancy="' . $row->maximum_occupancy . '" data-bed_type="' . $row->bed_type . '" data-image="'.$image .'" data-order="'.$row->order_number.'" ><i class="fa-solid fa-pen-to-square text-primary"></i></a> |';

                }else if(!empty($post['type'])&&$post['type']=='trashed'){
                    $action .= '<a href="javascript:;" class="restore" title="Restore Data" data-id="' . $row->id . '"><i class="fa-solid fa-undo text-success"></i></a> | ';
                }
                $action .= ' <a href="javascript:;" class="deleteRoomCategory" name="Delete Data" data-id="' . $row->id . '"><i class="fa fa-trash text-danger"></i></a>';
                $array[$i]["action"]  = $action;
                $i++;
            }
            if (!$filtereddata) $filtereddata = 0;
            if (!$totalrecs) $totalrecs = 0;
        } catch (QueryException $e) {
            $array = [];
            $totalrecs = 0;
            $filtereddata = 0;
        } catch(Exception $e){
            $array = [];
            $totalrecs = 0;
            $filtereddata = 0;
        }
        return response()->json(array("recordsFiltered" => $filtereddata, "recordsTotal" => $totalrecs, "data" => $array));
    }

    public function view(Request $request ){
        try {
            $post = $request->all();
            $roomcategoryDetails = RoomCategory::where('id',$post['id'])->where('status','Y')->first();
            $data = [
                'roomcategoryDetails' => $roomcategoryDetails
            ];
            $data['type'] = 'success';
            $data['message']='Successfully fetched data of Roomcategories';
        } catch (QueryException $e) {
            $data['type'] = 'error';
            $data['message']=$this->queryMessage;
        } catch( Exception $e){
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        }
        return view('backend.room.room-category.view',$data);
    }

    public function delete(Request $request)
    {
        try
        {
            $type = 'success';
            $message = 'Record deleted successfully';
            $directory = storage_path('app/public/roomCategory');
            $post = $request->all();
            $class = new RoomCategory();

            DB::beginTransaction();
            $result = Common::deleteSingleData($post,$class,$directory);

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
            $result = RoomCategory::restoreData($post);
            if(!$result){
                throw new Exception("Could not resotre Category. PLease try again.",1);
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
