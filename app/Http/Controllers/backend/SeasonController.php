<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SeasonController extends Controller
{
    public function index(){
        return view('backend/room/room-price/index');
    }

    public function loadTab(Request $request)
    {
        try{
            $post = $request->all();
            if($post['tab'] == 'season'){
                return view('backend/room/room-price/room-season');
            }else if($post['tab'] == 'price_setting'){
                return view('backend/room/room-price/room-price');
            }
        } catch(Exception $e){

        }
    }
}
