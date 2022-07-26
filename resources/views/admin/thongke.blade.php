@extends('layout.admin')
@section('title')
    {{ $title }}
@endsection
@section('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <style>
        .an {
            display : none;
        }
        .hien{
           
        }
    </style>
@endsection
@section('content')
    <div class="mt-5" ng-controller="adcontroller">
        <div class="d-flex justify-content-end me-3">
            @php
                $today = date('d/m/Y');
                echo $today;
            @endphp
        </div>
        <h1 class="text-center">{{ $title }}</h1>
        <hr size="4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex">
                        <select ng-model="chonngay" ng-change="anhien()">
                            <option ng-repeat="item in ngay" value="@{{ item.value }}">
                                @{{ item.name }}</option>
                        </select>
                        @php
                            
                            $tuan1 = DB::select('SELECT COUNT(`id`) as sl FROM `hoadon` WHERE DATEDIFF(CURDATE(), ngaymua) <=7');
                            $tuan2 = DB::select('SELECT COUNT(`id`) as sl FROM `hoadon` WHERE DATEDIFF(CURDATE(), ngaymua) <=30');
                            $tuan3 = DB::select('SELECT COUNT(`id`) as sl FROM `hoadon` WHERE DATEDIFF(CURDATE(), ngaymua) <=90');
                            $tuan4 = DB::select('SELECT COUNT(`id`) as sl FROM `hoadon` ');
                            
                            $huy = DB::select('SELECT COUNT(`id`) as sl FROM `hoadon` WHERE DATEDIFF(CURDATE(), ngaymua) <=7 AND `tinhtrang`=3');
                            $huy2 = DB::select('SELECT COUNT(`id`) as sl FROM `hoadon` WHERE DATEDIFF(CURDATE(), ngaymua) <=30 AND `tinhtrang`=3');
                            $huy3 = DB::select('SELECT COUNT(`id`) as sl FROM `hoadon` WHERE DATEDIFF(CURDATE(), ngaymua) <=90 AND `tinhtrang`=3');
                            $huy4 = DB::select('SELECT COUNT(`id`) as sl FROM `hoadon` WHERE  `tinhtrang`=3');
                            
                            $dagiao = DB::select('SELECT COUNT(`id`) as sl FROM `hoadon` WHERE DATEDIFF(CURDATE(), ngaymua) <=7 AND `tinhtrang`=2');
                            $dagiao2 = DB::select('SELECT COUNT(`id`) as sl FROM `hoadon` WHERE DATEDIFF(CURDATE(), ngaymua) <=30 AND `tinhtrang`=2');
                            $dagiao3 = DB::select('SELECT COUNT(`id`) as sl FROM `hoadon` WHERE DATEDIFF(CURDATE(), ngaymua) <=90 AND `tinhtrang`=2');
                            $dagiao4 = DB::select('SELECT COUNT(`id`) as sl FROM `hoadon` WHERE  `tinhtrang`=2');
                            
                            $danguyet = DB::select('SELECT COUNT(`id`) as sl FROM `hoadon` WHERE DATEDIFF(CURDATE(), ngaymua) <=7 AND `tinhtrang`=0');
                            $danguyet2 = DB::select('SELECT COUNT(`id`) as sl FROM `hoadon` WHERE DATEDIFF(CURDATE(), ngaymua) <=30 AND `tinhtrang`=0');
                            $danguyet3 = DB::select('SELECT COUNT(`id`) as sl FROM `hoadon` WHERE DATEDIFF(CURDATE(), ngaymua) <=90 AND `tinhtrang`=0');
                            $danguyet4 = DB::select('SELECT COUNT(`id`) as sl FROM `hoadon` WHERE  `tinhtrang`=0');
                            
                            $dangiao = DB::select('SELECT COUNT(`id`) as sl FROM `hoadon` WHERE DATEDIFF(CURDATE(), ngaymua) <=7 AND `tinhtrang`=1');
                            $dangiao2 = DB::select('SELECT COUNT(`id`) as sl FROM `hoadon` WHERE DATEDIFF(CURDATE(), ngaymua) <=30 AND `tinhtrang`=1');
                            $dangiao3 = DB::select('SELECT COUNT(`id`) as sl FROM `hoadon` WHERE DATEDIFF(CURDATE(), ngaymua) <=90 AND `tinhtrang`=1');
                            $dangiao4 = DB::select('SELECT COUNT(`id`) as sl FROM `hoadon` WHERE `tinhtrang`=1');
                            
                            $tong = DB::select('SELECT SUM(`tong`) as tong FROM `hoadon` WHERE DATEDIFF(CURDATE(), ngaymua) <=7 AND `tinhtrang`=2');
                            $tong2 = DB::select('SELECT SUM(`tong`) as tong FROM `hoadon` WHERE DATEDIFF(CURDATE(), ngaymua) <=30 AND `tinhtrang`=2');
                            $tong3 = DB::select('SELECT SUM(`tong`) as tong FROM `hoadon` WHERE DATEDIFF(CURDATE(), ngaymua) <=90 AND `tinhtrang`=2');
                            $tong4 = DB::select('SELECT SUM(`tong`) as tong FROM `hoadon` WHERE  `tinhtrang`=2');
                        @endphp

                        <div ng-switch="chonngay">
                            <h5 class="ms-5" ng-switch-when="">Có {{ $tuan1[0]->sl }} đơn hàng :
                                {{ $dagiao[0]->sl }} đã giao,
                                {{ $dangiao[0]->sl }} đang giao, {{ $danguyet[0]->sl }} chờ duyệt, {{ $huy[0]->sl }}
                                hủy
                            </h5>
                            <h5 class="ms-5" ng-switch-when="2">Có {{ $tuan2[0]->sl }} đơn hàng :
                                {{ $dagiao2[0]->sl }} đã giao,
                                {{ $dangiao2[0]->sl }} đang giao, {{ $danguyet2[0]->sl }} chờ duyệt,
                                {{ $huy2[0]->sl }}
                                hủy
                            </h5>
                            <h5 class="ms-5" ng-switch-when="3">Có {{ $tuan3[0]->sl }} đơn hàng :
                                {{ $dagiao3[0]->sl }} đã giao,
                                {{ $dangiao3[0]->sl }} đang giao, {{ $danguyet3[0]->sl }} chờ duyệt,
                                {{ $huy3[0]->sl }}
                                hủy
                            </h5>
                            <h5 class="ms-5" ng-switch-when="4">Có {{ $tuan4[0]->sl }} đơn hàng :
                                {{ $dagiao4[0]->sl }} đã giao,
                                {{ $dangiao4[0]->sl }} đang giao, {{ $danguyet4[0]->sl }} chờ duyệt,
                                {{ $huy4[0]->sl }} hủy
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="col-12" ng-switch="chonngay">
                    <h5 ng-switch-when="">Tổng doanh thu: {{ number_format($tong[0]->tong) }}đ</h5>
                    <h5 ng-switch-when="2">Tổng doanh thu: {{ number_format($tong2[0]->tong) }}đ</h5>
                    <h5 ng-switch-when="3">Tổng doanh thu: {{ number_format($tong3[0]->tong) }}đ</h5>
                    <h5 ng-switch-when="4">Tổng doanh thu: {{ number_format($tong4[0]->tong) }}đ</h5>


                </div>
                <div class="col-12">
                <div id="myfirstchart1" ng-class="chart1" ></div>
                <div id="myfirstchart2" ng-class="chart2" ></div>
                <div id="myfirstchart3" ng-class="chart3" ></div>
                <div id="myfirstchart4" ng-class="chart4" ></div>
            </div>
                <div class="col-12 my-5">
                    <h5 class="text-center">Thông kê số khách hàng</h5>
                    <table class="table table-hover">
                        <thead>
                            <tr class="table-active">
                                <th>Số khách hàng mới trông tháng</th>
                                <th>Số khách hàng tháng trước</th>
                                <th>Số khách hàng trong 3 tháng</th>
                                <th>Tổng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @php
                                    $thangr = date('Y-m-d H:i:s', strtotime('-1 month'));
                                    $khtt = DB::select('SELECT COUNT(`id`) AS sl FROM `users` WHERE `role`=0 AND DATEDIFF(CURDATE(), created_at) <=30');
                                    $khtt1 = DB::select("SELECT COUNT(`id`) AS sl FROM `users` WHERE `role`=0 AND DATEDIFF('$thangr', created_at) <=30");
                                    $tkh3t = DB::select('SELECT COUNT(`id`) AS sl FROM `users` WHERE `role`=0 AND DATEDIFF(CURDATE(), created_at) <=90');
                                    $tkh = DB::select('SELECT COUNT(`id`) AS sl FROM `users` WHERE `role`=0 ');
                                @endphp
                                <td><b>{{ $khtt[0]->sl }}</b></td>
                                <td><b>{{ $khtt[0]->sl }}</b></td>
                                <td><b>{{ $tkh3t[0]->sl }}</b></td>
                                <td><b>{{ $tkh[0]->sl }}</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-4">
                    <h4>Thông kê tổng bài viết sản phẩm đơn hàng</h4>
                    <div id="myfirstchart" style="height: 250px;"></div>
                </div>
                @php
                    $sanpham = DB::select('SELECT `ten`,`luotxem` FROM `sanpham` ORDER by `luotxem` DESC');
                    $tintuc = DB::select('SELECT `title`,`luotxem` FROM `tintuc` ORDER BY `luotxem` DESC');
                @endphp
                <div class="col-4">
                    <h4>Bài viết xem nhiều nhất</h4>
                    <table class="table" style="font-size: 10px;">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên</th>
                                <th>Lược xem</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tintuc as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->luotxem }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-4">
                    <h4>Sản phẩm xem nhiều nhất</h4>
                    <table class="table" style="font-size: 10px;">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên</th>
                                <th>Lược xem</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sanpham as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->ten }}</td>
                                    <td>{{ $item->luotxem }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    @php
    $tongsp = DB::select('SELECT COUNT(`id`) as sl FROM `sanpham`');
    $tongbv = DB::select('SELECT COUNT(`id`) as sl FROM `tintuc`');
    $tongdh = DB::select('SELECT COUNT(`id`) as sl FROM `hoadon`');
    @endphp
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                Morris.Donut({
                    element: 'myfirstchart',
                    colors: [
                        '#ff3333',
                        '#ffff66',
                        '#3333ff',
                    ],
                    data: [{
                            label: "Tổng sản phẩm",
                            value: {{ $tongsp[0]->sl }}
                        },
                        {
                            label: "Tổng bài viết",
                            value: {{ $tongbv[0]->sl }}
                        },
                        {
                            label: "Tổng đơn hàng",
                            value: {{ $tongdh[0]->sl }}
                        }
                    ]

                });

                @php
                    $tuan = DB::select('SELECT * FROM `hoadon` WHERE DATEDIFF(CURDATE(), ngaymua) <=7 AND `tinhtrang`=2');
                    $arr = [];
                @endphp
                @foreach ($tuan as $item)
                    @php
                        $ct = DB::select('SELECT * FROM `cthd` WHERE `idct`=' . $item->id);
                        
                    @endphp
                    @foreach ($ct as $row)
                        @php
                            array_push($arr, $row);
                        @endphp
                    @endforeach
                @endforeach
                @php
                    $arr1 = array();
                    
                    foreach ($arr as $key) {
                        $kt = 0;
                        foreach ($arr1 as $row) {
                            if ($key->ten == $row->ten) {
                                $kt = 1;
                                $row->gia += $key->gia;
                            }
                        }
                        if ($kt == 0) {
                            array_push($arr1, $key);
                        }
 
                    }
                    // if(count($arr1)==0)
                    //     {
                    //         $arr1=array(array('ten'=>'không cố sản phẩm','gia'=>0,'giamgia'=>0));
                    //     }
                @endphp
                Morris.Bar({
                    element: 'myfirstchart1',
                    data: [
                        @if (count($arr1)==0)
                            {
                                y:'không có đơn hàng',
                                a:0,
                            },
                        @else
                        @foreach ($arr1 as $row)
                            {
                                y: '{{ $row->ten }}',
                                a: {{ ($row->gia * (100 - $row->giamgia)) / 100 }},
                            },
                        @endforeach
                        @endif
                    ],
                    xkey: 'y',
                    ykeys: ['a'],
                    labels: ['Tổng tiền'],

                });
                @php
                    $tuan = DB::select('SELECT * FROM `hoadon` WHERE `tinhtrang`=2');
                    $arr = [];
                @endphp
                @foreach ($tuan as $item)
                    @php
                        $ct = DB::select('SELECT * FROM `cthd` WHERE `idct`=' . $item->id);
                        
                    @endphp
                    @foreach ($ct as $row)
                        @php
                            array_push($arr, $row);
                        @endphp
                    @endforeach
                @endforeach
                @php
                    $arr1 = [];
                    
                    foreach ($arr as $key) {
                        $kt = 0;
                        foreach ($arr1 as $row) {
                            if ($key->ten == $row->ten) {
                                $kt = 1;
                                $row->gia += $key->gia;
                            }
                        }
                        if ($kt == 0) {
                            array_push($arr1, $key);
                        }
                    }
                @endphp

                Morris.Bar({
                    element: 'myfirstchart4',
                    data: [
                        @if (count($arr1)==0)
                            {
                                y:'không có đơn hàng',
                                a:0,
                            },
                        @else
                        @foreach ($arr1 as $row)
                            {
                                y: '{{ $row->ten }}',
                                a: {{ ($row->gia * (100 - $row->giamgia)) / 100 }},
                            },
                        @endforeach
                        @endif
                    ],
                    xkey: 'y',
                    ykeys: ['a'],
                    labels: ['Tổng tiền'],
                });

                @php
                    $tuan = DB::select('SELECT * FROM `hoadon` WHERE DATEDIFF(CURDATE(), ngaymua) <=30 AND `tinhtrang`=2');
                    $arr = [];
                @endphp
                @foreach ($tuan as $item)
                    @php
                        $ct = DB::select('SELECT * FROM `cthd` WHERE `idct`=' . $item->id);
                        
                    @endphp
                    @foreach ($ct as $row)
                        @php
                            array_push($arr, $row);
                        @endphp
                    @endforeach
                @endforeach
                @php
                    $arr1 = [];
                    
                    foreach ($arr as $key) {
                        $kt = 0;
                        foreach ($arr1 as $row) {
                            if ($key->ten == $row->ten) {
                                $kt = 1;
                                $row->gia += $key->gia;
                            }
                        }
                        if ($kt == 0) {
                            array_push($arr1, $key);
                        }
                    }
                @endphp

                Morris.Bar({
                    element: 'myfirstchart2',
                    data: [
                        @if (count($arr1)==0)
                            {
                                y:'không có đơn hàng',
                                a:0,
                            },
                        @else
                        @foreach ($arr1 as $row)
                            {
                                y: '{{ $row->ten }}',
                                a: {{ ($row->gia * (100 - $row->giamgia)) / 100 }},
                            },
                        @endforeach
                        @endif
                    ],
                    xkey: 'y',
                    ykeys: ['a'],
                    labels: ['Tổng tiền'],
                });

                @php
                    $tuan = DB::select('SELECT * FROM `hoadon` WHERE DATEDIFF(CURDATE(), ngaymua) <=90 AND `tinhtrang`=2');
                    $arr = [];
                @endphp
                @foreach ($tuan as $item)
                    @php
                        $ct = DB::select('SELECT * FROM `cthd` WHERE `idct`=' . $item->id);
                        
                    @endphp
                    @foreach ($ct as $row)
                        @php
                            array_push($arr, $row);
                        @endphp
                    @endforeach
                @endforeach
                @php
                    $arr1 = [];
                    
                    foreach ($arr as $key) {
                        $kt = 0;
                        foreach ($arr1 as $row) {
                            if ($key->ten == $row->ten) {
                                $kt = 1;
                                $row->gia += $key->gia;
                            }
                        }
                        if ($kt == 0) {
                            array_push($arr1, $key);
                        }
                    }
                @endphp


                Morris.Bar({
                    element: 'myfirstchart3',
                    data: [
                        @if (count($arr1)==0)
                            {
                                y:'không có đơn hàng',
                                a:0,
                            },
                        @else
                        @foreach ($arr1 as $row)
                            {
                                y: '{{ $row->ten }}',
                                a: {{ ($row->gia * (100 - $row->giamgia)) / 100 }},
                            },
                        @endforeach
                        @endif
                    ],
                    xkey: 'y',
                    ykeys: ['a'],
                    labels: ['Tổng tiền'],
                });
            }, 150)
        })
    </script>
    <script>
        var app = angular.module('myapp', [])
        app.controller('adcontroller', function($scope, $rootScope) {
            $scope.ngay = [

                {
                    "name": '-----Tuần gần nhất-----',
                    'value': ''
                },
                {
                    "name": '-----Tháng gần nhất-----',
                    'value': 2
                },
                {
                    "name": '-----3 Tháng gần nhất-----',
                    'value': 3
                },
                {
                    "name": '-----Từ trước tới nay-----',
                    'value': 4
                },
            ]
            $scope.chonngay = ''
            $scope.chart1 = 'hien'
            $scope.chart2 = 'an'
            $scope.chart3 = 'an'
            $scope.chart4 = 'an'
            $scope.anhien = function() {
                if ($scope.chonngay == '') {
                    $scope.chart1 = 'hien'
                    $scope.chart2 = 'an'
                    $scope.chart3 = 'an'
                    $scope.chart4 = 'an'
                }
                if ($scope.chonngay == 2) {
                    $scope.chart1 = 'an'
                    $scope.chart2 = 'hien'
                    $scope.chart3 = 'an'
                    $scope.chart4 = 'an'
                }
                if ($scope.chonngay == 3) {
                    $scope.chart1 = 'an'
                    $scope.chart2 = 'an'
                    $scope.chart3 = 'hien'
                    $scope.chart4 = 'an'
                }
                if ($scope.chonngay == 4) {
                    $scope.chart1 = 'an'
                    $scope.chart2 = 'an'
                    $scope.chart3 = 'an'
                    $scope.chart4 = 'hien'
                }
            }
        })
    </script>
@endsection
