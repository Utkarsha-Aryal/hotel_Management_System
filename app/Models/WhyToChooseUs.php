<?php

namespace App\Models;

use App\Models\Common;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhyToChooseUs extends Model
{
    use HasFactory;

    // getlist 
    public static function getlist($post)
    {
        try {
            $post = Common::filterData($post);
            $get = $post;
            $sorting = !empty($get['order'][0]['dir']) ? $get['order'][0]['dir'] : 'asc';
            $orderby = " order_number " . $sorting . "";
            if (!empty($get['order'][0]['column']) && $get['order'][0]['column'] == 3) {
                $orderby = " order_number " . $sorting . "";
            }
            foreach ($get['columns'] as $key => $value) {
                $get['columns'][$key]['search']['value'] = trim(strtolower(htmlspecialchars($value['search']['value'], ENT_QUOTES)));
            }
            $cond = " status = 'Y'";
            if (!empty($post['type']) && $post['type'] === 'trashed') {
                $cond = " status = 'N'";
            }
            if ($get['columns'][1]['search']['value'])
                $cond .= " and lower(title) like '%" . $get['columns'][1]['search']['value'] . "%'";
            $limit = 15;
            $offset = 0;
            if (!empty($get["length"]) && $get["length"]) {
                $limit = $get['length'];
                $offset = $get["start"];
            }
            $query = WhyToChooseUs::selectRaw("(SELECT count(*) FROM why_to_choose_us) AS totalrecs, id, title, description,affordability,academics,inspiring, order_number, icon")
                ->whereRaw($cond);
            if ($limit > -1) {
                $result = $query->orderByRaw($orderby)->offset($offset)->limit($limit)->get();
            } else {
                $result = $query->orderByRaw($orderby)->get();
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

    // save records
    public static function saveData($post)
    {
        try {
            $insertArray = [
                'title' => strip_tags($post['title']),
                'description' => strip_tags($post['description']),
                'order_number' => $post['order_number'],
                'affordability' => $post['affordability'],
                'inspiring' => $post['inspiring'],
            ];
            $insertArray = filterData($insertArray);
            if (!empty($post['icon'])) {
                $fileName =  Common::uploadFile('why-to-choose-us', $post['icon']);
                if (!$fileName) {
                    return false;
                }
                $insertArray['icon'] = $fileName;
            }
            if (!empty($post['id'])) {
                $insertArray['updated_at'] = Carbon::now();
                if (!WhyToChooseUs::where('id', $post['id'])->update($insertArray)) {
                    throw new Exception("Couldn't update record", 1);
                }
            } else {
                $insertArray['created_at'] = Carbon::now();
                if (!WhyToChooseUs::insert($insertArray)) {
                    throw new Exception("Couldn't Save Records", 1);
                }
            }
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

    // delete
    public static function deleteData($post)
    {
        try {
            if ($post['type'] === "trashed") {
                $filepath = storage_path('app/public/why-to-choose-us/');
                // Getting details 
                $WhyToChooseUs = WhyToChooseUs::where('id', $post['id'])->first();
                // Deleting the previous icon if it exists
                if (!empty($WhyToChooseUs->icon)) {
                    $previousIconPath = $filepath . $WhyToChooseUs->icon;
                    if (file_exists($previousIconPath)) {
                        unlink($previousIconPath);
                    }
                }
                if (!$WhyToChooseUs->delete()) {
                    throw new Exception("Couldn't Delete Data. Please try again", 1);
                }
            } else {
                if (!WhyToChooseUs::where(['id' => $post['id']])->update(['status' => 'N', 'updated_at' => Carbon::now()])) {
                    throw new Exception("Couldn't Delete Data. Please try again", 1);
                }
            }
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function restoreData($post)
    {
        try {
            $updateArray = [
                'status' => 'Y',
                'updated_at' => Carbon::now(),
            ];
            if (!WhyToChooseUs::where(['id' => $post['id']])->update($updateArray)) {
                throw new Exception("Couldn't Restore Data. Please try again", 1);
            }
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }
}

