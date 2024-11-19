<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\FaqCategoryRequest;
use App\Models\Common;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\Faq;
use App\Models\FaqCategory;

class FaqCategoryController extends Controller
{
    public function index()
    {
        return view('backend.faq.category.index');
    }


    public function save(FaqCategoryRequest $request)
    {
        try {
            $post = $request->all();
            $type = 'success';
            $message = 'Records saved successfully';
            if (!empty($post['id'])) {
                $message = 'Records updated successfully';
            }
            DB::beginTransaction();
            $result = FaqCategory::saveFaq($post);
            if (!$result) {
                throw new Exception('Could not save record', 1);
            }
            DB::commit();
        } catch (ValidationException $e) {
            $type = 'error';
            $message = $e->getMessage();
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

    public function list(Request $request)
    {
        try {
            $post = $request->all();
            $data  = FaqCategory::getlist($post);
            $i = 0;
            $array = [];
            $filtereddata = ($data['totalfilteredrecs'] > 0 ? $data['totalfilteredrecs'] : $data['totalrecs']);
            $totalrecs = $data['totalrecs'];
            unset($data['totalfilteredrecs']);
            unset($data['totalrecs']);
            foreach ($data as $row) {
                $array[$i]['sno'] = $i + 1;
                $array[$i]['name']    = $row->name;
                $array[$i]['order_number']    = $row->order_number;
                $action = '';
                if (!empty($post['type']) && $post['type'] != 'trashed') {
                    $action .= '<a href="javascript:;" class="editFAQ" title="Edit Data" data-id="' . $row->id . '" data-name="' . $row->name . '" data-order_number="' . $row->order_number . '"><i class="fa-solid fa-pen-to-square text-primary"></i></a> |';
                } else if (!empty($post['type']) && $post['type'] == 'trashed') {
                    $action .= '<a href="javascript:;" class="restore" title="Restore Data" data-id="' . $row->id . '"><i class="fa-solid fa-undo text-success"></i></a> | ';
                }
                $faqId = $row->id;
                $faqsCheck = Faq::where('faq_category_id', $faqId)->where('status', 'Y')->first();
                if (empty($faqsCheck)) {
                    $action .= ' <a href="javascript:;" class="deleteFAQ" title="Delete Data" data-id="' . $row->id . '"><i class="fa fa-trash text-danger"></i></a>';
                }
                $array[$i]['action']  = $action;
                $i++;
            }
            if (!$filtereddata) $filtereddata = 0;
            if (!$totalrecs) $totalrecs = 0;
        } catch (QueryException $e) {
            $filtereddata = 0;
            $totalrecs = 0;
            $array = [];
        } catch (Exception $e) {
            $filtereddata = 0;
            $totalrecs = 0;
            $array = [];
        }
        return response()->json(["recordsFiltered" => @$filtereddata, "recordsTotal" => @$totalrecs, "data" => $array]);
    }

  
    public function delete(Request $request)
    {
        try {
            $type = 'success';
            $message = 'Record deleted successfully';
            $post = $request->all();
            $class = new FaqCategory();
            DB::beginTransaction();
            $result = FaqCategory::deleteFaqRelation($post, $class);
            if (!$result) {
                throw new Exception("Couldn't delete record", 1);
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
            $message = "FAQ Category restored successfully";
            DB::beginTransaction();
            $result = FaqCategory::restoreData($post);
            if (!$result) {
                throw new Exception("Could not restore FAQ Category. Please try again.", 1);
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
