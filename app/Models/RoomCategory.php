<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Carbon\Carbon;
use App\Models\OurRoom;
use App\Models\RoomPrice;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class RoomCategory extends Model
{
    use HasFactory;
    public function category()
    {
        return $this->hasOne(related: OurRooom::class)->where('status', 'Y');
    }

    public function category2(){
        return $this->hasOne(related:RoomPrice::class)->where('status','Y');
    }

    public static function saveData($post)
    {
        try
        {
           $insertArray = [
            'category' => $post['category'],
            'order_number'=> $post['order'],
            'maximum_occupancy'=>$post['maximum_occupancy'],
            'bed_type' => $post['bed_type']
            ];
            $insertArray = filterData($insertArray);
            if(!empty($post['image'])){
                $fileName = Common::uploadFile('roomCategory',$post['image']);
                if(!$fileName){
                    return false;
                }
                $insertArray['image']=$fileName;
            }
            if(!empty($post['id'])){
                $insertArray['updated_at'] = Carbon::now();
                if(!RoomCategory::where('id',$post['id'])->update($insertArray)){
                    throw new Exception("Couldn't update Records",1);
                }
            }else{
                $insertArray['created_at'] = Carbon::now();
                if(!RoomCategory::where('id',$post['id'])->insert($insertArray)){
                    throw new Exception("Couldn't Save Records",1);
                }
            }
            return true;

        }catch(Exception $e){
            throw $e;
        }

    }

    // list
    public static function getlist($post)
    {
        try {
            $get = $post;
            $sorting = !empty($get['order'][0]['dir']) ? $get['order'][0]['dir'] : 'asc';
            $orderby = " order_number ".$sorting."";
            if(!empty($get['order'][0]['column'])&&$get['order'][0]['column']==3){
                $orderby = 'order_number'.$sorting."";
            }
            foreach($get['columns']as $key => $value){
                $get['columns'][$key]['search']['value'] = trim(strtolower(htmlspecialchars($value['search']['value'], ENT_QUOTES)));
            }
            $cond = " status = 'Y' ";
            if (!empty($post['type']) && $post['type'] === "trashed") {
                $cond = " status = 'N' ";
            }
            if($get['columns'][1]['search']['value'])
            {
                $cond .= " and lower(category) like '%" . $get['columns'][1]['search']['value'] . "%'";
            $limit = 15;
            $offset = 0;
            }
            if(!empty($get['length']&& $get['length']))
            {
                $limit = $get['length'];
                $offset = $get['start'];
            }
            $query = RoomCategory::selectRaw("(SELECT COUNT(*) FROM room_categories) AS totalrecs, id, category, order_number,image, maximum_occupancy,bed_type")->whereRaw($cond);

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
        } catch (Exception $e) {
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
            if(!RoomCategory::where(['id'=>$post['id']])->update($updateArray)){
                throw new Exception("Couldn't Restore Data. Please try again", 1);
            }
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
