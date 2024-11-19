<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoomCategory;
use App\Models\OurRoom;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use App\Models\Common;
use App\Http\Requests\OurRoomRequest;

class OurRoomController extends Controller
{

    public function index(){
        return view('backend.room.room.index');
    }

    public function form(Request $request){
        try {
            $post = $request->all();
            $prevPost = null;
            $category = RoomCategory::get();

            if(!empty($post['id'])){
                $prevPost = OurRoom::where('id',$post['id'])->where('status','Y')->first();
                if(!$prevPost){
                    throw new Exception("Couldn't find details",1);
                }
            }
            
            $data=[];
            $data = [
                'prevPost'=>$prevPost,
                'category'=>$category,
            ];

            if($prevPost->feature_image){
                $decodedFeatureImages = json_decode($prevPost->feature_image, true);
                $data['decodedFeatureImages'] = $decodedFeatureImages;
            }
             else{
                $data['decodedFeatureImages'] = '<img src="' . asset('/no-image.jpg') . '" class="_image" height="160px" width="160px" alt="' . ' No image"/>';
            }

            $data['type'] = 'success';
            $data['message']='Successfullt get data.';

        } catch (QueryException $e){

            $data['type'] = 'error';
            $data['message'] = $this->queryMessage;

        } catch(Exception $e){

            $data['type']='error';
            $data['message']= $e->getMessage();
        }

        return view('backend.room.room.form',$data);
    }

    public function save(OurRoomRequest $request)
    {
        try {
            $post = $request->all();
            $type = 'success';
            $verify =  filterData($request->all());
            
            if(empty( $verify['details'])){
                throw new Exception('Please enter the details field',1);
            }
            $message = 'Records saved successfully';  

            DB::beginTransaction();
            $result = OurRoom::saveData($post);

            if(!$result){
                throw new Exception('Could not dave record',1);
            }

            DB::commit();

        } catch (ValidationException $e) {
            $type = 'error';
            $message = $e->getMessage();
        }catch (QueryException $e){
            DB::rollBack();
            $type = 'error';
            $message = $e->getMessage();

        }catch(Exception $e){
            DB::rollBack();
            $type =  'error';
            $message = $e->getMessage();

        }
        return response()->json(['type'=>$type,'message'=>$message]);
    }

    public function list(Request $request)
    {
        try {
            $post = $request->all();
            $data = OurRoom::getlist($post);
            $i = 0 ;
            $array = [];
            $filtereddata = ($data['totalfilteredrecs'] >0 ? $data['totalfilteredrecs']: $data['totalrecs']);
            $totalrecs = $data['totalrecs'];
            unset($data['totalfilteredrecs']);
            unset($data['totalrecs']);
            foreach($data as $row){
                $array[$i]['sno'] = $i +1;
                $array[$i]['category'] = $row->roomCategory->category;
                $array[$i]['order_number']=$row->order_number;
                $array[$i]['max_occupancy']=$row->max_occupancy;
                $array[$i]['details']=$row->description;
                $array[$i]['room_no']=$row->room_no;
                $array[$i]['title']=$row->title;
                $image = asset('images/no-image.jpg');
                if(!empty($row->roomCategory->image)&& file_exists(public_path('/storage/roomCategory/'. $row->roomCategory->image))){
                    $image = asset('/storage/roomCategory').'/'. $row->roomCategory->image;
                }
                $array[$i]['category_image'] = '<img src="' . $image . '" height="30px" width="30px" alt="image"/>';
                $action = '';
                if(!empty($post['type']) && $post['type']!="trashed"){
                    $action .= ' <a href="javascript:;" class="viewPost" title="View Data" data-id="' . $row->id . '"><i class="fa-solid fa-eye" style="color: #008f47;"></i></i></a>';
                    $action .= '<span style="margin-left: 10px;"></span>'; //Space placement to sepearte from each other
                    $action .= '|';
                    $action .= '<span style="margin-left: 10px;"></span>'; //Space placement to sepearte from each other
                    $action .= '<a href="javascript:;" class="editNews" title="Edit Data" data-id="' . $row->id . '"><i class="fa-solid fa-pen-to-square text-primary"></i></a>';
                    $action .= '<span style="margin-left: 10px;"></span>'; //Space placement to sepearte from each other
                    $action .= '|';
                    $action .= '<span style="margin-left: 10px;"></span>'; 
                }else if(!empty($post['type']) && $post['type'] == 'trashed'){
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
        }catch(Exception $e){
            $array = [];
            $totalrecs = 0;
            $filtereddata = 0;
        }
        return response()->json(['recordsFiltered' => $filtereddata, 'recordsTotal' => $totalrecs, 'data' => $array]);
    }

    public function view(Request $request)
    {
        try {
            $post = $request->all();
            $postDetails = OurRoom::where('id', $post['id']) ->where('status', 'Y')->first();
            
            $category = RoomCategory::get();

            $data = [
                'postDetails' => $postDetails,
                'category' =>$category,
            ];
            if ($postDetails->feature_image) {
                $decodedFeatureImages = json_decode($postDetails->feature_image, true);
                $data['decodedFeatureImages'] = $decodedFeatureImages;
            }
         
            $data['type'] = 'success';
            $data['message'] = 'Successfully fetched data of portfolio.';
        } catch (QueryException $e) {
            $data['type'] = 'error';
            $data['message'] = $this->queryMessage;
        } catch (Exception $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        }
        return view('backend.room.room.view', $data);
    }

    public function deleteFeatureImage(Request $request)
    {
        try {
            $type = "success";
            $message = "Successfully Deleted Feature Image";
            $post = $request->all();
            DB::beginTransaction();
            if(!OurRoom::deleteFeatureImage($post)){
                throw new Exception("Couldn't Delete Feature Image, Please Try Again",1);
            }
            DB::commit();
        } catch (QueryException $e ) {
            DB::rollBack();
            $type = "error";
            $message =  $e->getMessage();
        } catch( Exception $e){
            DB::rollBack();
            $type = "error";
            $message = $e->getMessage();
        }
        return json_encode(['type'=>$type,'message'=>$message]);
    }

    public function delete(Request $request)
    {
        try {
            $type = 'success';
            $message = 'Record deleted successfully';
            $directory = storage_path('app/public/ourroom');
            $post = $request->all();
            $class = new OurRoom();
            DB::beginTransaction();
            $result = Common::deleteSingleData($post,$class,$directory);
            if(!$result){
                throw new Exception("Record couldn't be deleted",1);
            }
            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            $type = 'error';
            $message =  $e->getMessage();
        }
        return response()->json(['type' => $type, 'message' => $message]);

    }

    public function restore(Request $request)
    {
        try {
            $post = $request->all();
            $type = 'success';
            $message = 'Room restored successfully';
            DB::beginTransaction();
            $result = OurRoom::restoreData($post);
            if(!$result){
                throw new Exception("Could not restore Room. Please try again.",1);
            }
            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            $type = 'error';
            $message = $e->getMessage();
        } catch(Exception $e){
            DB::rollBack();
            $type = 'error';
            $message = $e->getMessage();
        }
        return response()->json(['type'=>$type,'message'=>$message]);
    }

}
