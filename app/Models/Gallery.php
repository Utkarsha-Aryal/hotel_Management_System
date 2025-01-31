<?php

namespace App\Models;
use App\Models\Common;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Illuminate\Support\Str;

class Gallery extends Model
{
    public function images()
    {
        return $this->hasMany(GalleryImage::class)->where('status','Y');
    }



    public static function saveData($post)
    {
        try {
            $dataArray = [
                'name' => $post['name'],
                'slug' =>  Str::slug($post['name']) . '-' . time(),
            ];

            if (!empty($post['croppedImg'])) {
                $fileName =  Common::uploadCroppedImage('gallery-image', $post['croppedImg']);
                if (!$fileName) {
                    return false;
                }
                $dataArray['image'] = $fileName;
            } else {


                if (!empty($post['image'])) {
                    $fileName =  Common::uploadFile('gallery-image', $post['image']);
                    if (!$fileName) {
                        return false;
                    }
                    $dataArray['image'] = $fileName;
                }
            }
            if (!empty($post['id'])) {
                $dataArray['updated_at'] = Carbon::now();
                if (!Gallery::where('id', $post['id'])->update($dataArray)) {
                    throw new Exception("Couldn't update Records", 1);
                }
            } else {
                $dataArray['created_at'] = Carbon::now();
                if (!Gallery::insert($dataArray)) {
                    throw new Exception("Couldn't Save Records", 1);
                }
            }

            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function list($post)
    {
        try {
            $get = $post;
            foreach ($get['columns'] as $key => $value) {
                $get['columns'][$key]['search']['value'] = trim(strtolower(htmlspecialchars($value['search']['value'], ENT_QUOTES)));
            }

            $cond = " status = 'Y'";

            if (!empty($post['type']) && $post['type'] === "trashed") {
                $cond = " status = 'N'";
            }

            if ($get['columns'][1]['search']['value'])
                $cond .= " and lower(name) like '%" . $get['columns'][1]['search']['value'] . "%'";

            $limit = 15;
            $offset = 0;
            if (!empty($get["length"]) && $get["length"]) {
                $limit = $get['length'];
                $offset = $get["start"];
            }

            $query = Gallery::selectRaw("count(*) OVER() AS totalrecs, name,image, id as id")
                ->whereRaw($cond);

            if ($limit > -1) {
                $result = $query->orderBy('id', 'desc')->offset($offset)->limit($limit)->get();
            } else {
                $result = $query->orderBy('id', 'desc')->get();
            }
            if ($result) {
                $ndata = $result;
                $ndata['totalrecs'] = @$result[0]->totalrecs ? $result[0]->totalrecs : 0;
                $ndata['totalfilteredrecs'] = @$result[0]->totalrecs ? $result[0]->totalrecs : 0;
            } else {
                $ndata = array();
            }

            return $ndata;
        } catch (Exception $e) {
            throw $e;
        }
    }


}
