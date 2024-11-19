<?php

namespace App\Http\Controllers\backend;
use App\Models\OTP;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
class OTPController extends Controller
{
    public function index(){

        return view('backend.auth.otp');
    }

    public function indexResetPassword(){

        return view('backend.auth.reset_password');
    }

    public function isValidOtp(Request $request)
    {
        try {

            $rules = [
                'otp' => 'required|min:4|max:4',
            ];
            $message = [
                'otp.required' => 'otp field is required',
            ];

            $validate = Validator::make($request->all(), $rules, $message);
            if ($validate->fails()) {
                throw new Exception($validate->errors()->first(), 1);
            }
            $post = $request->all();
            $type = 'success';
            $message = 'Please reset password';
            DB::beginTransaction();
            $result = OTP::checkOtp($post);
            if (!$result) {
                throw new Exception('Record does not found', 1);
            }
            DB::commit();
            return response()->json([
                'type' => 'success',
                'message' => 'Otp has been verified successfully. Procesed to change password !',
                'route' => route('resetpassword')
            ]);
            
        } catch (QueryException $e) {
            DB::rollBack();
            $type = 'error';
            $route = route('otp');
            $message = $this->queryMessage;
        } catch (Exception $e) {
            DB::rollBack();
            $type = 'error';
            $route = route('otp');
            $message = $e->getMessage();
        }

       return response()->json(['type'=>$type,'message'=>$message,'route'=>$route]);
    }
}
