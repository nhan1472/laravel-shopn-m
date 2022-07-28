<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Mail;
class CartController extends Controller
{
    //
    public function index()
    {
        $title = 'Cart';
        return view('client.giohang',compact('title'));
    }
    public function showdathang()
    {
        $title = 'Dathang-Cart';
        return view('client.dathang',compact('title'));
    }
    public function addCart(Request $request)

    {
        $product = DB::select('SELECT * FROM `sanpham` WHERE `id`='.$request->id);
        $size = DB::select('SELECT * FROM `size` WHERE `id`='.$request->size);
        $cart = session()->get('cart', []);
        if(isset($cart[$request->id])) {
                if($cart[$request->id]['size']==$size[0]->size)
                {
                    $cart[$request->id]['sl']+= $request->sl;
                }
                else {
                    if(isset($cart[$request->id+100]))
                    {
                        $cart[$request->id+100]['sl']+= $request->sl;
                    }
                    else
                    {
                        $cart[$request->id+100] = [
                            "id"=>$product[0]->id,
                            "ten" => $product[0]->ten,
            
                            "sl" => $request->sl,
                            "size" => $size[0]->size,
            
                            "img" => $product[0]->img,
            
                            "gia" => $product[0]->gia,
                            "giamgia" => $product[0]->giamgia,
                            "maloai" => $product[0]->maloai,
            
                        ];
                    }
                }
        } else {

            $cart[$request->id] = [
                "id"=>$product[0]->id,
                "ten" => $product[0]->ten,

                "sl" => $request->sl,
                "size" => $size[0]->size,

                "img" => $product[0]->img,

                "gia" => $product[0]->gia,
                "giamgia" => $product[0]->giamgia,
                "maloai" => $product[0]->maloai,

            ];

        }
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Thêm sản phẩm vào giỏ thành công');
    }
    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            return redirect()->back()->with('success', 'Xóa sản phẩm thành công');
        }
    }
    public function tangSl(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                if($cart[$request->id]['sl']++ >= 25)
                {
                    return redirect()->back()->with('success', 'số lượng sản phẩm 25 là lớn nhất');
                }
                session()->put('cart', $cart);
            }
            return redirect()->back()->with('success', 'Tăng số lượng thành công');
        }
    }
    public function giamSl(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                $cart[$request->id]['sl']--;
                session()->put('cart', $cart);
            }
            return redirect()->back()->with('success', 'Tăng số lượng thành công');
        }
    }
    public function addhoadon(Request $request)
    {
        $cart = session()->get('cart');
        $total=0;
        $sl=0;
        foreach ($cart as $key => $value) {
            $sl+=$value['sl'];
            $total+=$value['sl']*$value['gia']*(100-$value['giamgia'])/100;
        }
        $startTime = date("Y-m-d H:i:s");
        DB::insert('INSERT INTO `hoadon`(`idkh`,`tongsl`, `tong`, `ngaymua`, `tinhtrang`) VALUES(?,?,?,?,?)', 
        [$request->id,$sl,$total,$startTime,0]);
        $id=DB::select('SELECT `id` FROM `hoadon` ORDER BY `id` DESC LIMIT 1');
        foreach ($cart as $key => $value) {
            $idsp=$value['id'];
            $sanpham = DB::select('SELECT * FROM `sanpham` WHERE id = ?', [$idsp]);
            $slsp=$value['sl'];
            DB::insert('INSERT INTO `cthd`(`idct`, `ten`,`size`, `img`, `gia`, `sl`, `giamgia`) VALUES(?,?,?,?,?,?,?)',
            [$id[0]->id,$sanpham[0]->ten,$value ['size'],$sanpham[0]->img,$sanpham[0]->gia,$slsp,$sanpham[0]->giamgia]);
        }
        $cart =[];
        $data =DB::select('SELECT * FROM `hoadon` ORDER BY `id` DESC LIMIT 1');
        Mail::send('admin.emailhoadon',compact('data'), function ($message) {
            $message->subject('Đơn hàng của '.Auth::user()->name.' tại shop N$M');
            $message->from('shopn$m@gmail.com', 'ShopN$M');
            $message->to(Auth::user()->email,Auth::user()->name);
        });
        session()->put('cart', $cart);
        return redirect(route('cart.index'))->with('success', 'Đặt hàng thành công','success1','');
    }
    public function huydon(Request $request)
    {
       
        DB::update("UPDATE `hoadon` SET `tinhtrang`=3,`lydo`='khách hàng hủy' WHERE `id`=?", [ $request->id]);
        return redirect()->back()->with('success', 'Hủy đơn hàng thành công thành công');
    }
}