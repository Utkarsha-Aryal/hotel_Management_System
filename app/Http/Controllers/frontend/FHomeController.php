<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FHomeController extends Controller
{
    public function index()
    {
        return view('frontend.home.home');
    }
}
