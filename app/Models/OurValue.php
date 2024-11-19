<?php

namespace App\Models;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OurValue extends Model
{
    use HasFactory;
    public static function saveData($post)
    {
        try {
            $dataArray = [
                'title' => strip_tags($post['title']),
                'details' => strip_tags($post['details']),
                'order' => strip_tags($post['order']),
                'meta_description' => $post['meta_description'],
                'meta_keywords'=> $post['meta_keywords']
            ];
            $dataArray = filterData($dataArray);
            if (!empty($post['id'])) {
                $dataArray['updated_at'] = Carbon::now();

                if (!OurValue::where('id', $post['id'])->update($dataArray)) {
                    throw new Exception("Couldn't update Record", 1);
                }
            } else {
                $dataArray['created_at'] = Carbon::now();
                if (!OurValue::insert($dataArray)) {

                    throw new Exception("Couldn't Save Record", 1);
                }
            }

            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

    // List
    public static function list($post)
    {
        try {
            $get = $post;

            $sorting = !empty($get['order'][0]['dir']) ? $get['order'][0]['dir'] : 'asc';
            $orderby = " `order` " . $sorting . "";
            if (!empty($get['order'][0]['column']) && $get['order'][0]['column'] == 3) {
                $orderby = " `order` " . $sorting . "";
            }

            foreach ($get['columns'] as $key => $value) {
                $get['columns'][$key]['search']['value'] = trim(strtolower(htmlspecialchars($value['search']['value'], ENT_QUOTES)));
            }
            $cond = " status = 'Y'";

            if (!empty($post['type']) && $post['type'] === "trashed") {
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

            $query = OurValue::selectRaw("(SELECT count(*) FROM our_values) AS totalrecs, title, id as id, details,`order`")
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

    public static function deleteData($post)
    {
        try {
            if ($post['type'] === 'trashed') {
                $valueDetails = OurValue::where('id', $post['id'])->first();
                if (empty($valueDetails)) {
                    throw new Exception("Couldn't found details. Please try again later.", 1);
                }

                if (!$valueDetails->delete()) {
                    throw new Exception("Couldn't delete value details", 1);
                }
            } else {
                $updateArray = [
                    'status' => 'N'
                ];
                if (!empty($post['id'])) {
                    $updateArray['updated_at'] = Carbon::now();
                    if (!OurValue::where('id', $post['id'])->update($updateArray)) {
                        throw new Exception("Error Processing Request", 1);
                    }
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
            if (!OurValue::where(['id' => $post['id']])->update($updateArray)) {
                throw new Exception("Couldn't Restore Data. Please try again", 1);
            }
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
