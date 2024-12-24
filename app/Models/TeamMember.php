<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Common;
use Carbon\Carbon;
use Exception;

class TeamMember extends Model
{


    use HasFactory;
    public static function saveData($post)
    {
        try {
            $dataArray = [
                'name' => $post['name'],
                'order_number' => $post['order_number'],
                'designation' => $post['designation'],
                'email' => $post['email'],
                'phone_number' => $post['phone_number'],
                'short_bio' => $post['short_bio'],
                'experience' => $post['experience'],
                'twitter_url' => $post['twitter_url'],
                'facebook_url' => $post['facebook_url'],
                'instagram_url' => $post['instagram_url'],
            ];
            $dataArray = filterData($dataArray);
            if (!empty($post['photo'])) {
                $fileName = Common::uploadFile('community', $post['photo']);
                if (!$fileName) {
                    return false;
                }
                $dataArray['photo'] = $fileName;
            }

            if (!empty($post['id'])) {
                $dataArray['updated_at'] = Carbon::now();
                if (!TeamMember::where('id', $post['id'])->update($dataArray)) {
                    throw new Exception("Couldn't update Records", 1);
                }
            } else {
                $dataArray['created_at'] = Carbon::now();
                if (!TeamMember::insert($dataArray)) {
                    throw new Exception("Couldn't Save Records", 1);
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
            $orderby = " order_number " . $sorting . "";
            if (!empty($get['order'][0]['column']) && $get['order'][0]['column'] == 2) {
                $orderby = " order_number " . $sorting . "";
            }
            foreach ($get['columns'] as $key => $value) {
                $get['columns'][$key]['search']['value'] = trim(strtolower(htmlspecialchars($value['search']['value'], ENT_QUOTES)));
            }
            $cond = "status = 'Y' ";
            if (!empty($post['type']) && $post['type'] === 'trashed') {
                $cond = " status = 'N'";
            }
            if ($get['columns'][1]['search']['value'])
                $cond .= " and lower(name) like '%" . $get['columns'][1]['search']['value'] . "%'";
            // if ($get['columns'][3]['search']['value'])
            //     $cond .= " and lower(designation) like '%" . $get['columns'][3]['search']['value'] . "%'";
            $limit = 15;
            $offset = 0;
            if (!empty($get['length']) && $get['length']) {
                $limit = $get['length'];
                $offset = $get['start'];
            }
            $query = TeamMember::selectRaw("(SELECT COUNT(*) FROM team_members) AS totalrecs, id, name, photo, order_number,email,phone_number,experience,short_bio,designation, facebook_url, instagram_url, twitter_url")
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

    
    public static function restoreData($post)
    {
        try {
            $updateArray = [
                'status' => 'Y',
                'updated_at' => Carbon::now(),
            ];
            if (!TeamMember::where(['id' => $post['id']])->update($updateArray)) {
                throw new Exception("Couldn't Restore Data. Please try again", 1);
            }
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
