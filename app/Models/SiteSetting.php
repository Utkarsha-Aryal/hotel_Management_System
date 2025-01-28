<?php

namespace App\Models;

use App\Models\Common;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SiteSetting extends Model
{

    
    use HasFactory;
    public static function updatedata($post)
    {
        try {

            $updateArray = [
                'name' => $post['name'],
                'email' => strip_tags($post['email']),
                'phone_number' => $post['phone_number'],
                'address' => strip_tags($post['address']),
                'link_facebook' => strip_tags($post['link_facebook']),
                'link_instagram' =>strip_tags( $post['link_instagram']),
                'link_twitter' => strip_tags($post['link_twitter']),
                'link_map' => strip_tags($post['link_map']),
            ];
            $updateArray = filterData($updateArray);
            if (!empty($post['img_logo'])) {
                $fileName = SiteSetting::singleImageUpload($post['img_logo'], 'logo');
                if (!$fileName) {
                    return false;
                }
                $updateArray['img_logo'] = $fileName;
            }

            if (!empty($post['img_favicon'])) {
                $fileName = SiteSetting::singleImageUpload($post['img_favicon'], 'favicon');
                if (!$fileName) {
                    return false;
                }
                $updateArray['img_favicon'] = $fileName;
            }

            $updateArray['updated_at'] = Carbon::now();

            if (!SiteSetting::where('id', 1)->update($updateArray)) {
                throw new Exception("Couldn't Save Records", 1);
            }

            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }


    public static function singleImageUpload($file, $type)
    {
        try {
            $folder = 'setting'; // Relative folder path within storage
            $disk = 'public'; // Define the storage disk
    
            // Ensure the directory exists
            if (!Storage::disk($disk)->exists($folder)) {
                Storage::disk($disk)->makeDirectory($folder, 0775, true);
            }
    
            // Retrieve current data
            $data = SiteSetting::find(1);
    
            // Determine which field and previous file to delete
            $previousFile = null;
            if ($type == 'logo') {
                $previousFile = $data->img_logo;
            } elseif ($type == 'favicon') {
                $previousFile = $data->img_favicon;
            }
    
            // Delete previous file if it exists
            if ($previousFile && Storage::disk($disk)->exists($folder . '/' . $previousFile)) {
                Storage::disk($disk)->delete($folder . '/' . $previousFile);
            }
    
            // Validate the file extension
            $extension = $file->getClientOriginalExtension();
            $allowedExtensions = ['png', 'jpg', 'jpeg'];
            if (!in_array(strtolower($extension), $allowedExtensions)) {
                throw new Exception('Invalid file format. Allowed formats: PNG, JPG, JPEG.');
            }
    
            // Generate a unique name for the new file
            $tempName = Str::random(30) . '-' . time() . '.' . $extension;
    
            // Store the file
            $storeFile = $file->storeAs($folder, $tempName, $disk);
            if (!$storeFile) {
                throw new Exception('Failed to upload the file.');
            }
    
            return $tempName; // Return the new file name
        } catch (Exception $e) {
            throw $e; // Rethrow the exception for higher-level handling
        }
    }

}
