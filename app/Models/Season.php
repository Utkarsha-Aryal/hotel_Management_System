<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Carbon\Carbon;
use App\Models\RoomPrice;
class Season extends Model
{
    public function season()
    {
        return $this->hasOne(related: RoomPrice::class)->where('status', 'Y');
    }   
        
    public static function saveData($post)
    {
        try {
            $insertArray = [
                'name' => $post['Season_Name'],
                'start_date' => $post['start_date'],
                'order_number' => $post['order'],
                'end_date' => $post['end_date']
            ];
            $insertArray = filterData($insertArray);
            if(!empty($post['id'])){
                $insertArray['updated_at'] = Carbon::now();
                if(!Season::where('id',$post['id'])->update($insertArray)){
                    throw new Exception("Couldn't update Records",1);
                }
            }else{
                $insertArray['created_at'] = Carbon::now();
                if(!Season::where('id',$post['id'])->insert($insertArray)){
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
                $cond .= " and lower(name) like '%" . $get['columns'][1]['search']['value'] . "%'";
            $limit = 15;
            $offset = 0;
            }
            if(!empty($get['length']&& $get['length']))
            {
                $limit = $get['length'];
                $offset = $get['start'];
            }
            $query = Season::selectRaw("(SELECT COUNT(*) FROM seasons) AS totalrecs, id, name, order_number,start_date, end_date")->whereRaw($cond);

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
            if(!Season::where(['id'=>$post['id']])->update($updateArray)){
                throw new Exception("Couldn't Restore Data. Please try again", 1);
            }
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
