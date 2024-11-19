<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\SiteSettingRequest;
use App\Models\SiteSetting;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SiteSettingController extends Controller
{
    public function siteSetting()
    {
        $siteSettings = SiteSetting::find(1);

        $data = [
            'siteSettings' => $siteSettings
        ];
        return view('backend.site-setting.index', $data);
    }

    public function updateSiteSetting(SiteSettingRequest $request)
    {
        try {
            $post = $request->all();
            $type = "success";
            $message = "Record saved successfully";
            DB::beginTransaction();
            $result = SiteSetting::updatedata($post);
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
