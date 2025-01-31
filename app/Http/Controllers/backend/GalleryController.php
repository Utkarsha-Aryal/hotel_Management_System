<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Models\Common;
use Illuminate\Support\Facades\DB;

class GalleryController extends Controller
{
    public function index(){

        return view('backend.gallery.index');
    }

    public function save(Request $request)
    {
        try {           
             $post = $request->all();
            $type = 'success';
            $message = 'Records saved successfully';

            DB::beginTransaction();

            if (!Gallery::saveData($post)) {
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
        return json_encode(['type' => $type, 'message' => $message]);

    }

    public function list(Request $request)
    {
        try {
            $post = $request->all();
            $data = Gallery::list($post);
            $i = 0;
            $array = [];
            $filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);
            $totalrecs = $data["totalrecs"];

            unset($data["totalfilteredrecs"]);
            unset($data["totalrecs"]);
            foreach ($data as $row) {
                $array[$i]["sno"] = $i + 1;
                $array[$i]["name"]    = $row->name;

                if (!empty($row->image)) {
                    $array[$i]["image"]  = '<img src="' . asset('/storage/gallery-image') . '/' . $row->image . '" height="30px" width="30px" alt="' . ' image"/>';
                } else {
                    $array[$i]["image"]  = '<img src="' . asset('/no-image.jpg') . '" height="30px" width="30px" alt="' . ' image"/>';
                }
                $action = '';

                if (!empty($post['type']) && $post['type'] != 'trashed') {
                    $action .= '<a href="javascript:;" class="addImageButton"  data-id="' . $row->id . '"><button class="btn btn-primary label-btn"><i class="bi bi-image label-btn-icon me-2"></i> Add images</button></a>';
                   $action .= '<a href="javascript:;" class="editGallery" title="Edit Data" data-id="' . $row->id . '" data-name="' . $row->name . '" data-image="' . $row->image  . '"><button class="btn btn-success label-btn ms-2"><i class="bi bi-pencil label-btn-icon me-2"></i>Edit Album</button></a>';
                }
                $action .= '<a href="javascript:;" class="deleteGallery" title="Delete Data" data-id="' . $row->id . '"><button class="btn btn-danger label-btn ms-2">Delete Album<i class="bi bi-trash label-btn-icon"></i></button></a>';
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
        try{
            $type = 'success';
            $message = 'Record deleted successfully';
            $directory = storage_path('app/public/gallery-image');
            $post = $request->all();
            $class = new Gallery();

            DB::beginTransaction();
            if (!Common::deleteSingleData($post, $class, $directory)) {
                throw new Exception("Record does not deleted", 1);
            }
            DB::commit();

        }catch(QueryException $e){

        }catch(Exception $e){

        }
        return json_encode(['type'=>$type,'message'=>$message]);
    }
}
