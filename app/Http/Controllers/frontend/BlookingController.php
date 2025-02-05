<?php

namespace App\Http\Controllers\frontend;
use Illuminate\Support\Facades\DB;
use App\Models\RoomCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Season;
use App\Models\RoomPrice;

class BlookingController extends Controller
{
    public function index(Request $request){
        $post = $request->all();
        $data = RoomCategory::select('id','category', 'maximum_occupancy', 'bed_type', 'image')
        ->where('status', 'y')->orderBy('order_number', 'asc')->get();

        return view('frontend.booking.index',['data'=>$data]);

    }

    public function form(Request $request){
        $post = $request->all();
        $category = $post["category"];
;        return view('frontend.booking.form',["category"=>$category]);
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
        return view('frontend.booking.view',$data);
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
