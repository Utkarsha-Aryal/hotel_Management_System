<?php

namespace App\Http\Controllers\backend;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthManagerController extends Controller
{
    public function login(){
        if(Auth::check()){
            return redirect(route('admin.dashboard'));
        }
        return view('backend.auth.login');
    }

    public function loginPost(Request $request)
    {
        try {
            $rules = [
                'email' => 'required|email|max:50',
                'password' => 'required|max:50',
            ];
            $messages = [
                'email.required' => 'Email field is required',
                'email.email' => 'Email format does not match',
                'password.required' => 'Password field is required',
            ];

            $validate = Validator::make($request->all(),$rules,$messages);
            if ($validate->fails()) {
                throw new Exception($validate->errors()->first(), 1);
            }

            $post = $request->all();
            $type='success';
            $message ='Login success';
            $credentials = [
                'email'=>$post['email'],
                'password'=>$post['password'],
            ];

            if(Auth::attempt($credentials)){
                $user = Auth::user();

                session(['email' => $user['email']]);
                    return response()->json([
                        'type' => 'success',
                        'message' => 'Logged in Successfully !',
                        'route' => route('admin.dashboard')
                    ]);
            }
            else{
                throw new Exception('Invalid user or password');
            }

        } catch (QueryException $e) {
            $type = 'error';
            $route = route('login');
            $message = $this->queryMessage;
        } catch (Exception $e) {
            $type = 'error';
            $route = route('login');
            $message = $e->getMessage();

        }
        return response()->json(['type' => $type, 'message' => $message , 'route'=>$route]);  
    }

   public function logout(){
    Session::flush();
    Auth::logout();
    return redirect(route('login'));
    }
}
