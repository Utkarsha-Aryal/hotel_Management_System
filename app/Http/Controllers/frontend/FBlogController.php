<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class FBlogController extends Controller
{
    public function index(){
        $data = Post::all();
        return view("frontend.blog.index",['data'=>$data]);
    }
}
