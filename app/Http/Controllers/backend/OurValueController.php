<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\OurValueRequest;
use App\Models\OurValue;
use Dotenv\Exception\ValidationException;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class OurValueController extends Controller
{
    public function index()
    {
        return view('backend.our-value.index');
    }

    /* save */
    public function save(OurValueRequest $request)
    {
        try {
            $post = $request->all();
            $type = 'success';
            $message = 'Records saved successfully';
            DB::beginTransaction();
            $result = OurValue::saveData($post);
            if (!$result) {
                throw new Exception('Could not save record', 1);
            }
            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            $type = 'error';
            $message = $this->queryMessage;
        } catch (ValidationException $e) {
            $type = 'error';
            $message = $e->getMessage();
        } catch (Exception $e) {
            DB::rollBack();
            $type = 'error';
            $message = $e->getMessage();
        }
        return response()->json(['type' => $type, 'message' => $message]);
    }

    // Get list
    public function list(Request $request)
    {
        try {
            $post = $request->all();
            $data = OurValue::list($post);
            $i = 0;
            $array = [];
            $filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);
            $totalrecs = $data["totalrecs"];
            unset($data["totalfilteredrecs"]);
            unset($data["totalrecs"]);
            foreach ($data as $row) {
                $array[$i]["sno"] = $i + 1;
                $array[$i]["title"]    = $row->title;
                $array[$i]["details"]  =  Str::limit($row->details, 30, '...');
                $array[$i]["order"]    = $row->order;
                $action = '';
                if (!empty($post['type']) && $post['type'] != 'trashed') {
                    $action .= ' <a href="javascript:;" class="viewValue" title="View Data" data-id="' . $row->id . '"><i class="fa-solid fa-eye" style="color: #008f47;"></i></i></a>';
                    $action .= '<span style="margin-left: 10px;"></span>'; //Space placement to sepearte from each other
                    $action .= '|';
                    $action .= '<span style="margin-left: 10px;"></span>'; //Space placement to sepearte from each other
                    $action .= '<a href="javascript:;" class=" edit" name="Edit Data" data-id="' . $row->id . '" data-title="' . $row->title . '" data-details="' . $row->details  . '" data-order="' . $row->order  . '"><i class="fa-solid fa-pen-to-square text-primary"></i></a>';
                    $action .= '<span style="margin-left: 10px;"></span>'; //Space placement to sepearte from each other
                    $action .= '|';
                    $action .= '<span style="margin-left: 10px;"></span>'; //Space placement to sepearte from each other
                } else if (!empty($post['type']) && $post['type'] == 'trashed') {
                    $action .= '<a href="javascript:;" class="restore" title="Restore Data" data-id="' . $row->id . '"><i class="fa-solid fa-undo text-success"></i></a>';
                    $action .= '<span style="margin-left: 10px;"></span>'; //Space placement to sepearte from each other
                    $action .= '|';
                    $action .= '<span style="margin-left: 10px;"></span>'; //Space placement to sepearte from each other
                }
                $action .= ' <a href="javascript:;" class="delete" name="Delete Data" data-id="' . $row->id . '"><i class="fa fa-trash text-danger"></i></a>';
                $array[$i]["action"]  = $action;
                $i++;
            }

            if (!$filtereddata) $filtereddata = 0;
            if (!$totalrecs) $totalrecs = 0;
        } catch (QueryException $e) {
            $array = [];
            $totalrecs = 0;
            $filtereddata = 0;
        } catch (Exception $e) {
            $array = [];
            $totalrecs = 0;
            $filtereddata = 0;
        }
        return response()->json(['recordsFiltered' => $filtereddata, 'recordsTotal' => $totalrecs, 'data' => $array]);
    }

    public function view(Request $request)
    {
        try {
            $post = $request->all();
            $valueDetails = OurValue::where('id', $post['id'])
                ->where('status', 'Y')
                ->first();
            $data = [
                'valueDetails' => $valueDetails,
            ];
            $data['type'] = 'success';
            $data['message'] = 'Successfully fetched data of portfolio.';
        } catch (QueryException $e) {
            $data['type'] = 'error';
            $data['message'] = $this->queryMessage;
        } catch (Exception $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        }
        return view('backend.our-value.view', $data);
    }

    public function delete(Request $request)
    {
        try {
            $post = $request->all();
            $type = 'success';
            $message = 'Record Deleted Successfully.';
            DB::beginTransaction();
            $result = OurValue::deleteData($post);
            if (!$result) {
                throw new Exception("Couldn't delete record.", 1);
            }
            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            $type = 'error';
            $message = $this->queryMessage;
        } catch (Exception $e) {
            DB::rollBack();
            $type = 'error';
            $message = $e->getMessage();
        }
        return response()->json(['type' => $type, 'message' => $message]);
    }

    public function restore(Request $request)
    {
        try {
            $post = $request->all();
            $type = 'success';
            $message = "Value restored successfully";

            DB::beginTransaction();
            $result = OurValue::restoreData($post);
            if (!$result) {
                throw new Exception("Could not restore Value. Please try again.", 1);
            }
            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            $type = 'error';
            $message = $this->queryMessage;
        } catch (Exception $e) {
            DB::rollBack();
            $type = 'error';
            $message = $e->getMessage();
        }
        return response()->json(['type' => $type, 'message' => $message]);
    }
}