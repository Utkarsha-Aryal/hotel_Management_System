<?php

namespace App\Models;
use Exception;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Room extends Model
{
    protected $table = "our_rooms";

    public function roomCategory()
    {
        return $this->belongsTo(RoomCategory::class,'category_id');
    }

    public function postedBy()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function saveData($post)
    {
        try
        {

           $insertArray = [
            'category_id' => $post['category'],
            'order_number'=> $post['order'],
            'max_occupancy'=>$post['maximum_occupancy'],
            'room_no' => $post['room_no'],
            'floor_no' => $post['floor_no'],
            'room_view' => $post['room_view'],
            'smoking' => $post['smoking'],
            'room_status' => $post['room_status'],
            'room_size' => $post['room_size'],
            'user_id' => Auth::user()->id
            
            ];
            $insertArray = filterData($insertArray);
            if(!empty($post['id'])){
                $insertArray['updated_at'] = Carbon::now();
                if(!Room::where('id',$post['id'])->update($insertArray)){
                    throw new Exception("Couldn't update Records",1);
                }
            }else{
                $insertArray['created_at'] = Carbon::now();
                if(!Room::where('id',$post['id'])->insert($insertArray)){
                    throw new Exception("Couldn't Save Records",1);
                }
            }
            return true;

        }catch(Exception $e){
            throw $e;
        }

    }

    public static function getlist($post)
    {
        try {
            $get = $post;
         
            if(!empty($post['category_id']) && !empty($post['type']) && $post['type']==="nottrashed" ){
                $cond = "status = 'Y'";
                $data = Room::orderby('order_number','asc')->where('category_id', $post['category_id'])
                ->whereRaw($cond)
                ->get();
    
            }elseif(!empty($post['category_id']) && !empty($post['type']) && $post['type']==="trashed"){
                $cond = "status = 'N'";
                $data = Room::orderby('order_number','asc')->where('category_id', $post['category_id'])
                ->whereRaw($cond)
                ->get();

            }elseif(!empty($post['type']) && $post['type']==="trashed"){
                $cond = "status = 'N'";
                $data = Room::orderby('order_number','asc')->whereRaw($cond)->get();

            }
            else{
                $cond = "status = 'Y'";
                $data = Room::orderby('order_number','asc')->whereRaw($cond)->get();

            }
            if(!empty($post['query'])){
                // $data = $data->where('room_no', $query);
                // dd($data);
                $cond .= " AND room_no = '".$post['room_no']."'";

            }
             return $data;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function restoreData($post)
    {
        try{
            $updateArray = [
                'status'=>'Y',
                'updated_at'=>Carbon::now(),
            ];
            if(!Room::where(['id'=>$post['id']])->update($updateArray)){
                throw new Exception("Couldn't Restore Data. Please try again", 1);
            }
            return true;
        }catch(Exception $e){
            throw $e;   
        }
    }
}
