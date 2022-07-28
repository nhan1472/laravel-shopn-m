@extends('layout.client')
@section('title')
    {{ $sanpham[0]->ten }}
@endsection
@section('css')
    <style>
        .actvie-menu {
            background: aqua;
        }

        div.stars {
            width: 270px;
            display: inline-block;
        }

        input.star {
            display: none;
        }

        label.star {
            float: right;
            padding: 0px 5px;
            font-size: 24px;
            color: #444;
            transition: all .2s;
        }
        
        input.star:checked~label.star:before {
            content: '\f005';
            color: #FD4;
            transition: all .25s;
        }

        input.star-5:checked~label.star:before {
            color: #FE7;
            text-shadow: 0 0 20px #952;
        }

        input.star-1:checked~label.star:before {
            color: #F62;
        }

        label.star:hover {
            transform: rotate(-15deg) scale(1.3);
        }

        label.star:before {
            content: '\f006';
            font-family: FontAwesome;
        }
        @media only screen and (max-width: 723px) {
            label.star {
                font-size: 14px;
            }
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row my-5 " ng-controller="spcontroller">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }} <a href="{{ route('cart.index') }}"> Xem giỏ hàng</a>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <table class="table">
                <tbody>
                    <tr>
                        <td><img class="d-none d-md-block" src="@{{ item.img }}" alt="@{{ item.ten }}" height="450px" width="100%">
                            <img class="d-block d-md-none" src="@{{ item.img }}" alt="@{{ item.ten }}" height="275px" width="100%">
                        </td>
                        <td>
                            <h1 class="text-center d-none d-md-block">@{{ item.ten }}</h1>
                            <h3 class="text-center d-block d-md-none">@{{ item.ten }}</h3>
                            <h6><i>Lược xem:@{{ item.luotxem }}</i></h6>
                            <hr size="4">
                            <form action="{{ route('cart.add') }}">
                                <input type="hidden" name="id" value="{{ $sanpham[0]->id }}">
                                <h2 class="my-3 d-none d-md-block">Size sản phẩm:</h2>
                                <h4 class="my-3 d-block d-md-none">Size sản phẩm:</h4>
                                <select name="size" class="form-control">
                                    @foreach ($sizect as $item)
                                        @php
                                            $size = DB::select('SELECT * FROM `size` WHERE id = ?', [$item->idsize]);
                                        @endphp
                                        <option value=" {{ $size[0]->id }}"> {{ $size[0]->size }}</option>
                                    @endforeach
                                </select>
                                <h2 class="my-3 d-none d-md-block">Số lượng: </h2>
                                <h4 class="my-3 d-block d-md-none">Số lượng: </h4>
                                <h2 class="my-3 d-none d-md-block"> <input type="number" name="sl" ng-model="sl" ng-change="kt()"
                                        style="width: 100px;height: 100%;"></h2>
                                        <h2 class="my-3 d-block d-md-none"> <input type="number" name="sl" ng-model="sl" ng-change="kt()"
                                            style="width: 100px;height: 100%;"></h2>
                                <h2 class="d-none d-md-block">Giá : @{{ item.gia | number }}đ Giảm gia:@{{ item.giamgia }}%</h2>
                                <h6 class="d-block d-md-none">Giá : @{{ item.gia | number }}đ Giảm gia:@{{ item.giamgia }}%</h6>
                                <h2 class="d-none d-md-block">Thành tiền : @{{ item.gia * sl * (100 - item.giamgia) / 100 | number }}đ</h2>
                                <h6 class="d-block d-md-none">Thành tiền : @{{ item.gia * sl * (100 - item.giamgia) / 100 | number }}đ</h6>
                                <div style="float: left;" ng-repeat="row in saotb">
                                    <label  ng-if="row.gt==true" class="star" style="color: #FD4;"></label>
                                    <label  ng-if="row.gt==false" class="star"  ></label>
                                </div>
                                <br>
                                <h4 class="d-none d-md-block"> (@{{item.sl}} đánh giá / @{{item.diemtb}} Sao)</h4>
                                <h6 class="d-block d-md-none"> (@{{item.sl}} đánh giá / @{{item.diemtb}} Sao)</h6>
                                <br>
                                <button class="btn btn-danger" type="submit">
                                    <h4 class="d-none d-md-block">Thêm vào giỏ</h4>
                                    <h6 class="d-block d-md-none">Thêm vào giỏ</h6>
                                </button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
            <hr size="4" class="my-3">

            <ul class="nav justify-content-center">
                <li class="nav-item">
                    <a class="nav-link" ng-class="active[0]" style="cursor: pointer" ng-click="tt(0)">
                        <h1 class="text-dark d-none d-md-block">Thông tin chi tiết</h1>
                        <h3 class="text-dark d-block d-md-none">Thông tin chi tiết</h3>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" ng-class="active[1]" style="cursor: pointer" ng-click="bl(1)">
                        <h1 class="text-dark d-none d-md-block">Đánh giá</h1>
                        <h3 class="text-dark d-block d-md-none">Đánh giá</h3>
                    </a>
                </li>
            </ul>
            <div ng-if="hien" class="border" style="min-height: 450px;">
                {!! $sanpham[0]->noidung !!}
            </div>
            <div ng-if="!hien" class="border" style="min-height: 450px;">
                @php
                    $bl = DB::select('SELECT * FROM `binhluan`  WHERE idsp = ? ORDER BY id DESC', [$sanpham[0]->id]);
                    $sl = DB::select('SELECT COUNT(id) as sl FROM `binhluan` WHERE idsp = ?', [$sanpham[0]->id]);
                @endphp
                @if ($sl[0]->sl == 0)
                    <h1 class="text-center my-5">------------------------Chưa có Đánh giá nào ---------------------</h1>
                @else
                <div>
                    <div class="ms-5" ng-repeat="item in listbl |limitTo  :page:start">
                        <div class="row border">
                            <div class="col-2">
                                <img ng-if="item.kh.gioitinh" style="width: 40px;height: 40px; border-radius:50%; "
                                    src="{{ asset('img/icon-nam.jpg') }}" alt="nam">
                                <img ng-if="!item.kh.gioitinh" style="width: 40px;height: 40px; border-radius:50%; "
                                    src="{{ asset('img/icon-nu.jpg') }}" alt="Nữ">
                                <br>
                                @{{ item.kh.name }}
                            </div>
                            <div class="col-10">
                                <table class="table">
                                    <tr>
                                        <td> 
                                            <div style="float: left;" ng-repeat="row in sao[item.id]">
                                            <label  ng-if="row.gt==true" class="star " style="color: #FD4;"></label>
                                            <label  ng-if="row.gt==false" class="star " ></label>
                                        </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>@{{item.noidung}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <nav aria-label="Page navigation example" class="mt-2">
                        <ul class="pagination">
                            <li class="page-item " ng-repeat="item in listCount" style="cursor: pointer;"><a
                                    class="page-link" ng-class="active1[$index]"
                                    ng-click="pageClick(item)">@{{ item }}</a></li>
                        </ul>
                    </nav>
                </div>
                @endif
                @guest
                    <h4 class="text-center my-5">------------------------Bạn chưa đăng nhập---------------------</h4>
                @else
                    <p class="mt-5">Tên:{{ Auth::user()->name }}</p>
                    <div class="stars ">
                        <form action=" {{ route('binhluan') }}" ng-submit="danhgia($event)" method="post">
                            @csrf
                            <input class="star star-5" id="star-5" type="radio" ng-model="star" required name="star"  value="5" />
                            <label class="star star-5" for="star-5"></label>
                            <input class="star star-4" id="star-4" type="radio" ng-model="star" name="star"  value="4" />
                            <label class="star star-4" for="star-4"></label>
                            <input class="star star-3" id="star-3" type="radio" ng-model="star" name="star"   value="3"/>
                            <label class="star star-3" for="star-3"></label>
                            <input class="star star-2" id="star-2" type="radio" ng-model="star" name="star"  value="2" />
                            <label class="star star-2" for="star-2"></label>
                            <input class="star star-1" id="star-1" type="radio" ng-model="star" name="star" value="1" />
                            <label class="star star-1" for="star-1"></label>
                 
                            <input type="hidden" name="idsp" value="{{ $sanpham[0]->id }}">
                            <input type="hidden" name="idkh" value="{{ Auth::user()->id }}">
                            <br>
                            <br>
                            <p ng-if="!star" class="text-danger">bạn chưa chọn mức sao đánh giá</p>
                            <textarea type="text" style="width: 100%;" class="form-control" required name="noidung"
                            ></textarea>
                            <button class="btn btn-outline-info mt-2">Đánh giá</button>
                        </form>
                    </div>
                @endguest

            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        var app = angular.module('myapp', [])
        app.controller('spcontroller', function($scope, $rootScope) {
            $scope.sl = 1
            $scope.item = {
                'id': {{ $sanpham[0]->id }},
                'ten': '{{ $sanpham[0]->ten }}',
                'img': '{{ asset($sanpham[0]->img) }}',
                'luotxem': '{{ $sanpham[0]->luotxem }}',
                'gia': {{ $sanpham[0]->gia }},
                'giamgia': {{ $sanpham[0]->giamgia }},
                @php
                    $diemtb = DB::select('SELECT AVG(`diem`) as sl FROM `binhluan` WHERE idsp = ?', [$sanpham[0]->id]);
                    $sl = DB::select('SELECT COUNT(`id`) as sl FROM `binhluan` WHERE idsp = ?', [$sanpham[0]->id]);
                @endphp
                @if (ceil($diemtb[0]->sl) > 0)
                'diemtb':{{$diemtb[0]->sl}},
                @else
                'diemtb':0,
                @endif
                'sl':{{$sl[0]->sl}}
                
            }
            $scope.kt = function() {
                if ($scope.sl < 1) {
                    $scope.sl = 1
                }
                if($scope.sl >=25)
                {
                    
                    alert('sô lượng sản phẩm không được lớn hơn 25')
                    $scope.sl=25
                }
            }
            $scope.saotb = []
            for(i=0;i<$scope.item.diemtb;i++)
            {
                $scope.saotb.push({
                    gt:true
                })
            }
            while($scope.saotb.length<5)
                {
                    $scope.saotb.push({
                        gt:false
                    })
                }
            $scope.hien = true
            $scope.active = []
            $scope.active[0] = 'actvie-menu'
            $scope.tt = function(i) {
                $scope.active[i] = 'actvie-menu'
                $scope.active[1] = ''
                $scope.hien = true
            }
            $scope.bl = function(i) {
                $scope.active[i] = 'actvie-menu'
                $scope.active[0] = ''
                $scope.hien = false
            }
            $scope.listbl = [
                @foreach ($bl as $item)
                    {
                        'id':{{ $item->id }},
                        @php
                            $kh = DB::select('SELECT * FROM `users` WHERE id = ?', [$item->idkh]);
                            $khgt = DB::select('SELECT * FROM `ctusers` WHERE iduser = ?', [$item->idkh]);
                        @endphp 'kh': {
                            'name': '{{ $kh[0]->name }}',
                            @if ($khgt)
                                @if ($khgt[0]->gioitinh == 'Nam')
                                    'gioitinh': true,
                                @else
                                    'gioitinh': false,
                                @endif
                            @else
                                'gioitinh': true,
                            @endif

                        },
                        'noidung': '{{ $item->noidung }}',
                        'diem':{{ $item->diem }}
                    },
                @endforeach

            ]
            @if (session('bl'))
                $scope.hien = false
                $scope.active[0] = ''
                $scope.active[1] = 'actvie-menu'
            @endif
            $rootScope.start = 0
            $rootScope.page = 5
            $rootScope.listCount = []
            $rootScope.count = Math.ceil($scope.listbl.length / $rootScope.page)
            for (i = 1; i <= $rootScope.count; i++) {
                $rootScope.listCount.push(i)
            }
            $scope.active1 = []
            $scope.idpage = 0
            $scope.active1[0] = 'pageactive'
            $rootScope.pageClick = function(i) {
                $rootScope.start = (i - 1) * $rootScope.page
                $scope.idpage = i - 1
                for (i = 0; i < $rootScope.listCount.length; i++) {
                    if (i == $scope.idpage) {
                        $scope.active1[i] = 'pageactive'
                    } else {
                        $scope.active1[i] = ''
                    }
                }
            }
            $scope.danhgia = function(event)
            {
                @guest
                    
                @else
                @php
                    $danhgia = DB::select('SELECT * FROM `binhluan` WHERE idkh = ? AND idsp=?', [Auth::user()->id,$sanpham[0]->id]);
                    $khachhang = DB::select('SELECT * FROM `users` WHERE `role`=0 AND `id`=? ', [Auth::user()->id]);
                @endphp
                @if(!$khachhang)
                alert('bạn không phải khách hàng không đánh giá được')
                event.preventDefault()
                @endif
                @if ($danhgia)
                    if(!confirm('bạn đã đánh gia rồi có muôn thay đỗi '))
                    {
                        event.preventDefault()
                    }
                @endif
                @endguest
            }
            $scope.sao = []
            $scope.listbl.forEach((e)=>{
              
                $scope.sao[e.id]=[]
                for(i=0;i<e.diem;i++)
                {
                    $scope.sao[e.id].push({
                        gt:true
                    })
                }
                while($scope.sao[e.id].length<5)
                {
                    $scope.sao[e.id].push({
                        gt:false
                    })
                }
            })
        })
    </script>
@endsection
