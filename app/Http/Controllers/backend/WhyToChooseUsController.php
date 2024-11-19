<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\WhyToChooseUsRequest;
use App\Models\WhyToChooseUs;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class WhyToChooseUsController extends Controller
{
    public function index()
    {
        return view('backend.why-to-choose-us.index');
    }

     // save start
    public function save(WhyToChooseUsRequest $request)
     {
         try {
             $post = $request->all();
             $type = 'success';
             $message = 'Records saved successfully';
             DB::beginTransaction();
             $result = WhyToChooseUs::saveData($post);
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
 
    // getlis start
    public function getlist(Request $request)
    {
        try {
            $post = $request->all();
            $data = WhyToChooseUs::getlist($post);
            $i = 0;
            $array = [];
            $filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);
            $totalrecs = $data["totalrecs"];
            unset($data["totalfilteredrecs"]);
            unset($data["totalrecs"]);
            foreach ($data as $row) {
                $array[$i]["sno"] = $i + 1;
                $array[$i]["icon"]  = $row->icon;
                $array[$i]["order_number"]     = $row->order_number;
                $array[$i]["title"]   = Str::limit($row->title, 15, '...');
                $icon = asset('images/no-image.jpg');
                if (!empty($row->icon) && file_exists(public_path('/storage/why-to-choose-us/' . $row->icon))) {
                    $icon = asset("storage/why-to-choose-us/" . $row->icon);
                }
                $array[$i]["icon"] = '<img src="' . $icon . '" height="30px" width="30px" alt="image"/>';
                $action = '';
                if (!empty($post['type']) && $post['type'] != 'trashed') {
                    $action .= ' <a href="javascript:;" class="viewWhyChooseUs" title="View Data" data-id="' . $row->id . '"><i class="fa-solid fa-eye" style="color: #008f47;"></i></i></a>';
                    $action .= '<span style="margin-left: 10px;"></span>'; //Space placement to sepearte from each other
                    $action .= '|';
                    $action .= '<span style="margin-left: 10px;"></span>'; //Space placement to sepearte from each other
                    $action .= '<a href="javascript:;" class=" editWhyToChooseUs" name="Edit Data" 
                    data-id="' . $row->id . '" 
                    data-title="' . $row->title . '" 
                    data-description="' . $row->description . '" 
                    data-affordability="' . $row->affordability . '" 
                    data-academics="' . $row->academics . '" 
                    data-inspiring="' . $row->inspiring . '" 
                    data-order_number="' . $row->order_number . '" 
                    data-icon="' . $icon . '"><i class="fa-solid fa-pen-to-square text-primary"></i></a>';
                    $action .= '<span style="margin-left: 10px;"></span>'; //Space placement to sepearte from each other
                    $action .= '|';
                    $action .= '<span style="margin-left: 10px;"></span>'; //Space placement to sepearte from each other
                } else if (!empty($post['type']) && $post['type'] == 'trashed') {
                    $action .= '<a href="javascript:;" class="restore" title="Restore Data" data-id="' . $row->id . '"><i class="fa-solid fa-undo text-success"></i></a>';
                    $action .= '<span style="margin-left: 10px;"></span>'; //Space placement to sepearte from each other
                    $action .= '|';
                    $action .= '<span style="margin-left: 10px;"></span>'; //Space placement to sepearte from each other
                }
                $action .= ' <a href="javascript:;" class="deleteWhyToChooseUs" name="Delete Data" data-id="' . $row->id . '"><i class="fa fa-trash text-danger"></i></a>';
                $array[$i]["action"]  = $action;
                $i++;
            }
        } catch (QueryException $e) {
            $array = [];
            $totalrecs = 0;
            $filtereddata = 0;
        } catch (Exception $e) {
            $array = [];
            $totalrecs = 0;
            $filtereddata = 0;
        }
        return response()->json(["recordsFiltered" => $filtereddata, "recordsTotal" => $totalrecs, "data" => $array]);
    }
    // getlis end

    // view details start
    public function view(Request $request)
    {
          try {
              $post = $request->all();
              $whyChooseUsDetails = WhyToChooseUs::where('id', $post['id'])
                  ->where('status', 'Y')
                  ->first();
              $data = [
                  'whyChooseUsDetails' => $whyChooseUsDetails,
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
          return view('backend.why-to-choose-us.view', $data);
    }
    // view details end

    // delete start
    public function delete(Request $request)
    {
        try {
            $post = $request->all();
            $type = 'success';
            $message = "Record deleted successfully";
            DB::beginTransaction();
            $result = WhyToChooseUs::deleteData($post);
            if (!$result) {
                throw new Exception("Couldn't deleted record ", 1);
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
            $message = "Why Choose Us restored successfully";
            DB::beginTransaction();
            $result = WhyToChooseUs::restoreData($post);
            if (!$result) {
                throw new Exception("Could not restore Why Choose Us. Please try again.", 1);
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
