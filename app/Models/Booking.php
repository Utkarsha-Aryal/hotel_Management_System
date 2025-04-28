<?php

namespace App\Models;
use App\Models\RoomCategory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Booking extends Model
{   
    public function roomCategory()
    {
        return $this->belongsTo(RoomCategory::class,'category_id');
    }
    
    public static function saveData($post)
    {
        try {
            $category = $post['category'];
            $roomCategoryId = RoomCategory::where('category', $category)->value('id');
            dd($roomCategoryId);
            $insertArray = [
                'Name' => $post['name'],
                'number' => $post['phone'],
                'email'=> $post['email'],
            ];
         $insertArray['created_at'] = Carbon::now();
         if(!Booking::insert($insertArray)){
            throw new Exception("Couldn't Save Records",1);
        }
        return true;

        } catch(Exception $e){
            throw $e;
        }
    }

}
