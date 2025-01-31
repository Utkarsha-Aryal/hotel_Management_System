<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Common;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Storage;

class GalleryImage extends Model
{
    public function imageGallery()
    {
        return $this->belongsTo(Gallery::class, 'gallery_id');
    }

      // Save
      public static function saveData($post)
      {
          try {
              $dataArray = [];
  
              if (!empty($post['croppedImg'])) {
                  $fileName =  Common::uploadCroppedImage('gallery-image', $post['croppedImg']);
                  if (!$fileName) {
                      return false;
                  }
                  $dataArray['image'] = $fileName;
              } else {
  
                  // if (!empty($post['image'])) {
                  //     $fileName =  Common::uploadFile('gallery-image', $post['image']);
                  //     if (!$fileName) {
                  //         return false;
                  //     }
                  //     $dataArray['image'] = $fileName;
                  // }
                  //  else {
                  if (!empty($post['image'][0])) {
                      foreach ($post['image'] as $image) {
                          $fileName = Common::uploadFile('gallery-image', $image);
                          if (!$fileName) {
                              return false;
                          }
                          $dataArray[] = ['image' => $fileName, 'gallery_id' => $post['gallery_id']];
                      }
                  }
                  if (!empty($post['image_link'])) {
                      $dataArray = ['gallery_id' => $post['gallery_id'], 'image_link' => $post['image_link']];
                  }
              }
              // }
  
              if (!empty($post['id'])) {
                  // $dataArray['updated_at'] = Carbon::now();
                  if (!GalleryImage::where('id', $post['id'])->update($dataArray)) {
                      throw new Exception("Couldn't update Records", 1);
                  }
              } else {
                  // $dataArray['created_at'] = Carbon::now();
                  if (!GalleryImage::insert($dataArray)) {
                      throw new Exception("Couldn't Save Records", 1);
                  }
              }
  
              return true;
          } catch (Exception $e) {
              throw $e;
          }
      }

    //list

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

            $limit = 15;
            $offset = 0;

            if (!empty($get["length"]) && $get["length"]) {
                $limit = $get['length'];
                $offset = $get["start"];
            }
            $query = GalleryImage::selectRaw("count(*) OVER() AS totalrecs, id as id, image,image_link")
                // ->where(['gallery_id' => $get['gallery_id'], 'status' => 'Y'])
                ->where(['gallery_id' => $get['gallery_id']])
                ->whereRaw($cond);
            if ($limit > -1) {
                $query = $query->orderBy('id', 'DESC')->offset($offset)->limit($limit);
            } else {
                $query = $query->orderBy('id', 'DESC');
            }
            $result = $query->get();
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
