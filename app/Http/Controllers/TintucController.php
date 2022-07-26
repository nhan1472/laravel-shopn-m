<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class TintucController extends Controller
{
    //
    public function index()
    {
        $title='Tin Tức';
        $listTin=DB::select('SELECT * FROM `tintuc`');
        $listDmtin=DB::select('SELECT * FROM `loaitt`');
        $listSpham=DB::select('SELECT * FROM `sanpham` LiMIT 5');
        return view('client.tintuc',compact('title','listTin','listDmtin','listSpham'));
    }
    public function tintucdetail($id)
    {
        $listTin=DB::select('SELECT * FROM `tintuc` WHERE `id`='.$id);
        DB::update("UPDATE `tintuc` SET `luotxem`=? WHERE `id`= ?",[$listTin[0]->luotxem+1,$id]);
        return view('client.tintucdetail',compact('listTin'));
    }
    public function indexadmin()
    {
        $title='Tin Tức';
        $listTin=DB::select('SELECT * FROM `tintuc`');
        $listDmtin=DB::select('SELECT * FROM `loaitt`');
        return view('admin.tintuc',compact('title','listTin','listDmtin'));
    }
    public function add(Request $request)
    {
        $startTime = date("Y-m-d H:i:s");
        $request->validate([
            'img'=>'image|mimes:jpg,png,jpeg,gif,svg|max:1024',
        ],
        [
            'img.mimes'=>'Ảnh không đúng định dạng',
            'img.max'=>'Ảnh có kích cở quá lớn',
        ]);
         $hinh=$request->file('img');
         $stroePath=$hinh->move('img',time()."-".$hinh->getClientOriginalName());
        DB::insert('INSERT INTO `tintuc`(`title`, `tomtat`,`img`, `noidung`, `idloai`, `ngaydang`) 
        VALUES (?, ?,?,?,?,?)', [$request->tieude,$request->tomtat,str_replace("\\", "/", $stroePath),$request->noidung,$request->loaitt,$startTime]);
        return redirect()->back()->with('success', 'Thêm tin tức thành công');
    }
    public function xoa(Request $request)
    {   
        DB::delete('DELETE FROM `tintuc` WHERE id = ?', [$request->id]);
        return redirect()->back()->with('success', 'Xóa tin tức thành công');
    }
    public function xem(Request $request)
    {
        $listDmtin=DB::select('SELECT * FROM `loaitt`');
        $tintuc=DB::select('SELECT * FROM `tintuc` WHERE id=? ', [$request->id]);
        return view('admin.tintucxem',compact('tintuc','listDmtin'));
    }
    public function update(Request $request)
    {

        $hinh=$request->file('img');
        if(!$request->file('img')==null)
        {
           $stroePath=$hinh->move('img',time()."-".$hinh->getClientOriginalName());
           DB::update('UPDATE `tintuc` SET `img`=?,`title`=? ,`tomtat`=?,`noidung`=?,`idloai`=? WHERE `id`=?',
            [str_replace("\\", "/", $stroePath),$request->tieude,$request->tomtat,$request->noidung,$request->loaitt,$request->id]);
        }
        else
        {
            DB::update('UPDATE `tintuc` SET `title`=? ,`tomtat`=?,`noidung`=?,`idloai`=? WHERE `id`=?',
        [$request->tieude,$request->tomtat,$request->noidung,$request->loaitt,$request->id]);
        }
        return redirect()->back()->with('success', 'Cập nhật tin tức thành công');
    }
    public function danhmuc()
    {
        $title='Danh mục Tin tức';
        $listDmtin=DB::select('SELECT * FROM `loaitt`');
        return view('admin.danhmuctt',compact('title','listDmtin'));
    }
    public function adddanhmuc(Request $request)
    {
        DB::insert('INSERT INTO `loaitt`(`name`) VALUES (?)', [$request->name]);
        return redirect()->back()->with('success', 'Thêm danh mục thành công');
    }
    public function xoadanhmuc(Request $request)
    {
        DB::delete('DELETE FROM `loaitt` WHERE id=?', [$request->id]);
        return redirect()->back()->with('success', 'Xóa danh mục thành công');
    }
    public function danhmucedit(Request $request)
    {
        DB::update("UPDATE `loaitt` SET `name`='$request->name' WHERE `id`=$request->id");
        return redirect()->back()->with('success', 'cập nhật danh mục thành công');
    }
}
