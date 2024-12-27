<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function index()
    {
        return view('frontend.contact');
    }

    public function save(Request $request)
    {
        try
        {

        $post = $request->all();
        $type = 'success';
        $message = 'Records saved sucessfully';
        DB::beginTransaction();

        }catch(Exception $e){
            DB::rollBack();
            $type = "error";
            $message = $e->getMessage();
        }
        return response()->json(['type'=>$type,'message'=>$message]);
    }
}
