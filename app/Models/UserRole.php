<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Exception;


class UserRole extends Model
{
    protected $fillable = ['role_id', 'user_id'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }


    public static function saveData($post){
        try {
            $dataArray = [
                'user_id'=>$post['id'],
                'role_id'=>$post['role'],
                'updated_at' => Carbon::now(),
                'created_at'=>Carbon::now()
            ];
            $dataArray = filterData($dataArray);
            if(!empty($post['id'])){
                $dataArray['updated_at'] = Carbon::now();
                $user = UserRole::where('id', $post['id'])->first();
                if($user){
                    $user->update($dataArray);
                    return $user;
                }else{
                    $dataArray['created_at'] = Carbon::now();
                    $user = UserRole::create($dataArray);
                    return $user;
                }

            }else{
                throw new Exception("User ID is required for creating a user role", 1);

            }
        } catch (Exception $e) {
            throw $e;
    
        }
    }
}
