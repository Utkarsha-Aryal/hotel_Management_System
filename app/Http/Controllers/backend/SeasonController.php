<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Season;
use Illuminate\Support\Facades\DB;

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

    public function save(Request $request)
    {
        try {
            $post = $request ->all();
            $type = 'Success';
            $message = 'Records Saved sucessfully';
            DB::beginTransaction();
            $result = Season::saveData($post);
            if(!$result){
                throw new Exception('Could not update record',1);
            }
            DB::commit();
        } catch (ValidationException $e) {
            $type = 'error';
            $message = $e->getMessage();
        } catch(QueryException $e){
            DB::rollBack();
            $type = 'error';
            $message = $e->getMessage();
        }catch (Exception $e){
            DB::rollBack();
            $type = "error";
            $message = $e->getMessage();

        }
        return response()->json(['type' => $type, 'message' => $message]);

    }
}
