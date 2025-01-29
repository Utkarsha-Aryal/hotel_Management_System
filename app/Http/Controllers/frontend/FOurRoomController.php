<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoomCategory;

class FOurRoomController extends Controller
{
    public function index(){
        $data = RoomCategory::select('id','category', 'maximum_occupancy', 'bed_type', 'image')
        ->where('status', 'y')->orderBy('order_number', 'asc')->get();
    
        return view('frontend.ourroom.index',['data'=>$data]);
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
        return view('frontend.ourroom.view',$data);
    }
}
