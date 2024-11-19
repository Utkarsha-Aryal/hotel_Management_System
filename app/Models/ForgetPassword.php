<?php

namespace App\Models;
use App\Models\User;
use Exception;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgetPasswordMail;
use Illuminate\Support\Facades\Session;

class ForgetPassword extends Model
{
    protected $table = 'users';

    public static function checkRegisteredEmail($post)
    {
        try {
            /* Finding user according to email */
            $user = User::where('status', 'Y')
                ->where('email', $post['email'])
                ->first(['id', 'email']);
            /* If user doesn't exists */
            if (!$user) {
                throw new Exception("User doesn't exists", 1);
            }
            $otp = Str::random(4);
            $otpArray = [
                'user_id' => $user->id,
                'otp' => $otp,
            ];
            if (!empty($user->id)) {
                $otpArray['created_at'] = Carbon::now();
                if (!OTP::insert($otpArray)) {
                    throw new Exception("Couldn't Save Records", 1);
                }
                Mail::to($user->email)->send(new ForgetPasswordMail($otp));
                session(['user' => $user]);
            }
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function updateData($post)
    {
        try {
            // Retrieve the logged-in user from the session
            $currentUser = Session::get('user');
    
            if (!$currentUser) {
                throw new Exception("User session expired. Please log in again.");
            }
    
            // Fetch user details from the database
            $user = User::find($currentUser->id);
    
            if (empty($user)) {
                throw new Exception("User not found. Please try again later.");
            }
    
            // Password validation
            if ($post['password'] !== $post['confirm_password']) {
                throw new Exception("The new password and confirm password do not match.");
            }
    
            // Update password
            if (!$user->update(['password' => Hash::make($post['password'])])) {
                throw new Exception("Couldn't update password. Please try again.");
            }
    
            return $user;
    
        } catch (Exception $e) {
            throw $e;
        }
    }
}
