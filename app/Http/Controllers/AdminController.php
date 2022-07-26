<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Mail;

class AdminController extends Controller
{
    //
    public function index()
    {
        $title='Home';
        $user=DB::select('SELECT * FROM `ctusers` WHERE `iduser`='.Auth::user()->id);
        return view('admin.index',compact('title','user'));
    }
    public function resetpass()
    {
        $title='reset Pass';

        return view('admin.reset',compact('title'));

    }
    public function resetpass1(Request $request)
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
    public function resetpass2(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ],
        [
        'password.min'=>'mật khẩu phải ít nhất 8 ký tự',
        'password.confirmed'=>'mật khẩu nhập lại không đúng',
        ]);
        $pass = Hash::make($request->password);
        session()->forget('role');
        DB::update("UPDATE `users` SET `password`='$pass' WHERE id=".Auth::user()->id);
        Auth::logout();
        return redirect(route('dangnhap'));
    }
    public function updateadmin(Request $request)
    {
        $request->validate([
            'name'=>'min:2',
            'sdt'=>'numeric|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:9 |unique:ctusers,sdt,'.$request->id
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
    public function slider()
    {
        $title='Slider';
        $listSlider = DB::select('SELECT * FROM `slider`');
        return view('admin.slider',compact('title','listSlider'));
    }
    public function slideradd(Request $request)
    {
        $request->validate([
            'img'=>'image|mimes:jpg,png,jpeg,gif,svg|max:1024',
        ],
        [
            'img.mimes'=>'Ảnh không đúng định dạng',
            'img.max'=>'Ảnh có kích cở quá lớn',
         ]);
         $hinh=$request->file('img');
         $stroePath=$hinh->move('img',time()."-".$hinh->getClientOriginalName());
        //  dd(str_replace("\\", "/", $stroePath));
         DB::insert("INSERT INTO `slider`(`img`, `content`) VALUES (?,?)", 
        [str_replace("\\", "/", $stroePath),$request->content]);
        return redirect()->back()->with('success', 'Thêm sản phẩm thành công');
    }
    public function slideremove(Request $request)
    {
        DB::delete('DELETE FROM `slider` WHERE `id`=?', [$request->id]);
        return redirect()->back()->with('success', 'Xóa sản phẩm thành công');
    }
    public function sliderupdate(Request $request)
    {
        $request->validate([
            'img'=>'image|mimes:jpg,png,jpeg,gif,svg|max:1024',
        ],
        [
            'img.mimes'=>'Ảnh không đúng định dạng',
            'img.max'=>'Ảnh có kích cở quá lớn',
         ]);
         $hinh=$request->file('img');
         if(!$request->file('img')==null)
         {
            $stroePath=$hinh->move('img',time()."-".$hinh->getClientOriginalName());
            DB::update('UPDATE `slider` SET `img`=?,`content`=? WHERE `id`=?',
             [str_replace("\\", "/", $stroePath),$request->content,$request->id]);
         }
         else
         {
            DB::update('UPDATE `slider` SET `content`=? WHERE `id`=?',
            [$request->content,$request->id]);
         }
         return redirect()->back()->with('success', 'Cập nhật slider thành công');
    }
    public function footer()
    {
        $title='Footer';
        return view('admin.footer',compact('title'));
    }
    public function menu()
    {
        $title='Header';
        $slogan=DB::select('SELECT * FROM `slogan`');
        return view('admin.menu',compact('title','slogan'));
    }
    public function menuupdate(Request $request) 
    {
        DB::update("UPDATE `slogan` SET `text`='$request->text' WHERE`id`=".$request->id);
        return redirect()->back()->with('success', 'cập nhật slogan thành công');
    }
    public function danhmuc()
    {
        $title='Danh mục';
        $listDanhmuc=DB::select('SELECT * FROM `loaisp` ');
        return view('admin.danhmuc',compact('title','listDanhmuc'));
    }
    public function size()
    {
        $title='Size';
        $listSize=DB::select('SELECT * FROM `size` ');
        return view('admin.size',compact('title','listSize'));
    }
    public function sizeadd(Request $request)
    {
        $request->validate([
            'size'=>'|unique:size,size'
        ]
    ,[
        'size.unique'=>'Size đã tồn tại '
    ]);
        DB::insert('INSERT INTO `size`(`size`) VALUES (?)', [$request->size]);
        return redirect()->back()->with('success', 'Thêm Size thành công');
    }
    public function danhmucadd(Request $request)
    {
        $request->validate([
            'name'=>'|unique:loaisp,name'
        ]
    ,[
        'name.unique'=>'Danh mục đã tồn tại '
    ]);
        DB::insert('INSERT INTO `loaisp`(`name`) VALUES (?)', [$request->name]);
        return redirect()->back()->with('success', 'Thêm danh mục thành công');
    }
    public function danhmucremove(Request $request)
    {
        DB::delete('DELETE FROM `loaisp` WHERE id=?', [$request->id]);
         return redirect()->back()->with('success', 'Xóa danh mục thành công');
    }
    public function danhmucedit(Request $request)
    {
        DB::update("UPDATE `loaisp` SET `name`='$request->name' WHERE `id`=$request->id");
         return redirect()->back()->with('success', 'Thay đỗi danh mục thành công');
    }
    public function sizeedit(Request $request)
    {
        DB::update("UPDATE `size` SET `size`='$request->name' WHERE `id`=$request->id");
         return redirect()->back()->with('success', 'Thay đỗi danh mục thành công');
    }
    public function sizeremove(Request $request)
    {   
        DB::delete('DELETE FROM `size` WHERE id=?', [$request->id]);
         return redirect()->back()->with('success', 'Xóa danh mục thành công');
    }
    public function sizeremovesp(Request $request)
    {  
        // dd($request);
        $sl= DB::select('SELECT COUNT(id)as sl FROM `sizect` WHERE `idsp`=?',[$request->idsp]);
        if( $sl[0]->sl==1)
        {
            return redirect()->back()->with('success1', 'sản phẩm chỉ có 1 size duy nhất không thể xóa');
        }
        else
        {
            DB::delete('DELETE FROM `sizect` WHERE idsp=? AND idsize=?', [$request->idsp,$request->idsize]);
            return redirect()->back()->with('success', 'Xóa Size thành công');
        }

    }
    public function sizeaddct(Request $request)
    {
        DB::insert('INSERT INTO `sizect`( `idsp`, `idsize`) VALUES (?, ?)', [$request->idsp, $request->idsize]);
        return redirect()->back()->with('success', 'Thêm Sizect thành công');
    }
    public function sale()
    {
        $title='Sale';
        $listSanpham=DB::select('SELECT * FROM `sanpham` ');
        return view('admin.sale',compact('title','listSanpham'));
    }
    public function hoadon()
    {
        $title='Hóa đơn';
        $listhoadon=DB::select('SELECT * FROM `hoadon` ORDER BY `id` DESC');
        return view('admin.hoadon',compact('title','listhoadon'));
    }
    public function saleadd(Request $request)
    {
        
        $request->validate([
            'giamgia'=>'|min:0|max:91'
        ],[
            'giamgia.min'=>'Giam gia không được nhỏ hơn 0',
            'giamgia.max'=>'Giam gia không được lơn hơn 90',
        ]);
        DB::update("UPDATE `sanpham` SET `giamgia`='$request->giamgia' WHERE `id`=?", [$request->id]);
        return redirect()->back()->with('success', 'Cập sale thành công');
    }
    public function duyet(Request $request)
    {
        if(Auth::user()->role==1)
        {
            DB::update("UPDATE `hoadon` SET `tinhtrang`=1 ,`idnv`='$request->idnv' WHERE `id`=? ", [$request->id]);
        }
         else
    
         {
        
            DB::update("UPDATE `hoadon` SET `tinhtrang`=1 ,`idnv`='$request->idnv' WHERE `id`=? ", [ $request->id]);
         }
        return redirect()->back()->with('success', 'Duyêt hóa đơn thành công thành công');
    }
    public function giao(Request $request)
    {
        DB::update('UPDATE `hoadon` SET `tinhtrang`=2 WHERE `id`=?', [ $request->id]);
        return redirect()->back()->with('success', 'Duyêt hóa đơn thành công thành công');
    }
    public function user()
    {
        $title='Khách hàng';  
        $listUser=DB::select('SELECT * FROM `users` WHERE `role`=?', [0]);
        return view('admin.khachhang',compact('title','listUser'));
    }
    public function nhanvien()
    {
        $title='Nhân viên';  
        $listUser=DB::select('SELECT * FROM `users` WHERE `role`=?', [2]);
        return view('admin.nhanvien',compact('title','listUser'));
    }
    public function huy(Request $request)
    {
        DB::update("UPDATE `hoadon` SET `tinhtrang`=3,`idnv`='$request->idnv',`lydo`='$request->lydo' WHERE `id`=?", [ $request->id]);
        return redirect()->back()->with('success', 'hủy hóa đơn thành công thành công');
    }
    public function phanhoi()
    {
        $title='Phản hồi';  
        $listPhoi=DB::select('SELECT * FROM `phanhoi`');
        return view('admin.phanhoi',compact('title','listPhoi'));
    }
    public function phanhoitraloi(Request $request)
    {
        $noidung = $request->noidung;
        $data = DB::select('SELECT * FROM `phanhoi` WHERE `id`=?',[$request->id]);
        Mail::send('admin.emailphanhoi',compact('data','noidung'), function ($message) use($data) {
            $message->subject('Phản hồi từ shop N$M');
            $message->from('shopn$m@gmail.com', 'ShopN$M');
            $message->to($data[0]->email,$data[0]->name);
        });
        DB::update('UPDATE `phanhoi` SET   `tinhtrang`=1  WHERE `id`=?',[$request->id]);
        return redirect()->back()->with('success', 'Trả lời phản hồi thành công');
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ],
    [
        'name.string'=>'Tên là kiểu chuổi',
        'password.string'=>'password là kiểu chuổi',
        'email.unique'=>'Email đã tồn tại',
        'password.min'=>'Mật khẩu không được nhỏ hơn 8 ký tự',
        'password.confirmed'=>'Mật khẩu nhập lại không chính sát',
    ]);
    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->job,
        'password' => Hash::make($request->password),
    ]);
    return redirect()->back()->with('success', 'Thêm nhân viên thành công');
    }
    public function binhluan(Request $request)
    {
        $binhluan = DB::select('SELECT * FROM `binhluan` WHERE `idkh`=? AND idsp=?', [Auth::user()->id,$request->idsp]);
        if($binhluan)
        {
            DB::update("UPDATE `binhluan` SET `noidung`='$request->noidung',`diem`='$request->star' WHERE `id`=?",[$binhluan[0]->id]);
        }
        else
        {
            DB::insert('INSERT INTO `binhluan`(`idkh`, `idsp`, `noidung`,`diem`) VALUES (?,?, ?,?)',
            [$request->idkh,$request->idsp,$request->noidung,$request->star]);
        }
        return redirect()->back();
    }
    public function footerxoa(Request $request)
    {
        DB::delete('DELETE FROM `lienhe` WHERE `id`=?', [$request->id]);
        return redirect()->back()->with('success', 'Xóa nội dung thành công');;
    }
    public function footerxoack(Request $request)
    {
        DB::delete('DELETE FROM `camket` WHERE `id`=?', [$request->id]);
        return redirect()->back()->with('success', 'Xóa nội dung thành công');;
    }
    public function footersua(Request $request)
    {
        DB::update("UPDATE `lienhe` SET `text`=? WHERE `id`=?",[$request->noidung,$request->id]);
        return redirect()->back()->with('success', 'Cập nhật nội dung thành công');;
    }
    public function footersuack(Request $request)
    {
        $hinh=$request->file('img');
        if(!$request->file('img')==null)
        {
           $stroePath=$hinh->move('img',time()."-".$hinh->getClientOriginalName());
           DB::update('UPDATE `camket` SET `img`=?,`text`=? WHERE `id`=?',
            [str_replace("\\", "/", $stroePath),$request->noidung,$request->id]);
        }
        else
        {
           DB::update('UPDATE `camket` SET `text`=? WHERE `id`=?',
           [$request->noidung,$request->id]);
        }
        return redirect()->back()->with('success', 'Cập nhật slider thành công');
    }
    public function footerthem(Request $request)
    {
        DB::insert('INSERT INTO `lienhe`(`text`) VALUES (?)', [$request->noidung]);
        return redirect()->back()->with('success', 'Thêm nội dung thành công');;
    }
    public function footerthemck(Request $request)
    {
        $request->validate([
            'img'=>'image|mimes:jpg,png,jpeg,gif,svg|max:1024',
        ],
        [
            'img.mimes'=>'Ảnh không đúng định dạng',
            'img.max'=>'Ảnh có kích cở quá lớn',
         ]);
         $hinh=$request->file('img');
         $stroePath=$hinh->move('img',time()."-".$hinh->getClientOriginalName());
        DB::insert('INSERT INTO `camket`(`text`,`img`) VALUES (?,?)', [$request->noidung,str_replace("\\", "/", $stroePath)]);
        return redirect()->back()->with('success', 'Thêm nội dung thành công');;
    }
    public function thongke()
    {
        $title='Thông kê';
        return view('admin.thongke',compact('title'));
    }
}