<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Exception;
use App\Models\ForgetPassword;

class ForgetPasswordController extends Controller
{
    public function index(){
        return view('backend.auth.forget');
    }

    public function isRegisteredUser(Request $request){
        try {
            $rules = [
                'email' => 'required|email|max:50',
            ];
            $message = [
                'email.required' => 'Email field is required',
                'email.email' => 'Email format does not matched',
            ];
            $validate = Validator::make($request->all(), $rules, $message);
            if ($validate->fails()) {
                throw new Exception($validate->errors()->first(), 1);
            }
            $post = $request->all();
            $type = 'success';
            $message = 'Please check email';

            DB::beginTransaction();
            $result = ForgetPassword::checkRegisteredEmail($post);
            if (!$result) {
                throw new Exception('Record is not found', 1);
            }
            DB::commit();
            return response()->json([
                'type' => 'success',
                'message' => 'Opt has been send successfully !',
                'route' => route('otp')
            ]);
        } catch (QueryException $e) {
            DB::rollBack();
            $type = 'error';
            $route = route('forgetpassword');
            $message = $this->queryMessage;
            return json_encode(['type'=>$type,'message'=>$message,'route'=>$route]);
        } catch(Exception $e){
            DB::rollBack();
            $type = 'error';
            $route = route('forgetpassword');
            $message = $e->getMessage();
            return json_encode(['type'=>$type,'message'=>$message,'route'=>$route]);
        }
        
    }

    public function updatePassword(Request $request){

        try {
            $rules=[
                'password' => 'required|max:250',
                'confirm_password'=>'required|max:250',
            ];
            $message = [
                'password.required' => 'Please enter new password',
                'confirm_password.required' => 'Please enter confirm password',
            ];
            $validate = Validator::make($request->all(),$rules,$message);

            if($validate->fails()){
                throw new Exception($validate->errors()->first(),1);
            }

            $post = $request->all();
            $type = "success";
            $message = 'Password is updated sucessfully. ';

            DB::beginTransaction();
            $result = ForgetPassword::updateData($post);
            if(!$result){
                throw new Exception("Couldn't save record ",1);
            }
            DB::commit();
            return response()->json([
                'type'=>'success',
                'message'=>'Password has been changed successfully !',
                'route'=>route('login')
            ]);
        } catch (QueryException $e) {
            DB::rollBack();
            $type = 'error';
            $route = route('resetpassword');
            $message = $this->queryMessage;
        } catch (Exception $e){
            DB::rollBack();
            $type = 'error';
            $route = route('resetpassword');
            $message = $e->getMessage();
        }
        return response()->json(['type'=>$type,'message'=>$message,'route'=>$route]);
    }
}
