<?php

namespace App\Models;

use App\Models\Common;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Document extends Model
{
    use HasFactory;

    public static function saveData($post)
    {
        try {
            $dataArray = [
                'title' => $post['title'],
                'details' => $post['details'],
                'order_number' => $post['order']
            ];
            $dataArray = filterData($dataArray);
            if (!empty($post['file'])) {
                $fileName =  Common::uploadPDF('document', $post['file']);
                if (!$fileName) {
                    return false;
                }
                $dataArray['file'] = $fileName;
            }
            $dataArray['updated_at'] = Carbon::now();
            if (!empty($post['id'])) {
                if (!Document::where('id', $post['id'])->update($dataArray)) {
                    throw new Exception("Couldn't update File", 1);
                }
            } else {
                if (!Document::insert($dataArray)) {
                    throw new Exception("Couldn't Save File", 1);
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
                $cond .= " and lower(title) like '%" . $get['columns'][1]['search']['value'] . "%'";
            $limit = 15;
            $offset = 0;
            if (!empty($get["length"]) && $get["length"]) {
                $limit = $get['length'];
                $offset = $get["start"];
            }
            $query = Document::selectRaw("count(*) OVER() AS totalrecs, title, id as id, details, file,order_number")
                ->whereRaw($cond);
            if ($limit > -1) {
                $result = $query->orderBy('order_number', 'asc')->offset($offset)->limit($limit)->get();
            } else {
                $result = $query->orderBy('order_number', 'asc')->get();
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

    public static function restoreData($post)
    {
        try {
            $updatedArray = [
                'status' => 'Y',
                'updated_at' => Carbon::now(),
            ];
            if (!Document::where(['id' => $post['id']])->update($updatedArray)) {
                throw new Exception("Couldn't Restore Data. Please try again");
            }
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
