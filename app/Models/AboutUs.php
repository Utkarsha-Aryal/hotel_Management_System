<?php

namespace App\Models;
use App\Models\Common;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Exception;
use Carbon\Carbon;

class AboutUs extends Model
{
    use HasFactory;

    public static function updatedata($post)
    {
        try {
            $updateArray = [
                'introduction' => strip_tags($post['introduction']),
                'founder_name' => strip_tags($post['founder_name']),
                'founder_message' => strip_tags($post['founder_message']),
                'vision' => strip_tags($post['vision']),
                'mission' => strip_tags($post['mission']),
                'video_title' => $post['video_title'],
                'video_url' => $post['video_url'],
            ];
            $updateArray = filterData($updateArray);

            if (!empty($post['img_introduction'])) {
                $fileName = Common::uploadFile('aboutus', $post['img_introduction']);
                if (!$fileName) {
                    return false;
                }
                $updateArray['img_introduction'] = $fileName;
            }
            if (!empty($post['founder_image'])) {
                $fileName = Common::uploadFile('aboutus', $post['founder_image']);
                if (!$fileName) {
                    return false;
                }
                $updateArray['founder_image'] = $fileName;
            }
            if (!empty($post['vision_image'])) {
                $fileName = Common::uploadFile('aboutus', $post['vision_image']);
                if (!$fileName) {
                    return false;
                }
                $updateArray['vision_image'] = $fileName;
            }
            if (!empty($post['mission_image'])) {
                $fileName = Common::uploadFile('aboutus', $post['mission_image']);
                if (!$fileName) {
                    return false;
                }
                $updateArray['mission_image'] = $fileName;
            }
            $updateArray['updated_at'] = Carbon::now();
            if (!AboutUs::where('id', 1)->update($updateArray)) {
                throw new Exception("Couldn't Save Records", 1);
            }
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
