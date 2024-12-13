<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Carbon\Carbon;

class Season extends Model
{
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
}
