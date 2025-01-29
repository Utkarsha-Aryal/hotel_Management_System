<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoomCategory;

class FOurRoomController extends Controller
{
    public function index(){
        $data = RoomCategory::select('category', 'maximum_occupancy', 'bed_type', 'image')
        ->where('status', 'y')->orderBy('order_number', 'asc')->get();
    
        return view('frontend.ourroom.index',['data'=>$data]);
    }
}
