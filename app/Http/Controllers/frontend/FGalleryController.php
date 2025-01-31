<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Models\GalleryImage;

class FGalleryController extends Controller
{
    public function index(){
        $data = Gallery::select('name','image','slug')->where('status','y')->get();

        return view('frontend.gallery.index',['data'=>$data]);
    }

    public function show($slug)
    {
        $galleries = Gallery::with('images')
        ->where('slug', $slug)
        ->where('status', 'Y')
        ->orderBy('id', 'desc')
        ->first();
        $galleryId = $galleries->id;

        $images = GalleryImage::where('gallery_id', $galleryId)
        ->where('status', 'Y')
        ->orderBy('id', 'desc')
        ->get();
        $data = [
            'images' => $images,
            'galleries'=> $galleries
        ];



        return view("frontend.gallery.show",$data);

    }
    
}
