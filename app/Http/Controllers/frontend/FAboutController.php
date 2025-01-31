<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutUs;

class FAboutController extends Controller
{
    public function index(){
        $data = AboutUs::select('introduction', 'img_introduction')->first();
        
        return view("frontend.about.index",['data'=>$data]);
    }
}
