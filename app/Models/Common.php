<?php

namespace App\Models;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Common extends Model
{
    
    public static function uploadFile($location, $file)
    {
        try {

            $extension = $file->getClientOriginalExtension();
           
            if (!in_array($extension, ['png', 'jpg', 'jpeg']))
                throw new Exception('File format is not matched, upload in list (PNG/JPG/JPEG', 1);

            $tempName = Str::random(30) . '-' . time() . '.' . $extension;
            $storeFile = $file->storeAs($location, $tempName, 'public');

            if (empty($storeFile))
                return false;

            return $tempName;
        } catch (Exception $e) {
            throw $e;
        }
    }


    public static function deleteDataFileDoesnotExists($post,$class)
    {
        try {
            if($post['type']==='trashed'){
                $postInstance = $class->findorFail($post['id']);
                if(!$postInstance->delete()){
                    throw new Exception("Couldn't Delete Data. Please try again",1);
                }
            }else{
                if(!$class::where(['id'=>$post['id']])->update(['status'=>'N','updated_at'=>Carbon::now()])){
                    throw new Exception("Couldn't Delete Data. Please try again",1);
                }
            }
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }


    public static function deleteSingleData($post,$class,$filepath)
    {
        try {
            if($post['type']==='trashed'){
                $postInstance = $class->findOrFail($post['id']);

                if(!$postInstance->delete()){
                    throw new Exception("Couldn't Delete Data. Please try again",1);
                }

                if($postInstance->feature_image){
                    $decodeFeatureImages = json_decode($postInstance->feature_image,true);
                    foreach($decodeFeatureImages as $image){
                        if(file_exists($filepath. '/'.$image)){
                            unlink($filepath . '/' . $image);
                        }
                    }
                }

                if (!empty($postInstance->image)) { // no image case
                    if (file_exists($filepath . '/' . $postInstance->image)) {
                        unlink($filepath . '/' . $postInstance->image);
                    } else {
                        throw new Exception("Couldn't Delete Data. Please try again", 1);
                    }
                }

                //apply condition for all delete option like this way
                if (!empty($postInstance->photo)) { // no Photo case 
                    if (file_exists($filepath . '/' . $postInstance->photo)) {
                        unlink($filepath . '/' . $postInstance->photo);
                    } else {
                        throw new Exception("Couldn't Delete Data. Please try again", 1);
                    }
                }

                if (!empty($postInstance->file)) { // no file case 
                    if (file_exists($filepath . '/' . $postInstance->file)) {
                        unlink($filepath . '/' . $postInstance->file);
                    } else {
                        throw new Exception("Couldn't Delete Data. Please try again", 1);
                    }
                }
                
            } else {
                if (!$class::where(['id' => $post['id']])->update(['status' => 'N', 'updated_at' => Carbon::now()])) {
                    throw new Exception("Couldn't Delete Data. Please try again", 1);
                }
            }
            return true;
        } catch (Exception$e) {
            throw $e;
        }
    }

    public static function uploadPDF($location, $file)
    {
        try {
            $extension = $file->getClientOriginalExtension();
            if (!in_array($extension, ['pdf', 'doc'])) {
                throw new Exception('File format is not matched, upload in list (PDF/DOC', 1);
            }
            $tempName = Str::random(30) . '-' . time() . '.' . $extension;
            $storeFile = $file->storeAs($location, $tempName, 'public');
            if (empty($storeFile)) {
                return false;
            }
            return $tempName;
        } catch (Exception $e) {
            throw $e;
        }
    }

    // public static function filterData($post)
    // {
    //     foreach ($post as $key=>$data)
    //     {
    //         $val = [];
    //         if (!empty($data)) {
    //             if (is_array($data)) {
    //                 $var = '';
    //                 foreach ($data as $rkey => $rval) {
    //                     $var = stripslashes($rval);
    //                     $var = strip_tags($var);
    //                     $var = htmlspecialchars($var);
    //                     $var = html_entity_decode(html_entity_decode($var));
    //                     $val[$rkey] = $var;
    //                 }
    //             } else {
    //                 $val = trim($data);
    //                 $val = stripslashes($val);
    //                 $val = strip_tags($val);
    //                 $val = htmlspecialchars($val);
    //                 $val = html_entity_decode(html_entity_decode($val));
    //             }
    //         } else {
    //             $val = NULL;
    //         }
    //         $post[$key] = $val;
    //     }
    //     return $post;
    // }

}
