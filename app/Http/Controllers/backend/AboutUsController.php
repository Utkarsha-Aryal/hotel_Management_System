<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AboutUsRequest;
use App\Models\AboutUs;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class AboutUsController extends Controller
{
    public function aboutUs()

    {
        $aboutUs = AboutUs::get()->first();
        $data = [
            'aboutusData' => $aboutUs
        ];
        return view('backend.about-us.index', $data);
    }
    
    public function updateAboutUs(AboutUsRequest $request)
    {
        try {
            $post = $request->all();
            $type = 'success';
            $message = 'Record saved successfully';
            DB::beginTransaction();
            $result = AboutUs::updatedata($post);
            if (!$result)
                throw new Exception("Couldn't Save Records", 1);
            DB::commit();
        } catch (QueryException $e) {
            DB::rollback();
            $type = 'error';
            $message = $this->queryMessage;
        } catch (Exception $e) {
            DB::rollback();
            $type = 'error';
            $message = $e->getMessage();
        }
        return response()->json(['type' => $type, 'message' => $message]);
    }
}