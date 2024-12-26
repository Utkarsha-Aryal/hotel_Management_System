<?php

namespace App\Models;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\RoomCategory;
use App\Models\Season;

class RoomPrice extends Model
{
    public function roomCategory()
    {
        return $this->belongsTo(RoomCategory::class,'category_id');
    }

    public function seasonCategory(){
        return $this->belongsTo(Season::class,'season_id');
    }

    public static function saveData($post)
    {
        try
         {
            $insertArray = [
                'category_id' => $post['category_id'],
                'order_number'=> $post['order'],
                'season_id'=>$post['season_id'],
                'price'=>$post['price'],
                ];
                $insertArray = filterData($insertArray);
                if(!empty($post['id'])){
                    $insertArray['updated_at'] = Carbon::now();
                    if(!RoomPrice::where('id',$post['id'])->update($insertArray)){
                        throw new Exception("Couldn't update Records",1);
                    }
                }else{
                    $insertArray['created_at'] = Carbon::now();
                    if(!RoomPrice::where('id',$post['id'])->insert($insertArray)){
                        throw new Exception("Couldn't Save Records",1);
                    }
                }
                return true;
           
        } catch (Exception $e) {
            throw $e;
        }
    }
    
    public static function getlist($post)
    {
        try{
            $get = $post;
            $sorting = !empty($get['order'][0]['dir']) ? $get['order'][0]['dir'] : 'asc';
            $orderby = " order_number ".$sorting."";
            if(!empty($get['order'][0]['column'])&&$get['order'][0]['column']==3){
                $orderby = 'order_number'.$sorting."";
            }
            $cond = " status = 'Y' ";
            if (!empty($post['type']) && $post['type'] === "trashed") {
                $cond = " status = 'N' ";
            }
            if(!empty($get['length']&& $get['length']))
            {
                $limit = $get['length'];
                $offset = $get['start'];
            }
            $query = RoomPrice::selectRaw("(SELECT COUNT(*) FROM room_prices) AS totalrecs, id, category_id, season_id,price, order_number")->whereRaw($cond);
            
            if($limit>-1){
                $result = $query->orderByRAW($orderby)->offset($offset)->limit($limit)->get();
            }else{
                $result = $query->orderByRaw($orderby)->get();
            }
            if($result){
                $ndata = $result;
                $ndata['totalrecs'] = @$result[0]->totalrecs ? $result[0]->totalrecs : 0;
                $ndata['totalfilteredrecs'] = @$result[0]->totalrecs ? $result[0]->totalrecs : 0;
            }
            else{
                $ndata = array();
            }
            return $ndata;
        }catch(Exception $e){
            throw $e;
        }
    }
    public static function restoreData($post)
    {
        try {
            $updateArray= [
                'status'=>'Y',
                'updated_at'=>Carbon::now(),
            ];
            if(!RoomPrice::where(['id'=>$post['id']])->update($updateArray)){
                throw new Exception("Couldn't Restore Data. Please try again", 1);
            }
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
