<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoomAmenitiesController extends Controller
{
    public function index(){
        return view('backend.room.room-collection.main');
    }

    public function amne(){
        return view('backend.room.room-collection.amne');
    }
    public function loadTab($tab)
    {
        try {
            // Validate tab name to prevent directory traversal
            $allowedTabs = ['index', 'amne']; // Add other tab names here
            if (!in_array($tab, $allowedTabs)) {
                abort(404, 'Tab not found');
            }

            if ($tab == 'index') {
                // Redirect to the 'room' route
                return redirect()->route('admin.room');
            }else if($tab == 'amne'){
                return redirect()->route('admin.main.amne');
            }

            
        } catch (\Exception $e) {
            dd($e);
            return response()->json(['message' => 'Error loading tab'], 500);
        }
    }
}
