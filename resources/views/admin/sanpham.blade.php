@extends('layout.admin')
@section('title')
    {{ $title }}
@endsection
@section('content')
    <div class="mt-5" ng-controller="spcontroller">
        <div class="d-flex justify-content-end me-3">
            @php
                $today = date('d/m/Y');
                echo $today;
            @endphp
        </div>
        <div>
            <h1 class="text-center">Quản lý nội dung {{ $title }}</h1>
            <hr size="4">
        </div>
        <div ng-if="xemsp">
            <div ng-if="sanpham">
                <div class="row">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @php
                        $sl = DB::select('SELECT COUNT(id)as sl FROM `sanpham`');
                    @endphp
                    <div class="col-2">Tổng: có {{ $sl[0]->sl }} sản phẩm</div>
                    <div class="col-2">Lọc:</div>
                    <div class="col-2">
                        <input type="text" placeholder="Tìm kiếm tên..." class="form-control" ng-model="seach">
                    </div>
                    <div class="col-2">
                        <select ng-model="locdanhmuc" ng-change="ktdm()" class="form-control">
                            <option ng-repeat="item in danhmuc" value="@{{ item.id }}">@{{ item.name }}
                            </option>
                        </select>
                    </div>
                    <div class="col-2 form-check text-center d-flex form-switch align-items-center">
                        <input type="checkbox" ng-model="giamgia" ng-change="ktdm()" class="form-check-input"
                            style="height: 30px;cursor: pointer;">
                        <p class="">Giảm giá</p>

                    </div>
                    <div class="col-2">
                        <select ng-model="locsize" ng-change="ktdm()" class="form-control">
                            <option ng-repeat="item in size" value="@{{ item.id }}">@{{ item.name }}</option>
                        </select>
                    </div>
                </div>
                <button ng-click="them()" class="btn btn-primary">Thêm mới sản phẩm</button>
                <table class="table">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên</th>
                            <th>Ảnh</th>
                            <th>Giá</th>
                            <th>Giảm Giá</th>
                            <th>Danh mục</th>
                            <th>Size</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            ng-repeat="item in listitem |seachname:seach|locdm:locdanhmuc|locgiamgia:giamgia|locs:locsize:sizect|limitTo  :page:start">
                            <td>@{{ $index + 1 }}</td>
                            <td>@{{ item.ten }}</td>
                            <td>
                                <img src="@{{ item.img }}" width="50px" height="50px" alt="@{{ item.ten }}">
                            </td>
                            <td>@{{ item.gia | number }} đ</td>
                            <td>@{{ item.giamgia }}%</td>
                            <td>@{{ item.danhmuc.name }}</td>
                            <td>
                                <div class="d-flex">
                                    <p ng-repeat="i in item.size">
                                        @{{ i }}.
                                    </p>
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-outline-primary" ng-click="xem(item.id)">Xem</button>
                                <form action="{{ route('admin.sanpham.edit') }}" method="get">
                                    @csrf
                                    <input type="hidden" name="id" value="@{{ item.id }}">
                                    <button type="submit" class="btn btn-outline-warning">edit</button>
                                </form>
                                <form action="{{ route('admin.sanpham.remove') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="@{{ item.id }}">
                                    <button class="btn btn-outline-danger" ng-click="xoa($event)">X</button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <nav aria-label="Page navigation example" class="mt-2">
                    <ul class="pagination">
                        <li class="page-item " ng-repeat="item in listCount" style="cursor: pointer;"><a
                                class="page-link" ng-class="active[$index]" ng-click="pageClick(item)">@{{ item }}</a></li>
                    </ul>
                </nav>
            </div>
            <div ng-if="!sanpham" class="my-5">
                <form action="{{ route('admin.sanpham.add') }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <table class="table">
                        <tr>
                            <td>Tên</td>
                            <td><input type="text" name="name" class="form-control">
                                <br>
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td>Ảnh</td>
                            <td><input type="file" name="img" class="form-control">
                                <br>
                                @error('img')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Nội dung:
                            </td>
                            <td>
                                <textarea name="noidung" id="noidung" rows="10" cols="80">
                                </textarea>
                                <script>
                                    CKEDITOR.replace('noidung');
                                </script>
                                <br>
                                @error('noidung')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td>Giá</td>
                            <td><input type="number" min="0" name="gia" class="form-control">
                                <br>
                                @error('gia')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td>Danh mục</td>
                            <td>
                                <select name="danhmuc" class="form-control">
                                    <option ng-repeat="item in danhmuc" value="@{{ item.id }}">
                                        @{{ item.name }}
                                    </option>
                                </select>
                                <br>
                                @error('danhmuc')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td>Size</td>
                            <td>
                                <div class="d-flex">
                                    <p ng-repeat="item in listsizechon">@{{ item.name }} <a
                                            ng-click="xoasize($index)" class="btn btn-outline-danger">X</a></p>
                                </div>
                                <select name="size" ng-model="sizesp" ng-change="chonsize(sizesp)" class="form-control">
                                    <option ng-repeat="item in size" value="@{{ item.id }}">@{{ item.name }}
                                    </option>
                                </select>
                                <br>
                                @error('size')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </td>
                        </tr>
                    </table>
                    <a ng-click="them()" class="btn btn-secondary">Quay lại</a>
                    <button type="submit" class="btn btn-danger">Thêm</button>
                </form>

            </div>
        </div>
        <div ng-if="!xemsp">

            <div class="row my-5">
                <div class="col-6 border-end">
                    <img src="@{{ ctsp.img }}" alt="@{{ ctsp.ten }}" width="100%" height="400px">
                </div>
                <div class="col-6">
                    <h2 class="text-center">@{{ ctsp.ten }}</h2>
                    <hr size="4" class="my-2">
                    <h4>các size:</h4>
                    <div ng-repeat="item in ctsp.size">@{{ item }}</div>
                    <h4>thuộc loại : @{{ ctsp.danhmuc.name }}</h4>
                    <h4>Lược xem : @{{ ctsp.luotxem }}</h4>
                    <h4 class="text-danger">
                        Giá:@{{ ctsp.gia | number }}đ <br>
                        Giảm Giá :@{{ ctsp.giamgia }}%
                    </h4>
                </div>

            </div>
            <a class="btn btn-secondary" ng-click="xem(0)">Quay lại</a>
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
        app.filter('locdm', function($rootScope) {
            return function(input, ts1) {
                var output = []
                for (i = 0; i < input.length; i++) {
                    if (input[i].danhmuc.id == ts1) {
                        output.push(input[i])
                    }
                }
                $rootScope.listCount = []
                $rootScope.count = Math.ceil(input.length / $rootScope.page)
                for (i = 1; i <= $rootScope.count; i++) {
                    $rootScope.listCount.push(i)
                }
                if (ts1 == '') {
                    return input
                }
                return output
            }
        })
        app.filter('locs', function($rootScope) {
            return function(input, ts1, ts2) {
                var out = []

                for (i = 0; i < input.length; i++) {
                    for (j = 0; j < ts2.length; j++) {
                        if (ts2[j].idsize == ts1 && ts2[j].idsp == input[i].id) {
                            out.push(input[i])
                        }
                    }
                }
                $rootScope.listCount = []
                $rootScope.count = Math.ceil(input.length / $rootScope.page)
                for (i = 1; i <= $rootScope.count; i++) {
                    $rootScope.listCount.push(i)
                }
                if (ts1 == '') {
                    return input
                }
                return out
            }
        })
        app.filter('locgiamgia', function($rootScope) {
            return function(input, ts1) {
                if (ts1 == false) {
                    return input
                }
                $rootScope.listCount = []
                $rootScope.count = Math.ceil(input.length / $rootScope.page)
                for (i = 1; i <= $rootScope.count; i++) {
                    $rootScope.listCount.push(i)
                }
                var output = []
                for (i = 0; i < input.length; i++) {
                    if (input[i].giamgia > 0) {
                        output.push(input[i])
                    }
                }
                return output
            }
        })
        app.controller('spcontroller', function($scope, $rootScope) {
            $scope.giamgia = false
            $scope.xemsp = true
            $scope.sanpham = true
            @if ($errors->any())
                $scope.sanpham = false
            @endif
            $rootScope.listitem = [
                @foreach ($listSanpham as $item)
                    {
                        'id': {{ $item->id }},
                        'ten': '{{ $item->ten }}',
                        'img': '{{ asset($item->img) }}',
                        'luotxem': '{{ $item->luotxem }}',

                        'gia': {{ $item->gia }},
                        'giamgia': {{ $item->giamgia }},
                        @php
                            $dm = DB::select('SELECT * FROM `loaisp` WHERE `id`=?', [$item->maloai]);
                            $sizect = DB::select('SELECT * FROM `sizect` WHERE `idsp`=?', [$item->id]);
                        @endphp 'danhmuc': {
                            'name': '{{ $dm[0]->name }}',
                            'id': {{ $dm[0]->id }},
                        },
                        'size': [
                            @foreach ($sizect as $row)
                                @php
                                    $size = DB::select('SELECT * FROM `size` WHERE `id`=?', [$row->idsize]);
                                @endphp
                                    '{{ $size[0]->size }}',
                            @endforeach
                        ]
                    },
                @endforeach
            ]
            $scope.locdanhmuc = ''
            $scope.danhmuc = [{
                    'id': '',
                    'name': '-----Danh mục-----'
                },
                @foreach ($listLoai as $item)
                    {
                        'id': {{ $item->id }},
                        'name': '{{ $item->name }}'
                    },
                @endforeach
            ]
            $scope.locsize = ''
            $scope.size = [{
                    'id': '',
                    'name': '-----Size-----'
                },
                @foreach ($listSize as $item)
                    {
                        'id': {{ $item->id }},
                        'name': '{{ $item->size }}'
                    },
                @endforeach
            ]
            $scope.sizect = [
                @foreach ($listsizect as $item)
                    {
                        'id': {{ $item->id }},
                        'idsp': {{ $item->idsp }},
                        'idsize': {{ $item->idsize }},
                    },
                @endforeach
            ]
            $rootScope.start = 0
            $rootScope.page = 6shopn
            $rootScope.listCount = []
            $rootScope.count = Math.ceil($rootScope.listitem.length / $rootScope.page)
            for (i = 1; i <= $rootScope.count; i++) {
                $rootScope.listCount.push(i)
            }
            $scope.active=[]
            $scope.idpage=0
            $scope.active[0]='pageactive'
            $rootScope.pageClick = function(i) {
                $rootScope.start = (i - 1) * $rootScope.page
                $scope.idpage=i-1
                for(i=0;i<$rootScope.listCount.length;i++)
                {
                    if(i==$scope.idpage)
                    {
                        $scope.active[i]='pageactive'
                    }
                    else{
                        $scope.active[i]=''
                    }
                }
            }
            $rootScope.ktdm = function() {
                $rootScope.ktdm = function() {
                for(i=0;i<$rootScope.listCount.length;i++)
                {
                    if(i==0)
                    {
                        $scope.active[i]='pageactive'
                    }
                    else{
                        $scope.active[i]=''
                    }
                }
                if ($rootScope.start > 0) {
                    $rootScope.start = 0
                   
                }
            }
            }
            $scope.seach = ''
            $scope.xoa = function(event) {
                if (!confirm('bạn có muốn xóa không')) {
                    event.preventDefault();
                }
            }
            $scope.them = function() {
                $scope.sanpham = !$scope.sanpham
            }
            $scope.listsizechon = []
            $scope.sizesp = ''
            $scope.chonsize = function(a) {
                if (a != '') {
                    for (i = 0; i < $scope.size.length; i++) {
                        if ($scope.size[i].id == a) {
                            $scope.listsizechon.push($scope.size[i])
                        }
                    }

                }
            }
            $scope.xoasize = function(i) {
                $scope.listsizechon.splice(i, 1)
            }
            $scope.xem = function(i) {
                $scope.xemsp = !$scope.xemsp
                $scope.idctsp = i
                $scope.listitem.forEach(e => {
                    if (e.id == $scope.idctsp) {
                        $scope.ctsp = {
                            'id': e.id,
                            'ten': e.ten,
                            'img': e.img,
                            'luotxem': e.luotxem,
                            'gia': e.gia,
                            'giamgia': e.giamgia,
                            'danhmuc': e.danhmuc,
                            'size': e.size
                        }
                    }
                })

            }

        })
    </script>
@endsection
