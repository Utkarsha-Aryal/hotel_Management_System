<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoomCategory;
use App\Models\RoomPrice;
use App\Models\Season;

class FOurRoomController extends Controller
{
    public function index(){
        $data = RoomCategory::select('id','category', 'maximum_occupancy', 'bed_type', 'image')
        ->where('status', 'y')->orderBy('order_number', 'asc')->get();
    
        return view('frontend.ourroom.index',['data'=>$data]);
    }

    public function view(Request $request ){
        try {
            $post = $request->all();
            $requestedDate =  $post['nepali_date'];
            $roomcategoryDetails = RoomCategory::where('id',$post['id'])->where('status','Y')->first();
            $seasons =  Season::all();

            foreach ($seasons as $season) {
                if ($requestedDate >= $season->start_date && $requestedDate <= $season->end_date) {
                        $theseasonis = $season->name;
                        $prices = RoomPrice::with(['roomCategory', 'seasonCategory'])
                        ->select('price')
                        ->whereHas('seasonCategory', function ($query) use ($theseasonis) {
                            $query->where('name', $theseasonis);
                        })
                        ->whereHas('roomCategory', function ($query) use ($roomcategoryDetails) {
                            $query->where('category', $roomcategoryDetails->category);
                        })
                        ->first();
                }else{
                    $theseasonis = "default";
                    $prices = RoomPrice::with(['roomCategory', 'seasonCategory'])
                    ->select('price')
                    ->whereHas('seasonCategory', function ($query) use ($theseasonis) {
                        $query->where('name', $theseasonis);
                    })
                    ->whereHas('roomCategory', function ($query) use ($roomcategoryDetails) {
                        $query->where('category', $roomcategoryDetails->category);
                    })
                    ->first();
                }
            }

            
            
            $data = [
                'roomcategoryDetails' => $roomcategoryDetails,

                'prices'=>$prices
            ];
            $data['type'] = 'success';
            $data['message']='Successfully fetched data of Roomcategories';
        } catch (QueryException $e) {
            $data['type'] = 'error';
            $data['message']=$this->queryMessage;
        } catch( Exception $e){
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        }
        return view('frontend.ourroom.view',$data);
    }
}
