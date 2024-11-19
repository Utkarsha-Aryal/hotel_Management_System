<?php

namespace App\Http\Controllers\backend;
use App\Http\Requests\TeamMemberRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TeamMember;
use App\Models\Common;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Database\QueryException;


class TeamMemberController extends Controller
{
    // construct
   

    // Home page
    public function index()
    {
        return view('backend.team-member.index');
    }

    // Save
    public function save(TeamMemberRequest $request)
    {
        try {
            $post = $request->all();
            $type = 'success';
            $message = 'Records saved successfully';
            DB::beginTransaction();
            $result = TeamMember::saveData($post);
            if (!$result) {
                throw new Exception('Could not save record', 1);
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

    // Get list
    public function list(Request $request)
    {
        try {
            $post = $request->all();
            $data = TeamMember::list($post);
            $i = 0;
            $array = [];
            $filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);
            $totalrecs = $data["totalrecs"];
            unset($data["totalfilteredrecs"]);
            unset($data["totalrecs"]);
            foreach ($data as $row) {
                $array[$i]["sno"] = $i + 1;
                $array[$i]["name"] = $row->name;
                $array[$i]["designation"] = Str::limit($row->designation, 45, '...');
                $array[$i]["order_number"] = $row->order_number;
                $array[$i]["email"] = $row->email;
                $array[$i]["phone_number"] = $row->phone_number;
                $array[$i]["experience"] = $row->experience;
                $array[$i]["short_bio"] = $row->short_bio;
                // $array[$i]["facebook_url"] = $row->facebook_url;
                // $array[$i]["instagram_url"] = $row->instagram_url;
                // $array[$i]["twitter_url"] = $row->twitter_url;
                $photo = asset('images/no-image.jpg');
                if (!empty($row->photo) && file_exists(public_path('/storage/community/' . $row->photo))) {
                    $photo = asset("storage/community/" . $row->photo);
                }
                $array[$i]["photo"] = '<img src="' . $photo . '" height="30px" width="30px" alt="image"/>';
                $action = '';
                if (!empty($post['type']) && $post['type'] != 'trashed') {
                    $action .= ' <a href="javascript:;" class="view-our-team" title="View Data" data-id="' . $row->id . '"><i class="fa-solid fa-eye" style="color: #008f47;"></i></i></a>';
                    $action .= '<span style="margin-left: 10px;"></span>'; //Space placement to sepearte from each other
                    $action .= '|';
                    $action .= '<a href="javascript:;" class="edit-our-team" name="Edit Data" data-id="' . $row->id . '"><i class="fa fa-pencil-alt text-primary"></i></a>';
                    $action .= '<span style="margin-left: 10px;"></span>'; //Space placement to sepearte from each other
                    $action .= '|';
                    $action .= '<span style="margin-left: 10px;"></span>'; //Space placement to sepearte from each other
                } else if (!empty($post['type']) && $post['type'] == 'trashed') {
                    $action .= '<a href="javascript:;" class="restore" title="Restore Data" data-id="' . $row->id . '"><i class="fa-solid fa-undo text-success"></i></a>';
                    $action .= '<span style="margin-left: 10px;"></span>'; //Space placement to sepearte from each other
                    $action .= '|';
                    $action .= '<span style="margin-left: 10px;"></span>'; //Space placement to sepearte from each other
                }
                $action .= '  <a href="javascript:;" class="delete-our-team" name="Delete Data" data-id="' . $row->id . '"><i class="fa fa-trash text-danger"></i></a>';
                $array[$i]["action"] = $action;
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
        return response()->json(["recordsFiltered" => $filtereddata, "recordsTotal" => $totalrecs, "data" => $array]);
    }

    // Form
    public function form(Request $request)
    {
        try {
            $post = $request->all();
            $prevTeamMemeber = [];
            if (!empty($post['id'])) {
                $prevTeamMemeber = TeamMember::where('id', $post['id'])
                    ->where('status', 'Y')
                    ->first();
            }
            $data = [
                'prevTeamMemeber' => $prevTeamMemeber
            ];
            //$data['id'] = $prevTeamMemeber->id;
            $data['type'] = 'success';
            $data['message'] = 'Successfully fetched data';
        } catch (QueryException $e) {
            $data['type'] = 'error';
            $data['message'] = $this->queryMessage;
        } catch (Exception $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        }
        return view('backend.team-member.form', $data);
    }
    
    // Delete
    public function delete(Request $request)
    {
        // $message = "Record deleted successfully";
        try {
            $type = 'success';
            $message = 'Record deleted successfully';
            $directory = storage_path('app/public/community');
            $post = $request->all();
            $class = new TeamMember();
            DB::beginTransaction();
            $result = Common::deleteSingleData($post, $class, $directory);
            if (!$result) {
                throw new Exception('Record does not deleted', 1);
            }
            // if (!Common::deleteRelationData($post, $class, $directory)) {
            //     throw new Exception("Couldn't delete record", 1);
            // }
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
            $message = "Team Member restored successfully";
            DB::beginTransaction();
            $result = TeamMember::restoreData($post);
            if (!$result) {
                throw new Exception("Could not restore Team Member. Please try again.", 1);
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

    //View details
    public function view(Request $request)
    {
        try {
            $post = $request->all();
            $TeamMemberDetails = TeamMember::where('id', $post['id'])
                ->where('status', 'Y')
                ->first();
            $data = [
                'TeamMemberDetails' => $TeamMemberDetails,
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
        return view('backend.team-member.view', $data);
    }
}