<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function index(){
        return view('about');
    }

    public function aboutus(){
        $about = AboutUs::where('status','1')->get();
            return view('about',[
            'abouts' =>$about,
        ]);
    }
}
