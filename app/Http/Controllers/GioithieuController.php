<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class GioithieuController extends Controller
{
    //
    public function index()
    {
        $title='Giới thiệu';
        $cotmoc=DB::select('SELECT * FROM `cotmoc`');
        return view('client.gioithieu',compact('title','cotmoc'));
    }
}
