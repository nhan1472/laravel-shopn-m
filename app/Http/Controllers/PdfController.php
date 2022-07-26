<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use DB;
class PdfController extends Controller
{
    //
    public function index($id)
    {
        $data  = DB::select("SELECT * FROM `hoadon` WHERE `id`=?", [$id]);
        $pdf = PDF::loadView('admin.in',compact('data'));
        return $pdf->download('hoadon'.$id.'.pdf');
    }
}
