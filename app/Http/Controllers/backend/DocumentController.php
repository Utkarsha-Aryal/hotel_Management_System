<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Common;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Document;

class DocumentController extends Controller
{
    public function index()
    {
        return view('backend.document.index');
    }

    public function save(Request $request)
    {
        try {
            $rules = [
                'title' => 'required|min:3|max:255',
                'details' => 'nullable|max:255',
                'order' => 'required|numeric'
            ];
            if (empty($request->id)) {
                $rules['file'] = 'required|mimes:pdf|max:2048';
            } else {
                $rules['file'] = 'nullable|mimes:pdf|max:2048';
            }
            $message = [
                'title.required' => 'Please enter title',
            ];
            $validate = Validator::make($request->all(), $rules, $message);

            if ($validate->fails()) {
                throw new Exception($validate->errors()->first(), 1);
            }
            $post = $request->all();
            $type = 'success';
            $message = 'Records saved successfully';
            DB::beginTransaction();
            if (!Document::saveData($post)) {
                throw new Exception('Could not save record', 1);
            }
            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            $type = 'error';
            $message = $e->getMessage();
        } catch (Exception $e) {
            DB::rollBack();
            $type = 'error';
            $message = $e->getMessage();
        }
        return json_encode(['type' => $type, 'message' => $message]);
    }

    // get list
    public function list(Request $request)
    {
        try {
            $post = $request->all();
            $data = Document::list($post);
            $i = 0;
            $array = [];
            $filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);
            $totalrecs = $data["totalrecs"];
            unset($data["totalfilteredrecs"]);
            unset($data["totalrecs"]);
            foreach ($data as $row) {
                $array[$i]["sno"] = $i + 1;
                $array[$i]["title"]    = $row->title;
                $array[$i]["details"]  =  Str::limit($row->details, 70, '...');
                $array[$i]["order"] = $row->order_number;
                $array[$i]["file"]    = $row->file;
                $action = '';
                if (!empty($post['type']) && $post['type'] != 'trashed') {
                    $action .= '<a href="javascript:;" class=" edit" name="Edit Data" data-id="' . $row->id . '" data-title="' . $row->title . '" data-details="' . $row->details  . '" data-file="' . $row->file . '"data-order="' . $row->order_number . '"><i class="fa-solid fa-pen-to-square text-primary"></i></a> |';
                } else if (!empty($post['type'] && $post['type'] == 'trashed')) {
                    $action .= '<a href="javascript:;" class="restore" title="Restore Data" data-id="' . $row->id . '"><i class="fa-solid fa-undo text-success"></i></a> | ';
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
        return json_encode(array("recordsFiltered" => $filtereddata, "recordsTotal" => $totalrecs, "data" => $array));
    }

    public function delete(Request $request)
    {
        try {
            $type = 'success';
            $message = "Record deleted sucessfully";
            $directory = storage_path('app/public/document');
            $post = $request->all();
            $class = new Document();
            DB::beginTransaction();
            if (!Common::deleteSingleData($post, $class, $directory)) {
                throw new Exception("Record does not deleted", 1);
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
        return json_encode(['type' => $type, 'message' => $message]);
    }

    public function restore(Request $request)
    {
        try {
            $post = $request->all();
            $type = 'success';
            $message = "Document restored sucessfully";
            DB::beginTransaction();
            $result = Document::restoreData($post);
            if (!$result) {
                throw new Exception("Could not restore Document . Please try again.", 1);
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
