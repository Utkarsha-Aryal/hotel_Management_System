<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Exception;

class FaqCategory extends Model
{
    use HasFactory;
    public function faq()
    {
        return $this->hasMany(Faq::class)->where('status', 'Y');
    }

    // list
    public static function getlist($post)
    {
        try {
            $get = $post;
            $sorting = !empty($get['order'][0]['dir']) ? $get['order'][0]['dir'] : 'asc';
            $orderby = " order_number " . $sorting . "";
            if (!empty($get['order'][0]['column']) && $get['order'][0]['column'] == 3) {
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
                $cond .= " and lower(name) like '%" . $get['columns'][1]['search']['value'] . "%'";
            $limit = 15;
            $offset = 0;
            if (!empty($get["length"]) && $get["length"]) {
                $limit = $get['length'];
                $offset = $get["start"];
            }
            $query = FaqCategory::selectRaw("(SELECT COUNT(*) FROM faq_categories) AS totalrecs, id, name, order_number")
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
                'name' => strip_tags($post['name']),
                'order_number' => $post['order_number']
            ];
            $insertArray = filterData($insertArray);
            if (!empty($post['id'])) {
                $insertArray['updated_at'] = Carbon::now();
                if (!FaqCategory::where('id', $post['id'])->update($insertArray)) {
                    throw new Exception("Couldn't update Records", 1);
                }
            } else {
                $insertArray['created_at'] = Carbon::now();
                if (!FaqCategory::insert($insertArray)) {
                    throw new Exception("Couldn't Save Records", 1);
                }
            }
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

    // delete
    public static function deleteFaqRelation($post, $class)
    {
        try {
            if ($post['type'] === "trashed") {
                if ($post['id']) {
                    $faqId = $post['id'];
                    $checkFaq = Faq::where('faq_category_id', $faqId)->first();
                    if (!empty($checkFaq)) {
                        throw new Exception("This Category is associated with faqs.", 1);
                    }
                }
                $postInstance = $class->findOrFail($post['id']);
                if (!$postInstance->delete()) {
                    throw new Exception("Couldn't Delete Data. Please try again", 1);
                }
            } else {
                if (!$class::where(['id' => $post['id']])->update(['status' => 'N', 'updated_at' => Carbon::now()])) {
                    throw new Exception("Couldn't Delete Datad. Please try again", 1);
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
            if (!FaqCategory::where(['id' => $post['id']])->update($updateArray)) {
                throw new Exception("Couldn't Restore Data. Please try again", 1);
            }
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
