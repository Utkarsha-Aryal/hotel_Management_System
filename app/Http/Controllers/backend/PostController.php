<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Common;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\Post;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{
    public function index()
    {
        return view('backend.post.index');
    }

      //form start
    public function form(Request $request)
      {
          try {
              $post = $request->all();
              $prevPost = [];
              if (!empty($post['id'])) {
                  $prevPost = Post::where('id', $post['id'])
                      ->where('status', 'Y')
                      ->first();
                  if (!$prevPost) {
                      throw new Exception("Couldn't found details.", 1);
                  }
              }
              $data = [
                  'prevPost' => $prevPost
              ];
              $data['id'] = $prevPost->id;
              if ($prevPost->image) {
                  $data['image'] = '<img src="' . asset('/storage/post') . '/' . $prevPost->image . '" class="_image" height="160px"  alt="' . ' No image"/>';
              } else {
                  $data['image'] = '<img src="' . asset('/no-image.jpg') . '" class="_image" height="100px" width="160px" alt="' . ' No image"/>';
              }
              if ($prevPost->feature_image) {
                  $decodedFeatureImages = json_decode($prevPost->feature_image, true);
                  $data['decodedFeatureImages'] = $decodedFeatureImages;
              } else {
                  $data['feature_image'] = '<img src="' . asset('/no-image.jpg') . '" class="_image" height="160px" width="160px" alt="' . ' No image"/>';
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
          return view('backend.post.form', $data);
     }
    // form end

    // save start
    public function save(PostRequest $request)
    {
        try {
            $post = $request->all();
            $verify =  filterData($request->all());
            if(empty( $verify['details']) ){
                throw new Exception('Please enter the details field',1);
            }
            $type = 'success';
            $message = 'Records saved successfully';
            DB::beginTransaction();

            $result = Post::saveData($post);
            
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

    // Get list start
    public function list(Request $request)
    {
        try {
            $post = $request->all();
            $data = Post::list($post);
            $i = 0;
            $array = [];
            $filtereddata = ($data['totalfilteredrecs'] > 0 ? $data['totalfilteredrecs'] : $data['totalrecs']);
            $totalrecs = $data['totalrecs'];
            unset($data['totalfilteredrecs']);
            unset($data['totalrecs']);
            foreach ($data as $row) {
                $array[$i]['sno'] = $i + 1;
                $array[$i]['category'] = $row->category;
                $array[$i]['posted_by'] = $row->postedBy->name;
                $array[$i]['author'] = $row->author;
                $array[$i]['published_date'] = $row->published_date;
                $array[$i]['meta_description'] = $row->meta_description;
                $array[$i]['meta_keywords'] = $row->meta_keywords;
                $array[$i]['title'] = strip_tags(Str::limit($row->title, 30, '...'));
                $array[$i]['details'] = (Str::limit($row->details, 30, '...'));
                $image = asset('images/no-image.jpg');
                if (!empty($row->image) && file_exists(public_path('/storage/post/' . $row->image))) {
                    $image = asset("storage/post/" . $row->image);
                }
                $array[$i]["image"] = '<img src="' . $image . '" height="30px" width="30px" alt="image"/>';
                $action = '';
                if (!empty($post['type']) && $post['type'] != 'trashed') {
                    $action .= ' <a href="javascript:;" class="viewPost" title="View Data" data-id="' . $row->id . '"><i class="fa-solid fa-eye" style="color: #008f47;"></i></i></a>';
                    $action .= '<span style="margin-left: 10px;"></span>'; //Space placement to sepearte from each other
                    $action .= '|';
                    $action .= '<span style="margin-left: 10px;"></span>'; //Space placement to sepearte from each other
                    $action .= '<a href="javascript:;" class="editNews" title="Edit Data" data-id="' . $row->id . '"><i class="fa-solid fa-pen-to-square text-primary"></i></a>';
                    $action .= '<span style="margin-left: 10px;"></span>'; //Space placement to sepearte from each other
                    $action .= '|';
                    $action .= '<span style="margin-left: 10px;"></span>'; //Space placement to sepearte from each other
                } else if (!empty($post['type']) && $post['type'] == 'trashed') {
                    $action .= '<a href="javascript:;" class="restore" title="Restore Data" data-id="' . $row->id . '"><i class="fa-solid fa-undo text-success"></i></a> ';
                    $action .= '<span style="margin-left: 10px;"></span>'; //Space placement to sepearte from each other
                    $action .= '|';
                    $action .= '<span style="margin-left: 10px;"></span>'; //Space placement to sepearte from each other
                }
                $action .= ' <a href="javascript:;" class="deleteNews" title="Delete Data" data-id="' . $row->id . '"><i class="fa fa-trash text-danger"></i></a>';
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
            dd($e);
        } catch (Exception $e) {
            $array = [];
            $totalrecs = 0;
            $filtereddata = 0;
        }
        return response()->json(['recordsFiltered' => $filtereddata, 'recordsTotal' => $totalrecs, 'data' => $array]);
    }
    // Get list end 

    // view details
    public function view(Request $request)
    {
        try {
            $post = $request->all();
            $postDetails = Post::where('id', $post['id'])
                ->where('status', 'Y')
                ->first();

            $data = [
                'postDetails' => $postDetails,
            ];
            if ($postDetails->feature_image) {
                $decodedFeatureImages = json_decode($postDetails->feature_image, true);
                $data['decodedFeatureImages'] = $decodedFeatureImages;
            }
            // } else {
            //     $data['feature_image'] = '<img src="' . asset('/no-image.jpg') . '" class="_image" height="160px" width="160px" alt="' . ' No image"/>';
            // }
            $data['type'] = 'success';
            $data['message'] = 'Successfully fetched data of portfolio.';
        } catch (QueryException $e) {
            $data['type'] = 'error';
            $data['message'] = $this->queryMessage;
        } catch (Exception $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        }
        return view('backend.post.view', $data);
    }

    // Delete
    public function delete(Request $request)
    {
        try {
            $type = 'success';
            $message = 'Record deleted successfully';
            $directory = storage_path('app/public/post');
            $post = $request->all();
            $class = new Post();
            DB::beginTransaction();
            $result = Common::deleteSingleData($post, $class, $directory);
            if (!$result) {
                throw new Exception('Record does not deleted', 1);
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

    // restore start
    public function restore(Request $request)
    {
        try {
            $post = $request->all();
            $type = 'success';
            $message = "Post restored successfully";
            DB::beginTransaction();
            $result = Post::restoreData($post);
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
    
    // deletefeatureimage start
    public function deleteFeatureImage(Request $request)
    {
        try {
            $type = "success";
            $message = "Successfully Deleted Feature Image";
            $post = $request->all();
            DB::beginTransaction();
            if (!Post::deleteFeatureImage($post)) {
                throw new Exception("Couldn't Delete Feature Image. Please Try Again", 1);
            }
            // $this->form($request);
            DB::commit();
        } catch (QueryException) {
            DB::rollBack();
            $type = "error";
            $message = $this->queryMessage();
        } catch (Exception $e) {
            DB::rollBack();
            $type = "error";
            $message = $e->getMessage();
        }
        return json_encode(['type' => $type, 'message' => $message]);
    }
    // deletefeatureimage end
}
