<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class ClientController extends Controller
{
    //
    public function index()
    {
        $title='Home';
        $listSanpham= DB::select('SELECT * FROM `sanpham`');
        $listLoai= DB::select('SELECT * FROM `loaisp`');
        $listSlider= DB::select('SELECT * FROM `slider`');
        $listTin= DB::select('SELECT * FROM `tintuc`');
        return view('client.index',compact('title','listSanpham','listLoai','listSlider','listTin'));
    }
    public function user()
    {
        $title='User';
        $user=DB::select('SELECT * FROM `ctusers` WHERE `iduser`='.Auth::user()->id);
        return view('client.user.user',compact('title','user'));
    }
    public function updateusert(Request $request )
    {
        $request->validate([
            'name'=>'min:2',
            'sdt'=>'numeric|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:9|unique:ctusers,sdt,'.$request->id
        ],
        [
            'sdt.numeric'=>'Số điện thoại là số',
            'sdt.min'=>'Số điện thoại phải là  11 số',
            'sdt.regex'=>'Số điện thoại không đúng định dạng',
            'name.min'=>'Tên trên 2 ký tự',
            'sdt.unique'=>'số điện thoại không được trùng'
        ]);
        if(!DB::select('SELECT * FROM `ctusers` WHERE `iduser`='.Auth::user()->id) )
        {
            DB::update("UPDATE `users` SET `name`='$request->name' WHERE `id`=".Auth::user()->id);
            DB::insert('INSERT INTO `ctusers`(`iduser`, `daichi`, `gioitinh`, `sdt`) VALUES  (?, ?,?,?)',
             [Auth::user()->id, $request->daichi,$request->gioitinh,$request->sdt]);
        }
        else
        {
            DB::update("UPDATE `users` SET `name`='$request->name' WHERE `id`=".Auth::user()->id);
            DB::update("UPDATE `ctusers` SET `daichi`='$request->daichi',`gioitinh`='$request->gioitinh',`sdt`='$request->sdt' WHERE `iduser`=".Auth::user()->id);
        }
        return redirect()->back()->with('success', 'Cập nhật thông tin thành công');

    }
    public function updateusert1(Request $request )
    {
        //
        // dd($request->id);
        $request->validate([
            'name'=>'min:2',
            'sdt'=>'numeric|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:9|unique:ctusers,sdt,'.$request->id
        ],
        [
            'sdt.numeric'=>'Số điện thoại là số',
            'sdt.min'=>'Số điện thoại phải là  11 số',
            'sdt.regex'=>'Số điện thoại không đúng định dạng',
            'name.min'=>'Tên trên 2 ký tự',
            'sdt.unique'=>'số điện thoại không được trùng'
        ]);
        if(!DB::select('SELECT * FROM `ctusers` WHERE `iduser`='.Auth::user()->id) )
        {
            DB::update("UPDATE `users` SET `name`='$request->name' WHERE `id`=".Auth::user()->id);
            DB::insert('INSERT INTO `ctusers`(`iduser`, `daichi`, `sdt`) VALUES  (?, ?,?)',
             [Auth::user()->id,$request->diachi,$request->sdt]);
        }
        else
        {
            DB::update("UPDATE `users` SET `name`='$request->name' WHERE `id`=".Auth::user()->id);
            DB::update("UPDATE `ctusers` SET `daichi`='$request->diachi',`sdt`='$request->sdt' WHERE `iduser`=".Auth::user()->id);
        }
        return redirect()->back()->with('success', 'Cập nhật thông tin thành công');

    }
    public function giohang()
    {
        $title='User-Giohang';
        $listHoadon=DB::select('SELECT * FROM `hoadon` WHERE `idkh`= ? ORDER BY `id` DESC',[Auth::user()->id] );
        return view('client.user.giohang',compact('title','listHoadon'));
    }
    public function updatepassindex()
    {
        $title='User-updatepass';
        return view('client.user.updatepass',compact('title'));
    }
    public function updatepass(Request $request)
    {
        if ( Hash::check($request->password, $request->user()->password)) 
        {
            session()->put('role', 1);
            return redirect()->back();
        }
        else
        {
            return redirect()->back()->with('success', 'Mật khẩu không chính xác');
        }
    }
    public function updatepass1(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ],
        [
        'password.min'=>'mật khẩu phải ít nhất 8 ký tự',
        'password.confirmed'=>'mật khẩu nhập lại không đúng',
        ]);
        session()->forget('role');
        $pass = Hash::make($request->password);
        DB::update("UPDATE `users` SET `password`='$pass' WHERE id=".Auth::user()->id);
        Auth::logout();
            return redirect(route('dangnhap'));
    }
    public function login()
    {
        $title='Đăng nhập';
        return view('client.login',compact('title'));
    }
    public function register()
    {
        $title='Đăng Ký';
        return view('client.register',compact('title'));
    }
    public function phanhoi(Request $request)
    {
        DB::insert('INSERT INTO `phanhoi`(`name`, `email`, `noidung`) VALUES(?, ?,?)',
         [$request->name,$request->email,$request->noidung]);
         return redirect()->back()->with('success', 'Cảm ơn bạn đã gửi phải hồi');
    }
}
