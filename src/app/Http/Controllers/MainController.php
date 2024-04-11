<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(){
        $image = Image::orderBy('created_at')->get();
        return view('main', [
            'images' => $image
        ]);
    }
}
