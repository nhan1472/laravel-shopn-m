<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SanphamController;
use App\Http\Controllers\GioithieuController;
use App\Http\Controllers\TintucController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ClientController::class,'index'])->name('index');
Route::prefix('/user')->name('user.')->middleware('auth')->middleware('user')->group(function () {
    Route::get('/', [ClientController::class,'user'])->name('index');
    Route::get('/giohang', [ClientController::class,'giohang'])->name('giohang');
    Route::post('/huydon', [CartController::class,'huydon'])->name('huydon');
    Route::post('/updateusert', [ClientController::class,'updateusert'])->name('updateusert');
    Route::post('/updateusert1', [ClientController::class,'updateusert1'])->name('updateusert1');
    Route::get('/updatepass', [ClientController::class,'updatepassindex'])->name('updatepass');
    Route::post('/updatepass1', [ClientController::class,'updatepass1'])->name('updatepass1');
    Route::post('/updatepass', [ClientController::class,'updatepass']);
    Route::prefix('/hoadon')->middleware('admin1')->name('hoadon.')->group(function () {
        Route::get('/', [AdminController::class,'hoadon'])->name('index');
        Route::post('/duyet', [AdminController::class,'duyet'])->name('duyet');
        Route::post('/huy', [AdminController::class,'huy'])->name('huy');
        Route::post('/giao', [AdminController::class,'giao'])->name('giao');
        Route::get('/inhoadon/{id}', [PdfController::class,'index'])->name('inhoadon');
    });
});
Route::post('/binhluan', [AdminController::class,'binhluan'])->name('binhluan')->middleware('auth');
Route::get('/dangnhap', [ClientController::class,'login'])->name('dangnhap')->middleware('login');
Route::get('/dangky', [ClientController::class,'register'])->name('dangky')->middleware('login');
Route::post('/phanhoi', [ClientController::class,'phanhoi'])->name('phanhoi');
Route::get('/dangxuat',function()
{  Auth::logout();
    return redirect('/');
})->name('dangxuat');
Route::prefix('sanpham')->name('sanpham.')->group(function () {
    Route::get('/', [SanphamController::class,'index'])->name('index');
    Route::get('/{id}', [SanphamController::class,'detail'])->name('dateil');
});
Route::prefix('gioithieu')->name('gioithieu.')->group(function () {
    Route::get('/', [GioithieuController::class,'index'])->name('index');
});
Route::prefix('tintuc')->name('tintuc.')->group(function () {
    Route::get('/', [TintucController::class,'index'])->name('index');
    Route::get('/{id}', [TintucController::class,'tintucdetail'])->name('tintucdetail');
});
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class,'index'])->name('index');
    Route::get('/dathang', [CartController::class,'showdathang'])->name('dathang');
    Route::get('/add', [CartController::class,'addCart'])->name('add');
    Route::post('/remove', [CartController::class,'remove'])->name('remove');
    Route::post('/tang', [CartController::class,'tangSl'])->name('tang');
    Route::post('/giam', [CartController::class,'giamSl'])->name('giam');
    Route::post('/addhoadon', [CartController::class,'addhoadon'])->name('addhoadon')->middleware('user');
});

Route::prefix('admin')->name('admin.')->middleware('auth')->middleware('admin')->group(function () {
    Route::get('/', [AdminController::class,'index'])->name('index');
    Route::get('/inhoadon/{id}', [PdfController::class,'index'])->name('inhoadon');
    Route::prefix('/thongke')->name('thongke.')->group(function () {
        Route::get('/', [AdminController::class,'thongke'])->name('index');
    });
    Route::prefix('/slider')->name('slider.')->group(function () {
        Route::get('/', [AdminController::class,'slider'])->name('index');
        Route::post('/add', [AdminController::class,'slideradd'])->name('add');
        Route::post('/update', [AdminController::class,'sliderupdate'])->name('update');
        Route::post('/remove', [AdminController::class,'slideremove'])->name('remove');
    });
    Route::post('/register', [AdminController::class,'register'])->name('register');
    Route::prefix('/footer')->name('footer.')->group(function () {
        Route::get('/', [AdminController::class,'footer'])->name('index');
        Route::post('/xoa', [AdminController::class,'footerxoa'])->name('xoa');
        Route::post('/xoack', [AdminController::class,'footerxoack'])->name('xoack');
        Route::post('/sua', [AdminController::class,'footersua'])->name('sua');
        Route::post('/suack', [AdminController::class,'footersuack'])->name('suack');
        Route::post('/them', [AdminController::class,'footerthem'])->name('them');
        Route::post('/themck', [AdminController::class,'footerthemck'])->name('themck');
    });
    Route::prefix('/phanhoi')->name('phanhoi.')->group(function () {
        Route::get('/', [AdminController::class,'phanhoi'])->name('index');
        Route::post('/traloi', [AdminController::class,'phanhoitraloi'])->name('traloi');
    });
    Route::prefix('/danhmuc')->name('danhmuc.')->group(function () {
        Route::get('/', [AdminController::class,'danhmuc'])->name('index');
        Route::post('/add', [AdminController::class,'danhmucadd'])->name('add');
        Route::post('/remove', [AdminController::class,'danhmucremove'])->name('remove');
        Route::post('/edit', [AdminController::class,'danhmucedit'])->name('edit');
    });
    Route::prefix('/menu')->name('menu.')->group(function () {
        Route::get('/', [AdminController::class,'menu'])->name('index');
        Route::post('/update', [AdminController::class,'menuupdate'])->name('update');
    });
    Route::prefix('/user')->name('user.')->group(function () {
        Route::get('/', [AdminController::class,'user'])->name('index');
        Route::get('/nhanvien', [AdminController::class,'nhanvien'])->name('nhanvien');
    });
    Route::prefix('/sanpham')->name('sanpham.')->group(function () {
        Route::get('/', [SanphamController::class,'indexadmin'])->name('index');
        Route::get('/edit', [SanphamController::class,'indexedit'])->name('edit');
        Route::post('/update', [SanphamController::class,'indexupdate'])->name('update');
        Route::post('/remove', [SanphamController::class,'remove'])->name('remove');
        Route::post('/add', [SanphamController::class,'add'])->name('add');
    });
    Route::prefix('/tintuc')->name('tintuc.')->group(function () {
        Route::get('/', [TintucController::class,'indexadmin'])->name('index');
     
        Route::get('/danhmuc', [TintucController::class,'danhmuc'])->name('danhmuc');
        Route::post('/danhmucadd', [TintucController::class,'adddanhmuc'])->name('adddanhmuc');
        Route::post('/danhmucxoa', [TintucController::class,'xoadanhmuc'])->name('xoadanhmuc');
        Route::post('/danhmucedit', [TintucController::class,'danhmucedit'])->name('danhmucedit');
        Route::post('/add', [TintucController::class,'add'])->name('add');
        Route::post('/xoa', [TintucController::class,'xoa'])->name('xoa');
        Route::post('/update', [TintucController::class,'update'])->name('update');
        Route::get('/xem', [TintucController::class,'xem'])->name('xem');
    });
    Route::prefix('/size')->name('size.')->group(function () {
        Route::get('/', [AdminController::class,'size'])->name('index');
        Route::post('/add', [AdminController::class,'sizeadd'])->name('add');
        Route::post('/addct', [AdminController::class,'sizeaddct'])->name('addct');
        Route::post('/remove', [AdminController::class,'sizeremove'])->name('remove');
        Route::post('/removesp', [AdminController::class,'sizeremovesp'])->name('removesp');
        Route::post('/edit', [AdminController::class,'sizeedit'])->name('edit');
    });
    Route::prefix('/sale')->name('sale.')->group(function () {
        Route::get('/', [AdminController::class,'sale'])->name('index');
        Route::post('/add', [AdminController::class,'saleadd'])->name('add');
    });
    Route::prefix('/hoadon')->name('hoadon.')->group(function () {
        Route::get('/', [AdminController::class,'hoadon'])->name('index');
        Route::post('/duyet', [AdminController::class,'duyet'])->name('duyet');
        Route::post('/giao', [AdminController::class,'giao'])->name('giao');
        Route::post('/huy', [AdminController::class,'huy'])->name('huy');
    });
    Route::get('/resetpass', [AdminController::class,'resetpass'])->name('resetpass');
    Route::post('/resetpass', [AdminController::class,'resetpass1']);
    Route::post('/resetpass1', [AdminController::class,'resetpass2'])->name('resetpass1');
    Route::post('/updateadmin', [AdminController::class,'updateadmin'])->name('updateadmin');
});
Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
