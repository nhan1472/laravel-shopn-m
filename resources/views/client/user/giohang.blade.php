@extends('layout.user')
@section('title')
    {{ $title }}
@endsection
@section('content')
    <div class="mt-5">
        <div class="d-flex justify-content-end me-3">
            @php
                $today = date('d/m/Y');
                echo $today;
            @endphp
        </div>
        <hr size="4">
        <div ng-controller="ghcontroller" class="container d-none d-md-block">
            <h1 ng-if="!hien1" class="text-center d-none d-md-block">Xin chào: {{ Auth::user()->name }}</h1>
            <h1 ng-if="!hien1" class="d-none d-md-block">Lịch sử mua hàng</h1>
            <h3 ng-if="!hien1" class="d-block d-md-none">Lịch sử mua hàng</h3>

            <div class="row">
                <div class="col-12">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div ng-if="!hien1">
                        <div class="d-flex flex-row-reverse bd-highlight">
                            <select ng-model="tthd" class="p-2 bd-highlight">
                                <option ng-repeat="item in tt" value="@{{ item.value }}">@{{ item.name }}
                                </option>
                            </select>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Tổng số lượng</th>
                                    {{-- <th ng-if="hien1">chi tiết</th> --}}
                                    <th scope="col">Tông tiền</th>
                                    <th scope="col">Ngày mua</th>
                                    <th scope="col">Tình trạng</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-if="kt" ng-repeat="item in listhoadon | loctt :tthd |limitTo  :page:start">
                                    <td>@{{ $index + 1 }}</td>
                                    <td>@{{ item.tongsl }}</td>
                                    <td ng-if="hien[item.id]">
                                        <div ng-repeat="itemi in cthoadon[item.id]">
                                            <img src="@{{ itemi.img }}" width="50px" height="50px"
                                                alt="@{{ itemi.ten }}">
                                            @{{ itemi.ten }}
                                            giá: @{{ itemi.gia * (100 - itemi.giamgia) / 100 | number }}đ
                                            sl: @{{ itemi.sl }}
                                            size: @{{ itemi.size }}
                                        </div>
                                    </td>
                                    <td>@{{ item.tong | number }}đ</td>
                                    <td>@{{ item.ngaymua | date: 'dd-MM-yyyy HH:mm:ss' }}</td>
                                    <td ng-switch="item.tinhtrang">
                                        <p class="text-warning" ng-switch-when="0">Chờ duyệt
                                        <form action="{{ route('user.huydon') }}" id="huydon" method="post">
                                            @csrf
                                            <input type="hidden" name="id" value="@{{ item.id }}">
                                            <button ng-click="huy($event)" ng-switch-when="0"
                                                class="btn btn-outline-danger">Hủy</button>
                                        </form>
                                        </p>
                                        <p class="text-primary" ng-switch-when="1">Đang giao</p>
                                        <p class="text-success" ng-switch-when="2">Đã Giao</p>
                                        <p class="text-danger" ng-switch-when="3"> Đã Hủy <br>

                                        <p ng-if="hien[item.id]" ng-switch-when="3" class="text-danger"> lý do:
                                            @{{ item.lydo }}</p>
                                        </p>
                                    </td>

                                    <td><a style="cursor: pointer;" ng-click="anhien(item.id)">xem chi tiết</a></td>
                                </tr>
                                <tr ng-if="!kt">
                                    <td colspan="7">
                                        <h1 class="text-center">Không có đơn hàng phù hợp</h1>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <nav aria-label="Page navigation example" class="mt-2">
                            <ul class="pagination">
                                <li class="page-item " ng-repeat="item in listCount" style="cursor: pointer;"><a
                                        class="page-link" ng-class="active[$index]"
                                        ng-click="pageClick(item)">@{{ item }}</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div ng-if="hien1">
                        <br>
                        <h2 class="text-center">Mã hóa đơn : @{{ tenhd }}</h2>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Ngày mua</td>
                                    <td>@{{ ngaymua | date: 'dd-MM-yyyy HH:mm:ss' }}</td>
                                </tr>
                                <tr>
                                    <td>Tình trạng</td>
                                    <td ng-switch="tinhtrang">
                                        <p class="text-warning" ng-switch-when="0">Chờ duyệt
                                        <p class="text-primary" ng-switch-when="1">Đang giao</p>
                                        <p class="text-success" ng-switch-when="2">Đã Giao</p>
                                        <p class="text-danger" ng-switch-when="3"> Đã Hủy <br>

                                        <p ng-switch-when="3" class="text-danger"> lý do:
                                            @{{ lydo }}</p>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-center h3">Chi tiết</td>

                                </tr>
                                <tr ng-repeat="itemi in cthoadon[tenhd]">
                                    <td></td>
                                    <td>
                                        <img src="@{{ itemi.img }}" width="50px" height="50px"
                                            alt="@{{ itemi.ten }}">
                                        @{{ itemi.ten }}
                                        giá: @{{ itemi.gia * (100 - itemi.giamgia) / 100 | number }}đ
                                        sl: @{{ itemi.sl }}
                                        size: @{{ itemi.size }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Số lượng sản phẩm</td>
                                    <td>@{{ sl | number }}</td>
                                </tr>
                                <tr>
                                    <td>Tổng tiền</td>
                                    <td>@{{ tongtien | number }}đ</td>
                                </tr>
                            </tbody>
                        </table>
                        <button class="btn btn-primary"ng-click="anhien(0)">Quay lại</button>
                    </div>
                </div>
            </div>
        </div>
        <div ng-controller="ghcontroller" class="container d-block d-md-none">
            <h1 ng-if="!hien1" class="text-center d-none d-md-block">Xin chào: {{ Auth::user()->name }}</h1>
            <h1 ng-if="!hien1" class="d-none d-md-block">Lịch sử mua hàng</h1>
            <h3 ng-if="!hien1" class="d-block d-md-none">Lịch sử mua hàng</h3>

            <div class="row">
                <div class="col-12">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div ng-if="!hien1">
                        <div class="d-flex flex-row-reverse bd-highlight">
                            <select ng-model="tthd" class="p-2 bd-highlight">
                                <option ng-repeat="item in tt" style="font-size: 15px;" value="@{{ item.value }}">@{{ item.name }}
                                </option>
                            </select>
                        </div>
                        <table class="table" style="font-size: 12px">
                            <thead>
                                <tr>
                                    <th scope="col">STT</th>
                                    {{-- <th scope="col">Tổng số lượng</th> --}}
                                    {{-- <th ng-if="hien1">chi tiết</th> --}}
                                    <th scope="col">Tông tiền</th>
                                    <th scope="col">Ngày mua</th>
                                    <th scope="col">Tình trạng</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-if="kt" ng-repeat="item in listhoadon | loctt :tthd |limitTo  :page:start">
                                    <td>@{{ $index + 1 }}</td>

                                    <td>@{{ item.tong | number }}đ</td>
                                    <td>@{{ item.ngaymua | date: 'dd-MM-yyyy' }}</td>
                                    <td ng-switch="item.tinhtrang">
                                        <p class="text-warning" ng-switch-when="0">Chờ duyệt
                                        <form action="{{ route('user.huydon') }}" id="huydon" method="post">
                                            @csrf
                                            <input type="hidden" name="id" value="@{{ item.id }}">
                                            <button ng-click="huy($event)" ng-switch-when="0"
                                                class="btn btn-outline-danger">Hủy</button>
                                        </form>
                                        </p>
                                        <p class="text-primary" ng-switch-when="1">Đang giao</p>
                                        <p class="text-success" ng-switch-when="2">Đã Giao</p>
                                        <p class="text-danger" ng-switch-when="3"> Đã Hủy <br>

                                        <p ng-if="hien[item.id]" ng-switch-when="3" class="text-danger"> lý do:
                                            @{{ item.lydo }}</p>
                                        </p>
                                    </td>

                                    <td><a style="cursor: pointer;" ng-click="anhien(item.id)">xem chi tiết</a></td>
                                </tr>
                                <tr ng-if="!kt">
                                    <td colspan="7">
                                        <h1 class="text-center">Không có đơn hàng phù hợp</h1>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <nav aria-label="Page navigation example" class="mb-5">
                            <ul class="pagination">
                                <li class="page-item " ng-repeat="item in listCount" style="cursor: pointer;"><a
                                        class="page-link" ng-class="active[$index]"
                                        ng-click="pageClick(item)">@{{ item }}</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div ng-if="hien1">
                        <br>
                        <h2 class="text-center">Mã hóa đơn : @{{ tenhd }}</h2>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Ngày mua</td>
                                    <td >@{{ ngaymua | date: 'dd-MM-yyyy HH:mm:ss' }}</td>
                                </tr>
                                <tr>
                                    <td>Tình trạng</td>
                                    <td ng-switch="tinhtrang">
                                        <p class="text-warning" ng-switch-when="0">Chờ duyệt
                                        <p class="text-primary" ng-switch-when="1">Đang giao</p>
                                        <p class="text-success" ng-switch-when="2">Đã Giao</p>
                                        <p class="text-danger" ng-switch-when="3"> Đã Hủy <br>

                                        <p ng-switch-when="3" class="text-danger"> lý do:
                                            @{{ lydo }}</p>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-center h3">Chi tiết</td>

                                </tr>
                                <tr ng-repeat="itemi in cthoadon[tenhd]">
                                    <td></td>
                                    <td>
                                        <img src="@{{ itemi.img }}" width="50px" height="50px"
                                            alt="@{{ itemi.ten }}">
                                        @{{ itemi.ten }}
                                        giá: @{{ itemi.gia * (100 - itemi.giamgia) / 100 | number }}đ
                                        sl: @{{ itemi.sl }}
                                        size: @{{ itemi.size }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Số lượng sản phẩm</td>
                                    <td>@{{ sl | number }}</td>
                                </tr>
                                <tr>
                                    <td>Tổng tiền</td>
                                    <td>@{{ tongtien | number }}đ</td>
                                </tr>
                            </tbody>
                        </table>
                        <button class="btn btn-primary mb-5"ng-click="anhien(0)">Quay lại</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        var app = angular.module('myapp', [])
        app.filter('loctt', function($rootScope) {
            return function(input, ts1) {
                var out = []

                if (ts1 == '') {
                    if (input.length == 0) {
                        $rootScope.kt = false
                    } else {
                        $rootScope.kt = true
                    }
                    return input

                }
                for (i = 0; i < input.length; i++) {
                    if (input[i].tinhtrang == ts1) {
                        out.push(input[i])
                    }
                }
                if (out.length == 0) {
                    $rootScope.kt = false
                } else {
                    $rootScope.kt = true
                }

                return out
            }
        })
        app.controller('ghcontroller', function($scope, $rootScope) {
            $scope.huy = function(event) {
                if (!confirm('bạn có muốn huy không ')) {
                    event.preventDefault();
                }
            }
            $rootScope.listhoadon = [
                @foreach ($listHoadon as $item)
                    {
                        'id': {{ $item->id }},
                        'tongsl': {{ $item->tongsl }},
                        'tong': {{ $item->tong }},
                        'ngaymua': new Date('{{ $item->ngaymua }}'),
                        'tinhtrang': {{ $item->tinhtrang }},
                        'lydo': '{{ $item->lydo }}',
                    },
                @endforeach
            ]
            $rootScope.kt = true
            $rootScope.cthoadon = []
            $scope.hien = []
            $scope.hien1 = false
            $scope.ktct = true
            $scope.anhien = function(i) {
                // if ($scope.hien[i] == true) {
                //     $scope.hien[i] = false
                // } else {
                //     $scope.hien[i] = true
                // }
                $scope.idhd = i
                for (i = 0; i < $scope.listhoadon.length; i++) {
                    if ($scope.idhd == $scope.listhoadon[i].id) {
                        $scope.tenhd = $scope.listhoadon[i].id
                        $scope.sl = $scope.listhoadon[i].tongsl
                        $scope.tongtien = $scope.listhoadon[i].tong
                        $scope.ngaymua = $scope.listhoadon[i].ngaymua
                        $scope.tinhtrang = $scope.listhoadon[i].tinhtrang
                        $scope.lydo = $scope.listhoadon[i].lydo
                    }
                }
                $scope.hien1 = !$scope.hien1
            }
            $scope.tthd = ''
            $scope.tt = [{
                    value: '',
                    name: '---Mặc Định---',
                },
                {
                    value: 0,
                    name: 'Đang duyệt',
                },
                {
                    value: 1,
                    name: 'Đang dao',
                },
                {
                    value: 2,
                    name: 'Đã dao',
                },
                {
                    value: 3,
                    name: 'Đã hủy',
                },
            ]
            @foreach ($listHoadon as $index => $row)
                @php
                    $cthd = DB::select('SELECT * FROM `cthd` WHERE `idct`=' . $row->id);
                @endphp
                $rootScope.cthoadon[{{ $row->id }}] = [
                    @foreach ($cthd as $rowas)
                        {
                            'ten': '{{ $rowas->ten }}',
                            'img': '{{ $rowas->img }}',
                            'gia': {{ $rowas->gia }},
                            'giamgia': {{ $rowas->giamgia }},
                            'sl': {{ $rowas->sl }},
                            'size': '{{ $rowas->size }}',
                        },
                    @endforeach
                ]
            @endforeach
            $rootScope.start = 0
            $rootScope.page = 10
            $rootScope.listCount = []
            $rootScope.count = Math.ceil($scope.listhoadon.length / $rootScope.page)
            for (i = 1; i <= $rootScope.count; i++) {
                $rootScope.listCount.push(i)
            }
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
        })
    </script>
@endsection
