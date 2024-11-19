<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use App\Models\Common;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Requests\TestimonialRequest;




class TestimonialController extends Controller
{
    public function index()
    {
        return view('backend.testimonial.index');
    }

    /* save */
    public function save(TestimonialRequest $request)
    {
        try {
            $post = $request->all();
            $type = 'success';
            $message = 'Records saved successfully';
            DB::beginTransaction();
            $result = Testimonial::saveData($post);
            if (!$result) {
                throw new Exception('Could not save record', 1);
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

    // Get list
    public function list(Request $request)
    {
        try {
            $post = $request->all();
            $data = Testimonial::list($post);
            $i = 0;
            $array = [];
            $filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);
            $totalrecs = $data["totalrecs"];
            unset($data["totalfilteredrecs"]);
            unset($data["totalrecs"]);
            foreach ($data as $row) {
                $array[$i]["sno"] = $i + 1;
                $array[$i]["name"] = $row->name;
                $array[$i]["order_number"] = $row->order_number;
                $array[$i]["review"] = Str::limit($row->review, 30, '...');
                $array[$i]["designation"] = $row->designation;
                $array[$i]["student_course"] = $row->student_course;
                $array[$i]["rating"] = $row->rating;
                $image = asset('/images/no-image.jpg');
                if (!empty($row->image) && file_exists(public_path('/storage/testimonial/' . $row->image))) {
                    $image = asset('/storage/testimonial') . '/' . $row->image;
                }
                $array[$i]["image"] = '<img src="' . $image . '" height="30px" width="30px" alt="' . ' image"/>';
                $action = '';
                if (!empty($post['type']) && $post['type'] != 'trashed') {
                    $action .= ' <a href="javascript:;" class="viewTestimonial" title="View Data" data-id="' . $row->id . '"><i class="fa-solid fa-eye" style="color: #008f47;"></i></i></a> |';
                    $action .= '<span style="margin-left: 3px;"></span>';
                    $action .= '<a href="javascript:;" class="editTestimonial" name="Edit Data" data-id="' . $row->id . '" data-name="' . $row->name . '" data-review="' . $row->review . '" data-designation="' . $row->designation . '" data-order_number="' . $row->order_number . '" data-image="' . $image . '" data-course="' . $row->student_course . '" data-rating="' . $row->rating . '"><i class="fa-solid fa-pen-to-square text-primary"></i></a> | ';
                } else if (!empty($post['type']) && $post['type'] == 'trashed') {
                    $action .= '<a href="javascript:;" class="restore" title="Restore Data" data-id="' . $row->id . '"><i class="fa-solid fa-undo text-success"></i></a> | ';
                }
                $action .= ' <a href="javascript:;" class="deleteTestimonial" name="Delete Data" data-id="' . $row->id . '"><i class="fa fa-trash text-danger"></i></a>';
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
            dd($e);
        } catch (Exception $e) {
            $array = [];
            $totalrecs = 0;
            $filtereddata = 0;
        }
        return response()->json(array("recordsFiltered" => $filtereddata, "recordsTotal" => $totalrecs, "data" => $array));
    }

    public function view(Request $request)
    {
        try {
            $post = $request->all();
            $testimonialDetails = Testimonial::where('id', $post['id'])
                ->where('status', 'Y')
                ->first();
            $data = [
                'testimonialDetails' => $testimonialDetails,
            ];
            $data['type'] = 'success';
            $data['message'] = 'Successfully fetched data of Testimonial.';
        } catch (QueryException $e) {
            $data['type'] = 'error';
            $data['message'] = $this->queryMessage;
        } catch (Exception $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        }
        return view('backend.testimonial.view', $data);
    }

    // Delete
    public function delete(Request $request)
    {
        try {
            $type = 'success';
            $message = "Record deleted successfully";
            $directory = storage_path('app/public/testimonial');
            $post = $request->all();
            $class = new Testimonial();
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
        return response()->json(['type' => $type, 'message' => $message]);
    }

    public function restore(Request $request)
    {
        try {
            $post = $request->all();
            $type = 'success';
            $message = "Testimonial restored successfully";
            DB::beginTransaction();
            $result = Testimonial::restoreData($post);
            if (!$result) {
                throw new Exception("Could not restore Testimonial. Please try again.", 1);
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
