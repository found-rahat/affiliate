<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;

class OrderInfoController extends Controller
{
    use HasFactory;

    public function index(){
        return view('orderinfo');
    }

    public function orderlist(){
        
        return view('orderlist');
    }
}
