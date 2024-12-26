<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public static function index()
    {
        return view('frontend.contact');
    }

    public static function save(Request $request)
    {
        $post = $request->all();
        

    }
}
