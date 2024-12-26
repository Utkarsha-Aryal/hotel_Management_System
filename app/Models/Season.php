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
            $excludeId = $post['id'];
            // this block of code checks whether the enddate is earlier than startdate
            $startdate = new \DateTime($post['start_date']);
            $enddate = new \DateTime($post['end_date']);

            if($enddate<$startdate){
                throw new Exception("End date can not be earlier than start date");
            }else if($enddate==$startdate){
                throw new Exception("End date and start date cannot be in the same day");
            }

            // this checks if the category name is uniqe or not and it let the category name pass in the edit case
            $categorynameExists = Season::where('name',$post['Season_Name'])->where('status','Y')->where('id','!=',$post['id']??null)->exists();
            if($categorynameExists){
                throw new Exception("The category name is already taken");
            }

            //This gets all the start and end date of the season except for the data whose id is given
            $seasons = Season::select('start_date', 'end_date') ->where('id', '!=', $excludeId)->get();
            $newStartDate = $post['start_date'];
            $newEndDate = $post['end_date'];
            
            $newStart = strtotime($newStartDate);
            $newEnd = strtotime($newEndDate);

            //this iteration iterates all the date from the season and sets in the function for the comaprison
             foreach ($seasons as $season) {
                $existingStart = strtotime($season->start_date);
                $existingEnd = strtotime($season->end_date);
                if ($newStart <= $existingEnd && $newEnd >= $existingStart) {
                    throw new Exception("The given date range overlaps with an existing season.");
                }
            }

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
