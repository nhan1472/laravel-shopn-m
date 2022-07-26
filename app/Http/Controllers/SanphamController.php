<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class SanphamController extends Controller
{
    
    public function index()
    {
        $title='Sanpham';
        $listSanpham= DB::select('SELECT * FROM `sanpham`');
        $listLoai= DB::select('SELECT * FROM `loaisp`');
        $listSize= DB::select('SELECT   * FROM `size` ');
        $sizect=DB::select('SELECT * FROM `sizect` ');
        return view('client.sanpham',compact('title','listSanpham','listLoai','listSize','sizect'));
    }
    public function indexadmin()
    {
        $title='Sản phâm';
        $listSanpham= DB::select('SELECT * FROM `sanpham`');
        $listLoai= DB::select('SELECT * FROM `loaisp`');
        $listSize= DB::select('SELECT   * FROM `size` ');
        $listsizect=DB::select('SELECT * FROM `sizect` ');
        return view('admin.sanpham',compact('title','listSanpham','listLoai','listSize','listsizect'));
    }
    public function indexedit(Request $request)
    {
        $title='Sản phâm';
        $listSanpham= DB::select('SELECT * FROM `sanpham` WHERE `id`=?', [$request->id]);
        $listDm= DB::select('SELECT * FROM `loaisp` ');
        $listS= DB::select('SELECT * FROM `size` ');
        return view('admin.sanphamedit',compact('title','listSanpham','listDm','listS'));
    }
    public function remove(Request $request)
    {
        DB::delete('DELETE FROM `sanpham` WHERE `id`=?', [$request->id]);
        return redirect()->back()->with('success', 'Xóa Sản phẩm thành công thành công');
    }
    public function add(Request $request)
    {
        $request->validate([
        'name'=>'required',
        'noidung'=>'required',
        'gia'=>'required',
        'danhmuc'=>'required',
        'size'=>'required',
        'img'=>'required|image|mimes:jpg,png,jpeg,gif,svg|max:1024',
            ],
             [
        'img.mimes'=>'Ảnh không đúng định dạng',
        'img.required'=>'Chưa chọn ảnh',
        'img.max'=>'Ảnh có kích cở quá lớn',
        'name.required'=>'Tên không được bỏ trống',
        'noidung.required'=>'Nội dung không được bỏ trống',
        'gia.required'=>'Gía không được bỏ trống',
        'danhmuc.required'=>'danh mục không được bỏ trống',
        'size.required'=>'size không được bỏ trống',
     ]);
     $hinh=$request->file('img');
     $stroePath=$hinh->move('img',time()."-".$hinh->getClientOriginalName());

        DB::insert('INSERT INTO `sanpham`(`ten`,`noidung`, `img`, `gia`, `maloai`) VALUES (?,?, ?,?,?)',
         [$request->name,$request->noidung,str_replace("\\", "/", $stroePath),$request->gia,$request->danhmuc]);
         $id=DB::select('SELECT `id` FROM `sanpham` ORDER BY `id` DESC LIMIT 1');
         DB::insert('INSERT INTO `sizect`( `idsp`, `idsize`) VALUES (?, ?)', [$id[0]->id, $request->size]);
        return redirect()->back()->with('success', 'Thêm sản Sản phẩm thành công thành công');
    }
    public function indexupdate(Request $request)
    {
        // dd($request);
    //     $request->validate([
    //     'name'=>'required',
    //     'noidung'=>'required',
    //     'gia'=>'required',
    //     'danhmuc'=>'required',
    //     'size'=>'required',
    //     'img'=>'image|mimes:jpg,png,jpeg,gif,svg|max:1024',
    //         ],
    //          [
    //     'img.mimes'=>'Ảnh không đúng định dạng',
    //     'img.required'=>'Chưa chọn ảnh',
    //     'img.max'=>'Ảnh có kích cở quá lớn',
    //     'name.required'=>'Tên không được bỏ trống',
    //     'noidung.required'=>'Nội dung không được bỏ trống',
    //     'gia.required'=>'Gía không được bỏ trống',
    //     'danhmuc.required'=>'danh mục không được bỏ trống',
    //     'size.required'=>'size không được bỏ trống',
    //  ]);
     if($request->file('img')!=null){
        $hinh=$request->file('img');
     $stroePath=$hinh->move('img',time()."-".$hinh->getClientOriginalName());
     $stroePath=str_replace("\\", "/", $stroePath);
 
        DB::update("UPDATE `sanpham` SET `ten`='$request->name',`noidung`='$request->noidung',`img`='$stroePath',`gia`='$request->gia',`maloai`='$request->danhmuc' WHERE `id` = ?", [$request->id]);
        //  $id=DB::select('SELECT `id` FROM `sanpham` ORDER BY `id` DESC LIMIT 1');
        //  DB::insert('INSERT INTO `sizect`( `idsp`, `idsize`) VALUES (?, ?)', [$id[0]->id, $request->size]);
     }
     else
     {
        DB::update("UPDATE `sanpham` SET `ten`='$request->name',`noidung`='$request->noidung',`gia`='$request->gia',`maloai`='$request->danhmuc' WHERE `id` = ?", [$request->id]);
     }
     return redirect(route('admin.sanpham.index'))->with('success', 'cập nhật sản phẩm thành công');
    }
    public function detail($id)
    {
        $sanpham = DB::select('SELECT * FROM `sanpham` WHERE `id`=?', [$id]);
        DB::update("UPDATE `sanpham` SET `luotxem`=? WHERE  `id`= ?", [$sanpham[0]->luotxem+1,$sanpham[0]->id]);
        $sizect = DB::select('SELECT * FROM `sizect` WHERE `idsp`=?', [$id]);
        // dd($sanpham[0]->noidung);
        return view('client.sanphamdetail',compact('sanpham','sizect'));
    }
}