<?php

namespace App\Models;
use Exception;
use Illuminate\Database\Eloquent\Model;
use App\Models\RoomCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use App\Models\Common;


class OurRoom extends Model
{
    use HasFactory;

    public function roomCategory()
    {
        return $this->belongsTo(RoomCategory::class,'category_id');
    }
    public static function saveData($post)
    {
        try {
            $roomExists = OurRoom::where('room_no',$post['room_no'])->where('status','Y')->where('id','!=',$post['id']??null)->exists();
            if($roomExists){
                throw new Exception('This room no is already taken by some other room',1);
            }
            $dataArray = [
                'title'=> strip_tags($post['title']),
                'order_number'=>strip_tags($post['order_number']),
                'max_occupancy'=>$post['occupancy'],
                'room_no'=>$post['room_no'],
                'category_id'=>$post['category_id'],
                'wifi'=>$post['wifi'],
                'AC'=>$post['AC'],
                'TV'=>$post['TV'],
                'minibar'=>$post['minibar'],
                'room_service'=>$post['room_service'],
                'private_bathroom' => $post['private_bathroom'],
                'balcony'=>$post['balcony'],
                'description'=>$post['details'],
            ];
            $dataArray = filterData($dataArray);
            $photocount = count($post['file']);
            if($photocount>10){
                throw new Exception("The maximum number of photos that can be uploaded is 10. You are trying to upload $photocount photos.", 1);
            }

            if (!empty($post['file'][0])){
                $imageNames=[];
                foreach($post['file']as $image){
                    $fileName = Common::uploadFile('ourroom',$image);
                    if(!$fileName){
                        return false;
                    }
                    $imageNames[] = $fileName;
                }
                if(empty($post['id'])){
                    $imageNamesJson = json_encode($imageNames);
                    $dataArray['feature_image'] = $imageNamesJson;
                }else{
                    $postData = OurRoom::where('id',$post['id'])->first();
                    $fetchOldData = json_decode($postData->feature_image);
                    if(isset($fetchOldData)){
                        $dataArray['feature_image']= json_encode(array_merge($fetchOldData,$imageNames));
                    }else{
                        $dataArray['feature_image'] = json_encode($imageNames);
                    }
                }
            }

            if(!empty($post['id'])){
                $dataArray['updated_at'] = Carbon::now();
                if(!OurRoom::where('id',$post['id'])->update($dataArray)){
                    throw new Exception("Couldn't update Records",1);
                }
            }else{
                $dataArray['created_at'] = Carbon::now();
                if(!OurRoom::insert($dataArray)){
                    throw new Exception("Couldn't save records",1);
                }
            }
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function getlist($post)
    {
        try
        {
            $get = $post;
            $sorting = !empty($get['order'][0]['dir']) ? $get['order'][0]['dir'] : ' asc';
            $orderby = 'order_number' . $sorting . "";
            if(!empty($get['order'][0]['column']) && $get['order'][0]['column']==3){
                $orderby = " order_number " . $sorting . " ";
            }
            foreach($get['columns'] as $key=>$value){
                $get['columns'][$key]['search']['value'] =  trim(strtolower(htmlspecialchars($value['search']['value'], ENT_QUOTES)));
            }
            $cond = " status = 'Y'";
            if(!empty($post['type']) && $post['type']=== "trashed"){
                $cond = " status = 'N'";
            }
            if($get['columns'][1]['search']['value']){
            $cond .= " and lower(title) like '%" . $get['columns'][1]['search']['value'] . "%'";
            }
            if($get['columns'][6]['search']['value']){
                $cond .= " and lower(room_no) like '%" . $get['columns'][6]['search']['value'] . "%'";
            }
            $limit = 15;
            $offset = 0;
            if(!empty($get['length']) && $get['length']){
                $limit = $get['length'];
                $offset = $get['start'];
            }
            $query = OurRoom::with('roomCategory')->selectRaw("(SELECT COUNT(*) from our_rooms) As totalrecs, id, title , description, order_number , max_occupancy , category_id , room_no")->whereRaw($cond);
            if ($limit>-1){
                $result = $query->orderByRaw($orderby)->offset($offset)->limit($limit)->get();
            }else{
                $result = $query->orderByRaw($orderby)->get();
            }
            if($result){
                $ndata = $result;
                $ndata['totalrecs'] = @$result[0]->totalrecs ? $result[0]->totalrecs : 0;
                $ndata['totalfilteredrecs'] = @$result[0]-> totalrecs ? $result[0]->totalrecs : 0;
            }else{
                $ndata = array();
            }
            return $ndata;

        } catch(Exception $e){
            throw $e;
        }
    }

    public static function deleteFeatureImage($post)
    {
        try {
            
            $postData = OurRoom::where('id',$post['id'])->first();
            $jsonArray = json_decode($postData->feature_image);
            $newArray = array_values(array_diff($jsonArray,[$post['feature_image']]));
            $filepath = storage_path('app/public/ourroom');

            if(file_exists($filepath . '/'.$post['feature_image'])){
                unlink($filepath . '/' . $post['feature_image']);
            }
            $postData->feature_image = json_encode($newArray);
            if(!$postData->update()){
                throw new Exception("Error updating feature image");
            }
            return true;            
        } catch (Exception $e) {
            throw $e;

        }
    }

    public static function retoreData($post)
    {
        try {
            $updateArray = [
                'status' => 'Y',
                'updated_at'=> Carbon::now(),
            ];
            if(!OurRoom::where(['id'=>$post['id']])->update($updateArray)){
                throw new Exception("Couldn't Restore Data. Please try again", 1);
            }
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
