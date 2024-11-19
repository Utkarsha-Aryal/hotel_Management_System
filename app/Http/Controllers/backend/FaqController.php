<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class FaqController extends Controller
{
    public function index()
    {
        return view('backend.faq.faq.index');
    }
    
    // form start
    public function form(Request $request)
    {
        try {
            $post = $request->all();
            $category = FaqCategory::where('status', 'Y')->get();
            $prevFAQ = [];
            if (!empty($post['id'])) {
                $prevFAQ = Faq::where('id', $post['id'])
                    ->where('status', 'Y')
                    ->first();
            }
            $data = [
                'prevFAQ' => $prevFAQ,
                'category' => $category,
            ];
            $data['type'] = 'success';
            $data['message'] = 'Successfully retrieve data.';
        } catch (QueryException $e) {
            $data['type'] = 'error';
            $data['message'] = $this->queryMessage;
        } catch (Exception $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        }
        return view('backend.faq.faq.form', $data);
    }
    // form end

    // save
     public function save(Request $request)
       {
           try {
               $post = $request->all();
               $type = 'success';
               $message = 'Records saved successfully';
               if (!empty($post['id'])) {
                   $message = 'Records updated successfully';
               }
               DB::beginTransaction();
               $result = Faq::saveFaq($post);
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
    // save end 
   
    // list start
    public function list(Request $request)
    {
        try {
            $post = $request->all();
            $data = Faq::getlist($post);
            $i = 0;
            $array = [];
            $filtereddata = ($data['totalfilteredrecs'] > 0 ? $data['totalfilteredrecs'] : $data['totalrecs']);
            $totalrecs = $data['totalrecs'];
            unset($data['totalfilteredrecs']);
            unset($data['totalrecs']);
            foreach ($data as $row) {
                $array[$i]['sno'] = $i + 1;
                $array[$i]['faq_category'] = Str::limit($row->faqCategory->name, 25, '...');
                $array[$i]['question'] = Str::limit($row->question, 25, '...');
                $array[$i]['answer'] = Str::limit($row->answer, 25, '...');
                $array[$i]['order_number'] = $row->order_number;
                $action = '';
                if (!empty($post['type']) && $post['type'] != 'trashed') {
                    $action .= ' <a href="javascript:;" class="viewFaq" title="View Data" data-id="' . $row->id . '"><i class="fa-solid fa-eye" style="color: #008f47;"></i></i></a>';
                    $action .= '<span style="margin-left: 15px;"></span>'; //Space placement to sepearte from each other
                    $action .= '|';
                    $action .= '<span style="margin-left: 15px;"></span>'; //Space placement to sepearte from each other
                    $action .= '<a href="javascript:;" class="addFAQ" title="Edit Data" data-id="' . $row->id . '"><i class="fa-solid fa-pen-to-square text-primary"></i></a>';
                    $action .= '<span style="margin-left: 15px;"></span>'; //Space placement to sepearte from each other
                    $action .= '|';
                    $action .= '<span style="margin-left: 15px;"></span>'; //Space placement to sepearte from each other
                } else if (!empty($post['type']) && $post['type'] == 'trashed') {
                    $action .= '<a href="javascript:;" class="restore" title="Restore Data" data-id="' . $row->id . '"><i class="fa-solid fa-undo text-success"></i></a> | ';
                }
                $action .= ' <a href="javascript:;" class="deleteFAQ" title="Delete Data" data-id="' . $row->id . '"><i class="fa fa-trash text-danger"></i></a>';
                $array[$i]['action'] = $action;
                $i++;
            }
            if (!$filtereddata)
                $filtereddata = 0;
            if (!$totalrecs)
                $totalrecs = 0;
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
    // list end

    // view details start
    public function view(Request $request)
    {
        try {
            $post = $request->all();
            $faqDetails = Faq::where('id', $post['id'])
                ->where('status', 'Y')
                ->first();
            $data = [
                'faqDetails' => $faqDetails,
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
        return view('backend.faq.faq.view', $data);
    }
    // view details end

    // delete start
    public function delete(Request $request)
    {
        try {
            $type = 'success';
            $message = 'Record deleted successfully';
            $post = $request->all();
            DB::beginTransaction();
            $result = Faq::deleteData($post);
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
    // delete end

    // restore start
    public function restore(Request $request)
    {
        try {
            $post = $request->all();
            $type = 'success';
            $message = "FAQ restored successfully";
            DB::beginTransaction();
            $result = Faq::restoreData($post);
            if (!$result) {
                throw new Exception("Could not restore FAQ. Please try again.", 1);
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
    // restore end
}