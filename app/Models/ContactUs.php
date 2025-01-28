<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Exception;
use Carbon\Carbon;

class ContactUs extends Model
{
    public static function saveData($post)
    {
        try {
            $insertArray = [
                'fullname' => $post['name'],
                'phone' => $post['phone_number'],
                'email'=> $post['email'],
                'message'=> $post['message'],
            ];
         $insertArray['created_at'] = Carbon::now();
         if(!ContactUs::insert($insertArray)){
            throw new Exception("Couldn't Save Records",1);
        }
        return true;

        } catch(Exception $e){
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
            if ($get['columns'][1]['search']['value'])
                $cond .= " and lower(fullname) like '%" . $get['columns'][1]['search']['value'] . "%'";

            if ($get['columns'][2]['search']['value'])
                $cond .= " and lower(phone) like '%" . $get['columns'][2]['search']['value'] . "%'";
            if ($get['columns'][3]['search']['value'])
                $cond .= " and lower(email) like '%" . $get['columns'][3]['search']['value'] . "%'";

            $limit = 15;
            $offset = 0;
            if (!empty($get["length"]) && $get["length"]) {
                $limit = $get['length'];
                $offset = $get["start"];
            }

            $query = ContactUs::selectRaw("(SELECT COUNT(*) FROM contact_us WHERE status = 'Y') AS totalrecs, fullname, id as id, phone, email, message")
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
