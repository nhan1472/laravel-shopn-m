@extends('layout.client')
@section('title')
    {{ $title }}
@endsection
@section('css')
    <style>
        .middle {
            transition: .5s ease;
            opacity: 0;
            position: absolute;
            bottom: 20%;
            left: 50%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            text-align: center;
        }

        .yeuthich {
            position: absolute;
            top: 10%;
            right: 0%;
            cursor: pointer;

            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
        }

        .giamgia {
            position: absolute;
            top: 10%;
            left: 10%;
            cursor: pointer;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
        }

        .card:hover .image {
            opacity: 0.3;
        }

        .card:hover .middle {
            opacity: 0.8;
        }

        .card:hover {
            box-shadow: 0 8px 12px 0 rgba(0, 0, 0, 0.2)
        }

        .checked {
            color: orange;
        }

        @media only screen and (max-width: 800px) {
            .chu {
                font-size: 14px;
            }
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div ng-controller='spcontroller'>
            <div class="row mt-2">
                <div class="col-md-4 col-12 col-lg-3">
                    <h3 class="text-center">Bộ lọc sản phẩm</h3>
                    <hr>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" ng-model="checkyt" ng-change="ktdm()"
                            style="height: 20px;width: 20px;"> Sản phẩm yêu thích
                        <br>
                        <hr>
                        <input type="checkbox" class="form-check-input" ng-model="checksale" ng-change="ktdm()"
                            style="height: 20px;width: 20px;"> Sản phẩm giảm giá
                    </div>
                    <hr>
                    <h4>Lọc theo danh mục</h4>
                    <ul class="form-check form-switch">
                        <li ng-repeat="item in listLoai">
                            <input class="form-check-input" style="width: 50px;cursor: pointer;" ng-change="ktdm()"
                                type="checkbox" role="switch" ng-model="checkdm[item.id]">
                            @{{ item.name }}
                        </li>
                    </ul>
                    <hr>
                    <h4>Lọc theo Size</h4>
                    <ul class="form-check ">
                        <li ng-repeat="item in listSize">
                            <input class="form-check-input" style="width: 25px;cursor: pointer;" ng-change="ktdm()"
                                type="checkbox" ng-model="checksize[$index]">
                            @{{ item.size }}
                        </li>
                    </ul>
                    <hr>
                    <h4>Lọc theo giá</h4>
                    <div class="range-slider">
                        <input type="range" min="@{{ min }}" ng-change="ktgiamin()"
                            max="@{{ max() }}" step="10" ng-model="giamin" class="form-range rangee">
                        <input type="range" min="@{{ min }}" ng-change="ktgiamax()"
                            max="@{{ max() }}" step="10" ng-model="giamax" class="form-range rangee">
                    </div>
                    @{{ giamin }}
                    @{{ giamax }}
                    {{-- @{{ sizect }} --}}
                </div>
                <div class="col-12 col-md-8 col-lg-9">
                    <div ng-if="tt" class="alert alert-@{{ type }}  alert-dismissible">
                        @{{ thongbao }}
                        <button type="button" class="btn-close" ng-click="kttt()" aria-label="Close"></button>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-12 col-md-8 col-lg-9">
                            <input type="text" ng-model="seach" ng-change="ktdm()" class="form-control"
                                placeholder="nhập tên sản phẩm cần tìm......">
                        </div>
                        <div class="col-md-4 col-lg-3    d-none d-md-block">
                            <select ng-model="sapxep" class="form-control">
                                <option ng-repeat="item in loaisx" value="@{{ item.value }}">@{{ item.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div ng-if="ktitem">
                        <div class="row" style="margin-bottom: 300px;margin-top: 100px">
                            <div class="col-4"></div>
                            <div class="col-4">
                                <img src="{{ asset('img/rong.png') }}" width="50%" alt="không có sản phẩm">
                                <h2 class="text-center text-danger">@{{ thongbao1 }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 d-none d-md-none d-lg-block mt-3"
                            ng-repeat="items in listItems  |seachname :seach  |locdm: listLoai |locsize :listSize:sizect |locyt :checkyt|locsale :checksale|locgia :giamin :giamax |  orderBy:sapxep  |limitTo  :page:start">
                            <div class="card" style="width: 100%;">
                                <a href="/sanpham/@{{ items.id }}">
                                    <img src="@{{ items.img }}" class="card-img-top image" style="max-height:300px"
                                        alt="@{{ items.ten }}">
                                    <div class="card-body">

                                        <div class="yeuthich">
                                            <div>
                                                <img src="{{ asset('img/yeuthich.png') }}" ng-if="!yt[items.id]"
                                                    ng-click="addyt(items.id,$event)" height="35px" width="60px"
                                                    alt="yeuthich">
                                                <img src="{{ asset('img/yeuthich1.png') }}" ng-if="yt[items.id]"
                                                    ng-click="addyt(items.id,$event)" height="45px" width="60px"
                                                    alt="yeuthich">
                                            </div>
                                        </div>

                                        <div class="giamgia">
                                            <div ng-if="items.giamgia>0">
                                                <a class="btn btn-danger">@{{ items.giamgia }}%</a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">Lược xem :@{{ items.luotxem }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div style="float: left; margin-left:5px; "
                                                    ng-repeat="row in sao[items.id]">
                                                    <span ng-if="row.gt" class="fa fa-star checked"></span>
                                                    <span ng-if="!row.gt" class="fa fa-star "></span>
                                                </div>
                                            </div>
                                        </div>

                                        <h5 class="card-title text-center chu">@{{ items.ten }}
                                            || Size:<a style="color:black;text-decoration: none;"
                                                ng-repeat="item in items.size">@{{ item }},</a>
                                            <div ng-if="items.giamgia>0" class="text-center text-danger">
                                                <p class="card-text chu">
                                                    <span
                                                        style="text-decoration:line-through; ">@{{ items.gia | number }}</span>
                                                    ||
                                                    @{{ items.gia * (100 - items.giamgia) / 100 | number }}đ
                                                </p>
                                            </div>

                                            <div ng-if="items.giamgia==0">
                                                <p class="card-text text-danger text-center">

                                                    @{{ items.gia | number }}đ
                                                </p>
                                            </div>

                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6 d-none d-md-block d-lg-none     mt-3"
                            ng-repeat="items in listItems  |seachname :seach  |locdm: listLoai |locsize :listSize:sizect |locyt :checkyt|locsale :checksale|locgia :giamin :giamax |  orderBy:sapxep  |limitTo  :page:start">
                            <div class="card" style="width: 100%;">
                                <a href="/sanpham/@{{ items.id }}">
                                    <img src="@{{ items.img }}" class="card-img-top image"
                                        style="max-height:300px" alt="@{{ items.ten }}">
                                    <div class="card-body">

                                        <div class="yeuthich">
                                            <div>
                                                <img src="{{ asset('img/yeuthich.png') }}" ng-if="!yt[items.id]"
                                                    ng-click="addyt(items.id,$event)" height="35px" width="60px"
                                                    alt="yeuthich">
                                                <img src="{{ asset('img/yeuthich1.png') }}" ng-if="yt[items.id]"
                                                    ng-click="addyt(items.id,$event)" height="45px" width="60px"
                                                    alt="yeuthich">
                                            </div>
                                        </div>

                                        <div class="giamgia">
                                            <div ng-if="items.giamgia>0">
                                                <a class="btn btn-danger">@{{ items.giamgia }}%</a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">Lược xem :@{{ items.luotxem }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div style="float: left; margin-left:5px; "
                                                    ng-repeat="row in sao[items.id]">
                                                    <span ng-if="row.gt" class="fa fa-star checked"></span>
                                                    <span ng-if="!row.gt" class="fa fa-star "></span>
                                                </div>
                                            </div>
                                        </div>

                                        <h5 class="card-title text-center chu">@{{ items.ten }}
                                            || Size:<a style="color:black;text-decoration: none;"
                                                ng-repeat="item in items.size">@{{ item }},</a>
                                            <div ng-if="items.giamgia>0" class="text-center text-danger">
                                                <p class="card-text chu">
                                                    <span
                                                        style="text-decoration:line-through; ">@{{ items.gia | number }}</span>
                                                    ||
                                                    @{{ items.gia * (100 - items.giamgia) / 100 | number }}đ
                                                </p>
                                            </div>

                                            <div ng-if="items.giamgia==0">
                                                <p class="card-text text-danger text-center">

                                                    @{{ items.gia | number }}đ
                                                </p>
                                            </div>

                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-12 d-block d-md-none mt-3"
                            ng-repeat="items in listItems  |seachname :seach  |locdm: listLoai |locsize :listSize:sizect |locyt :checkyt|locsale :checksale|locgia :giamin :giamax |  orderBy:sapxep  |limitTo  :page:start">
                            <div class="card" style="width: 100%;">
                                <a href="/sanpham/@{{ items.id }}">
                                    <img src="@{{ items.img }}" class="card-img-top image"
                                        style="max-height:300px" alt="@{{ items.ten }}">
                                    <div class="card-body">

                                        <div class="yeuthich">
                                            <div>
                                                <img src="{{ asset('img/yeuthich.png') }}" ng-if="!yt[items.id]"
                                                    ng-click="addyt(items.id,$event)" height="35px" width="60px"
                                                    alt="yeuthich">
                                                <img src="{{ asset('img/yeuthich1.png') }}" ng-if="yt[items.id]"
                                                    ng-click="addyt(items.id,$event)" height="45px" width="60px"
                                                    alt="yeuthich">
                                            </div>
                                        </div>

                                        <div class="giamgia">
                                            <div ng-if="items.giamgia>0">
                                                <a class="btn btn-danger">@{{ items.giamgia }}%</a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">Lược xem :@{{ items.luotxem }}</div>
                                            <div class="col-6"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div style="float: left; margin-left:5px; "
                                                    ng-repeat="row in sao[items.id]">
                                                    <span ng-if="row.gt" class="fa fa-star checked"></span>
                                                    <span ng-if="!row.gt" class="fa fa-star "></span>
                                                </div>
                                            </div>
                                        </div>

                                        <h5 class="card-title text-center">@{{ items.ten }}
                                            || Size:<a style="color:black;text-decoration: none;"
                                                ng-repeat="item in items.size">@{{ item }},</a>
                                            <div ng-if="items.giamgia>0" class="text-center text-danger">
                                                <p class="card-text ">
                                                    <span
                                                        style="text-decoration:line-through; ">@{{ items.gia | number }}</span>
                                                    ||
                                                    @{{ items.gia * (100 - items.giamgia) / 100 | number }}đ
                                                </p>
                                            </div>

                                            <div ng-if="items.giamgia==0">
                                                <p class="card-text text-danger text-center">

                                                    @{{ items.gia | number }}đ
                                                </p>
                                            </div>

                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <nav aria-label="Page navigation example" class="mt-2">
                        <ul class="pagination">
                            <li class="page-item " ng-repeat="item in listCount" style="cursor: pointer;"><a
                                    class="page-link" ng-class="active[$index]"
                                    ng-click="pageClick(item)">@{{ item }}</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('js')
    <script>
        var app = angular.module('myapp', [])
        app.filter('seachname', function($rootScope) {
            return function(input, ts1) {
                $rootScope.listCount = []
                $rootScope.count = Math.ceil(input.length / $rootScope.page)
                for (i = 1; i <= $rootScope.count; i++) {
                    $rootScope.listCount.push(i)
                }
                return input.filter(item => item.ten.toLowerCase().indexOf(ts1.toLowerCase()) !== -1);
            }
        })
        app.filter('locyt', function($rootScope) {
            return function(input, ts1) {
                $rootScope.listCount = []
                $rootScope.count = Math.ceil(input.length / $rootScope.page)
                for (i = 1; i <= $rootScope.count; i++) {
                    $rootScope.listCount.push(i)
                }
                if (ts1 == true) {
                    if (JSON.parse(localStorage.getItem("cartyt"))) {
                        $rootScope.cartyt = JSON.parse(localStorage.getItem("cartyt"))
                    } else {
                        $rootScope.cartyt = []
                    }
                    return $rootScope.cartyt
                } else {
                    return input;
                }

            }
        })
        app.filter('locsale', function($rootScope) {
            return function(input, ts1) {
                if (ts1 == true) {
                    return input.filter(item => item.giamgia > 0);
                } else {
                    return input;
                }
            }
        })
        app.filter('locgia', function($rootScope) {
            return function(input, ts1, ts2) {
                var output = []
                output = input.filter(item => item.gia >= ts1 && item.gia <= ts2);
                $rootScope.listCount = []
                $rootScope.count = Math.ceil(output.length / $rootScope.page)
                for (i = 1; i <= $rootScope.count; i++) {
                    $rootScope.listCount.push(i)
                }
                if (output.length == 0) {
                    $rootScope.ktitem = true
                    $rootScope.thongbao1 = 'không có sản phù hợp'
                } else {
                    $rootScope.ktitem = false
                    $rootScope.thongbao1 = ''
                }
                return output
            }
        })
        app.filter('locdm', function($rootScope) {
            return function(input, ts1) {
                var output = []
                var kt = 0
                for (i = 0; i < input.length; i++) {
                    for (j = 0; j < ts1.length; j++) {
                        if ($rootScope.checkdm[ts1[j].id] == true) {
                            if (input[i].maloai == ts1[j].id) {
                                output.push(input[i])
                            }
                            kt = 1
                        }
                    }
                }
                if (kt == 0) {
                    output = input
                }
                $rootScope.listCount = []
                $rootScope.count = Math.ceil(output.length / $rootScope.page)
                for (i = 1; i <= $rootScope.count; i++) {
                    $rootScope.listCount.push(i)
                }
                return output
            }
        })
        app.filter('locsize', function($rootScope) {
            return function(input, ts1, ts2) {
                var out = []
                var sp = []
                var size = []
                var kt = false
                for (i = 0; i < ts1.length; i++) {
                    if ($rootScope.checksize[i] == true) {
                        size.push(ts1[i])
                        kt = true
                    }
                }
                for (i = 0; i < ts2.length; i++) {
                    for (j = 0; j < size.length; j++) {
                        if (ts2[i].idsize == size[j].id) {
                            out.push(ts2[i])
                        }
                    }
                }
                for (i = 0; i < input.length; i++) {
                    for (j = 0; j < out.length; j++) {
                        if (input[i].id == out[j].idsp) {
                            sp.push(input[i])
                            break
                        }
                    }
                }

                if (kt == true) {
                    return sp
                } else {
                    return input
                }

            }
        })
        app.controller('spcontroller', function($scope, $rootScope) {
            $rootScope.listItems = [
                @foreach ($listSanpham as $item)
                    {
                        'id': {{ $item->id }},
                        'ten': '{{ $item->ten }}',
                        'img': '{{ $item->img }}',
                        'gia': {{ $item->gia }},
                        'giamgia': {{ $item->giamgia }},
                        'luotxem': {{ $item->luotxem }},
                        @php
                            $diemtb = DB::select('SELECT AVG(`diem`) as sl FROM `binhluan` WHERE idsp = ?', [$item->id]);
                            $size = DB::select('SELECT * FROM `sizect` WHERE `idsp`=?', [$item->id]);
                        @endphp
                        @if (ceil($diemtb[0]->sl) > 0)
                            'danhgia': {{ ceil($diemtb[0]->sl) }},
                        @else
                            'danhgia': 0,
                        @endif
                        'maloai': {{ $item->maloai }},
                        'size': [
                            @foreach ($size as $row)
                                @php
                                    $sizect1 = DB::select('SELECT * FROM `size` WHERE `id`=?', [$row->idsize]);
                                @endphp
                                    '{{ $sizect1[0]->size }}',
                            @endforeach
                        ],
                    },
                @endforeach
            ]
            $scope.sao = []
            $scope.listItems.forEach((e) => {

                $scope.sao[e.id] = []
                for (i = 0; i < e.danhgia; i++) {
                    $scope.sao[e.id].push({
                        gt: true
                    })
                }
                while ($scope.sao[e.id].length < 5) {
                    $scope.sao[e.id].push({
                        gt: false
                    })
                }
            })
            $rootScope.listLoai = [
                @foreach ($listLoai as $item)
                    {
                        'id': {{ $item->id }},
                        'name': '{{ $item->name }}',
                    },
                @endforeach
            ]
            $rootScope.listSize = [
                @foreach ($listSize as $item)
                    {
                        'id': {{ $item->id }},
                        'size': '{{ $item->size }}',
                    },
                @endforeach
            ]
            $rootScope.sizect = [
                @foreach ($sizect as $item)
                    {
                        'id': {{ $item->id }},
                        'idsp': {{ $item->idsp }},
                        'idsize': {{ $item->idsize }},
                    },
                @endforeach
            ]
            $rootScope.seach = ''
            $rootScope.sapxep = ''
            $rootScope.checkdm = []
            $rootScope.kttt = function() {
                $rootScope.tt = false
            }
            $rootScope.loaisx = [{
                    'value': '',
                    'name': '----Măc Đinh----'
                },
                {
                    'value': '-luotxem',
                    'name': 'Lược xem'
                },
                {
                    'value': '-danhgia',
                    'name': 'Đánh giá'
                },
                {
                    'value': 'gia',
                    'name': 'Giá từ thấp tới cao'
                },
                {
                    'value': '-gia',
                    'name': 'Giá từ cao tới thấp'
                },
            ]
            $rootScope.start = 0
            $rootScope.page = 9
            $scope.active = []
            $scope.idpage = 0
            $scope.active[0] = 'pageactive'
            $rootScope.pageClick = function(i) {
                $rootScope.start = (i - 1) * $rootScope.page
                $scope.idpage = i - 1
                for (i = 0; i < $rootScope.listCount.length; i++) {
                    if (i == $scope.idpage) {
                        $scope.active[i] = 'pageactive'
                    } else {
                        $scope.active[i] = ''
                    }
                }
            }
            $rootScope.min = 0
            $rootScope.max = function() {
                var max = $rootScope.listItems[0].gia
                for (i = 0; i < $rootScope.listItems.length; i++) {
                    if (max < $rootScope.listItems[i].gia) {
                        max = $rootScope.listItems[i].gia
                    }
                }
                return max
            }
            $rootScope.giamin = 0
            $rootScope.giamax = $rootScope.max()
            $rootScope.ktgiamin = function() {
                if ($rootScope.start > 0) {
                    $rootScope.start = 0
                }

                if ($scope.giamin > $scope.giamax) {
                    $scope.giamin = $scope.giamax
                    // alert('helo')
                }
            }
            $rootScope.ktgiamax = function() {
                if ($rootScope.start > 0) {
                    $rootScope.start = 0
                }

                if ($scope.giamax <= $scope.giamin) {
                    $scope.giamax = $scope.giamin
                }
            }
            $rootScope.yt = []
            for (i = 0; i < $rootScope.listItems.length; i++) {
                $rootScope.yt[$rootScope.listItems[i].id] = false
            }
            if (JSON.parse(localStorage.getItem("cartyt"))) {
                $rootScope.cartyt = JSON.parse(localStorage.getItem("cartyt"))
            } else {
                $rootScope.cartyt = []
            }
            for (i = 0; i < $rootScope.cartyt.length; i++) {
                $rootScope.yt[$rootScope.cartyt[i].id] = true
            }
            $rootScope.addyt = function(i, event) {
                $rootScope.idyt = i
                if ($rootScope.yt[i] == false) {
                    $rootScope.yt[i] = !$rootScope.yt[i]
                    for (i = 0; i < $rootScope.listItems.length; i++) {
                        if ($rootScope.listItems[i].id == $rootScope.idyt) {
                            $rootScope.cartyt.push($rootScope.listItems[i])
                        }
                    }
                    localStorage.setItem("cartyt", JSON.stringify($rootScope.cartyt))
                } else {
                    $rootScope.yt[i] = !$rootScope.yt[i]
                    for (i = 0; i < $rootScope.cartyt.length; i++) {
                        if ($rootScope.cartyt[i].id == $rootScope.idyt) {
                            $rootScope.cartyt.splice(i, 1)
                        }
                    }
                    localStorage.setItem("cartyt", JSON.stringify($rootScope.cartyt))
                }
                event.preventDefault();
            }
            $rootScope.checkyt = false
            // if(JSON.parse(localStorage.getItem("cart")))
            // {
            //     $rootScope.cart=JSON.parse(localStorage.getItem("cart"))
            // }
            // else{
            //     $rootScope.cart=[]
            // }
            // $rootScope.addcart = function(i)
            // {   var kt=0
            //     $rootScope.items=i
            //     for(i=0;i<$rootScope.cart.length;i++)
            //     {
            //         if($rootScope.cart[i].id==$rootScope.items.id)
            //         {
            //             $rootScope.cart[i].sl++
            //             kt=1
            //         }
            //     }
            //     if(kt==0)
            //     {
            //         $rootScope.items.sl=1
            //     $rootScope.cart.push($rootScope.items)
            //     }
            //     localStorage.setItem("cart", JSON.stringify($rootScope.cart))
            // }
            $rootScope.ktdm = function() {
                for (i = 0; i < $rootScope.listCount.length; i++) {
                    if (i == 0) {
                        $scope.active[i] = 'pageactive'
                    } else {
                        $scope.active[i] = ''
                    }
                }
                if ($rootScope.start > 0) {
                    $rootScope.start = 0

                }
            }
            $rootScope.checksize = []
        })
    </script>
@endsection
