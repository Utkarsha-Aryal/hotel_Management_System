<?php

namespace App\Models;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;
    public function faqCategory()
    {
        return $this->belongsTo(FaqCategory::class, 'faq_category_id');
    }

    // list
    public static function getlist($post)
    {
        try {
            $get = $post;
            $sorting = !empty($get['order'][0]['dir']) ? $get['order'][0]['dir'] : 'asc';
            $orderby = " order_number " . $sorting . "";
            if (!empty($get['order'][0]['column']) && $get['order'][0]['column'] == 4) {
                $orderby = " order_number " . $sorting . "";
            }
            foreach ($get['columns'] as $key => $value) {
                $get['columns'][$key]['search']['value'] = trim(strtolower(htmlspecialchars($value['search']['value'], ENT_QUOTES)));
            }
            $cond = " status = 'Y' ";
            if (!empty($post['type']) && $post['type'] === "trashed") {
                $cond = " status = 'N' ";
            }
            if ($get['columns'][1]['search']['value'])
                $cond .= " and lower(name) like '%" . $get['columns'][2]['search']['value'] . "%'";
            $limit = 15;
            $offset = 0;
            if (!empty($get["length"]) && $get["length"]) {
                $limit = $get['length'];
                $offset = $get["start"];
            }
            $query = Faq::with('faqCategory')->selectRaw("(SELECT COUNT(*) FROM faqs) AS totalrecs, id, question, answer, order_number, faq_category_id")
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

    // save 
    public static function saveFaq($post)
    {
        try {
            $insertArray = [
                'answer' => $post['answer'],
                'faq_category_id' => $post['category'],
                'order_number' => $post['order_number'],
                'question' => strip_tags($post['question'])
            ];
            $insertArray = filterData($insertArray);

            if (!empty($post['id'])) {
                $insertArray['updated_at'] = Carbon::now();
                if (!Faq::where('id', $post['id'])->update($insertArray)) {
                    throw new Exception("Couldn't update Records", 1);
                }
            } else {
                $insertArray['created_at'] = Carbon::now();
                if (!Faq::insert($insertArray)) {
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
                if (!empty($post['id'])) {
                    $data = Faq::where('id', $post['id'])
                        ->where('status', 'N')->first();
                    if (!$data->delete()) {
                        throw new Exception("Couldn't Delete Data. Please try again", 1);
                    }
                }
            } else {
                $updateArray = [
                    'status' => 'N'
                ];
                if (!empty($post['id'])) {
                    $updateArray['updated_at'] = Carbon::now();
                    if (!Faq::where('id', $post['id'])->update($updateArray)) {
                        throw new Exception("Couldn't Delete Data. Please try again", 1);
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
            if (!Faq::where(['id' => $post['id']])->update($updateArray)) {
                throw new Exception("Couldn't Restore Data. Please try again", 1);
            }
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }
}