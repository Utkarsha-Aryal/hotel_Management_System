<?php

namespace App\Models;
use Exception;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;


class OTP extends Model
{
    
    public static function checkOtp($post)
    {
        try {
            $user = Session::get('user');
         
            if(!$user){
                throw new Exception("Please go back and send otp again.", 1);

            }
            $result = OTP::where('user_id', $user->id)
            ->orderBy('id', 'desc')
            ->first();

            if (empty($result))
            throw new Exception("OTP not generated. Please try again later", 1);

            if ($result->otp != ($post['otp'])) {

                throw new Exception("Wrong OTP. Please try again with correct OTP", 1);
            }
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }
    
}
