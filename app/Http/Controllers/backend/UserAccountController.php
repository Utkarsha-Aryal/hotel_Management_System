<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Exception;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\UserRole;

class UserAccountController extends Controller

{
    public function index(){
        return view('backend.user-account.index');
    }

    public function form(Request $request){
        try {
            $post = $request->all();
            $prevUserAccount = [];
            if(!empty($post['id'])){
                $prevUserAccount = User::where('id',$post['id'])->where(['status'=>'Y'])->first();
            }
            $data = [
                'prevUserAccount' => $prevUserAccount
            ];
            $data['type'] = 'success';
            $data['message'] = 'Successfully retrieve data.';
        } catch (QueryException $e) {
            $data['type'] = 'error';
            $data['message'] = $this->queryMessage;
        }catch (Exception $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        }
        return view('backend.user-account.form',$data);
    }

    public function save(UserRequest $request)
    {
        $post = $request->all();
        $type = 'success';
        $message = 'Record saved successfully';
    
        DB::beginTransaction();
        try {
            // Call the saveData method in the User model
            $user = User::saveData($post);
            if (!$user) {
                throw new Exception("Couldn't save user record", 1);
            }
    
            // Add the user ID to the $post data array for the role association
            $post['id'] = $user->id;
    
            // Call the saveData method in the UserRole model
            $userRole = UserRole::saveData($post);
            if (!$userRole) {
                throw new Exception('Could not save user role record');
            }
    
            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            $type = 'error';
            $message = 'Database query error: ' . $e->getMessage();
        } catch (Exception $e) {
            DB::rollBack();
            $type = 'error';
            $message = $e->getMessage();
        }
    
        return response()->json(['type' => $type, 'message' => $message]);
    }
    

    public function list(Request $request){
        try {
            $post = $request->all();
            $data =User::list($post);
            $i=0;
            $array = [];
            $filtereddata = ($data['totalfilteredrecs']> 0 ? $data['totalfilteredrecs'] : $data['totalrecs']);
            $totalrecs = $data['totalrecs'];
            unset($data['totalfilteredrecs']);
            unset($data['totalrecs']);
            foreach ($data as $row){
                $array[$i]['sno'] = $i +1;
                $array[$i]['name']= $row->full_name;
                $array[$i]['email']=$row->email;
                if ($row->UserRole) {
                    // Check if role is available within UserRole
                    if (is_array($row->UserRole) || $row->UserRole instanceof \Illuminate\Support\Collection) {
                        // If it's a collection, get the first role
                        $array[$i]['role'] = $row->UserRole->first()->role->role ?? 'N/A';
                    } else {
                        // If it's a single relationship, just get the role directly
                        $array[$i]['role'] = $row->UserRole->role->role ?? 'N/A';
                    }
                } else {
                    $array[$i]['role'] = 'N/A'; // Default if no role is found
                }
                $array[$i]['gender']=$row->gender;
                $array[$i]['mobile_number']=$row->phone_number;
                $array[$i]['address'] =$row->address;
                $image = asset('images/no-image.jpg');
                if (!empty($row->image) && file_exists(public_path('/storage/user-account/' . $row->image))) {
                    $image = asset("storage/user-account/" . $row->image);
                }
                $array[$i]["image"] = '<img src="' . $image . '" height="30px" width="30px" alt="image"/>';
                $action = '';
                if (!empty($post['type']) && $post['type'] != 'trashed') {
                    $action .= '<a href="javascript:;" class="edit" title="Edit Data" data-id="' . $row->id . '"><i class="fa-solid fa-pen-to-square text-primary"></i></a> | ';
                } else if (!empty($post['type']) && $post['type'] == 'trashed') {
                    $action .= '<a href="javascript:;" class="regenerate" title="Regenerate Data" data-id="' . $row->id . '"><i class="fa-solid fa-undo text-success"></i></a> | ';
                }
                $action .= '<a href="javascript:;" class="delete" title="Delete Data" data-id="' . $row->id . '"><i class="fa fa-trash text-danger"></i></a>';
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
        return response()->json(["recordsFiltered" => $filtereddata, "recordsTotal" => $totalrecs, "data" => $array]);
    }

    public function delete(Request $request)
    {
        try {
            $post = $request->all();
            $type='success';
            $message='Record deleted sucessfully';
            DB::beginTransaction();
            $result = User::deleteData($post);
            if(!$result){
                throw new Exception("Couldn't delete information please try again");
            }
            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            $type = 'error';
            $message = $this->queryMessage;
        } catch(Exception $e){
            DB::rollBack();
            $type = 'error';
            $message = $e->getMessage();
        }
        return response()->json(['type'=>$type,'message'=>$message]);
    }

    public function regenerate(Request $request){
        try {
            $post = $request->all();
            $type="sucess";
            $message="User Account regenarated sucessfully";
            DB::beginTransaction();
            $result=User::regenerateData($post);
            if(!$result){
                throw new Exception("Couldn't regenerate user account, Please try again");
            }
            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            $type = "error";
            $message =$this->queryMessage;
        }catch(Exception $e){
            DB::rollBack();
            $type="error";
            $message=$e->getMessage();
        }
        return response()->json(['type'=>$type,'message'=>$message]);
    }
}
