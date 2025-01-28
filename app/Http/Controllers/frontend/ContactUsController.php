<?php

namespace App\Http\Controllers\frontend;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactUs;
use App\Models\SiteSetting;

class ContactUsController extends Controller
{
    public function index()
    {
        $linkMap = SiteSetting::value('link_map');
        return view('frontend.contact',['linkMap'=>$linkMap]);
    }

    public function save(Request $request)
    {
        try
        {
        $post = $request->all();
        $type = 'success';
        $message = 'Records saved sucessfully';
        DB::beginTransaction();
        $result = ContactUs::saveData($post);
        if(!$result){
            throw new Exception('Could not save record',1);
        }
        DB::commit();

        }catch(Exception $e){
            DB::rollBack();
            $type = "error";
            $message = $e->getMessage();
        }
        return response()->json(['type'=>$type,'message'=>$message]);
    }
}
