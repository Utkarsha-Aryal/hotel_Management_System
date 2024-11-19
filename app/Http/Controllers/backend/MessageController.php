<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\Message;
use App\Models\Common;
use Exception;
use App\Http\Requests\MessageRequest;

class MessageController extends Controller
{
    public function index()
    {
        return view('backend.message.index');
    }

     // form start
    public function form(Request $request)
     {
         try {
             $post = $request->all();
             $prevPost = [];
             if (!empty($post['id'])) {
                 $prevPost = Message::where('id', $post['id'])
                     ->where('status', 'Y')
                     ->first();
                 if (!$prevPost) {
                     throw new Exception("Couldn't found details.", 1);
                 }
             }
             $data = [
                 'prevPost' => $prevPost,
             ];
             if ($prevPost->image) {
                 $data['image'] = '<img src="' . asset('/storage/message') . '/' . $prevPost->image . '" class="_image" height="160px" width="160px" alt="' . ' No image"/>';
             } else {
                 $data['image'] = '<img src="' . asset('images/no-image.jpg') . '" class="_image" height="160px" width="160px" alt="' . ' No image"/>';
             }
             $data['type'] = 'success';
             $data['message'] = 'Successfully get data.';
         } catch (QueryException $e) {
             $data['type'] = 'error';
             $data['message'] = $this->queryMessage;
         } catch (Exception $e) {
             $data['type'] = 'error';
             $data['message'] = $e->getMessage();
         }
         return view('backend.message.form', $data);
     }
    //  form end
 
    /* save */
    public function save(MessageRequest $request)
    {
        try {
            $post = $request->all();
            $verify =  filterData($request->all());
            
            if(empty( $verify['message'])){
                throw new Exception('Please enter the message field',1);
            }
            $type = 'success';
            $message = 'Records saved successfully';
            DB::beginTransaction();
            $result = Message::saveData($post);
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
            $message = $e->getMessage();
        } catch (Exception $e) {
            DB::rollBack();
            $type = 'error';
            $message = $e->getMessage();
        }
        return response()->json(['type' => $type, 'message' => $message]);
    }
    // save end

    // Get list
    public function list(Request $request)
    {
        try {
            $post = $request->all();
            $data = Message::list($post);
            $i = 0;
            $array = [];
            $filtereddata = ($data['totalfilteredrecs'] > 0 ? $data['totalfilteredrecs'] : $data['totalrecs']);
            $totalrecs = $data['totalrecs'];
            unset($data['totalfilteredrecs']);
            unset($data['totalrecs']);
            foreach ($data as $row) {
                $array[$i]['sno'] = $i + 1;
                $array[$i]['order_number'] = $row->order_number;
                $array[$i]['designation'] = $row->designation;
                $array[$i]['message_by'] = strip_tags(Str::limit($row->message_by, 30, '...'));
                $array[$i]['message'] = (Str::limit($row->message, 30, '...'));
                $image = asset('images/no-image.jpg');
                if (!empty($row->image) && file_exists(public_path('/storage/message/' . $row->image))) {
                    $image = asset("storage/message/" . $row->image);
                }
                $array[$i]["image"] = '<img src="' . $image . '" height="30px" width="30px" alt="image"/>';
                $action = '';
                if (!empty($post['type']) && $post['type'] != 'trashed') {
                    $action .= ' <a href="javascript:;" class="viewMessage" title="View Data" data-id="' . $row->id . '"><i class="fa-solid fa-eye" style="color: #008f47;"></i></i></a>';
                    $action .= '<span style="margin-left: 10px;"></span>'; //Space placement to sepearte from each other
                    $action .= '|';
                    $action .= '<span style="margin-left: 10px;"></span>'; //Space placement to sepearte from each other
                    $action .= '<a href="javascript:;" class="editMessage" title="Edit Data" data-id="' . $row->id . '"><i class="fa-solid fa-pen-to-square text-primary"></i></a>';
                    $action .= '<span style="margin-left: 10px;"></span>'; //Space placement to sepearte from each other
                    $action .= '|';
                    $action .= '<span style="margin-left: 10px;"></span>'; //Space placement to sepearte from each other
                } else if (!empty($post['type']) && $post['type'] == 'trashed') {
                    $action .= '<a href="javascript:;" class="restore" title="Restore Data" data-id="' . $row->id . '"><i class="fa-solid fa-undo text-success"></i></a> ';
                    $action .= '<span style="margin-left: 10px;"></span>'; //Space placement to sepearte from each other
                    $action .= '|';
                    $action .= '<span style="margin-left: 10px;"></span>'; //Space placement to sepearte from each other
                }
                $action .= ' <a href="javascript:;" class="deleteMessage" title="Delete Data" data-id="' . $row->id . '"><i class="fa fa-trash text-danger"></i></a>';
                $array[$i]['action'] = $action;
                $i++;
            }
            if (!$filtereddata)
                $filtereddata = 0;
            if (!$totalrecs)
                $totalrecs = 0;
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
    // list end

    // view details
    public function view(Request $request)
    {
        try {
            $post = $request->all();
            $MessageDetails = Message::where('id', $post['id'])
                ->where('status', 'Y')
                ->first();
            $data = [
                'MessageDetails' => $MessageDetails,
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
        return view('backend.message.view', $data);
    }
    // view details end

    // Delete
    public function delete(Request $request)
    {
        try {
            $type = 'success';
            $message = 'Record deleted successfully';
            $directory = storage_path('app/public/message');
            $post = $request->all();
            $class = new Message();
            DB::beginTransaction();
            $result = Common::deleteSingleData($post, $class, $directory);
            if (!$result) {
                throw new Exception('Record does not deleted', 1);
            }
            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            $type = 'error';
            $message =  $e->getMessage();
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
            $message = "Post restored successfully";
            DB::beginTransaction();
            $result = Message::restoreData($post);
            if (!$result) {
                throw new Exception("Could not restore Post. Please try again.", 1);
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
