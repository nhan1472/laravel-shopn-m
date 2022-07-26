@extends('layout.admin')
@section('title')
    {{ $title }}
@endsection
@section('content')
    <div class="mt-5" ng-controller="sizecontroller">

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
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('success1'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('success1') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div ng-if="xem">
            <div ng-if="edit">
                <button class="btn btn-primary" ng-if="danhmuc" ng-click="them()">Thêm Size</button>
                <table class="table" ng-if="danhmuc">
                    <thead>
                        <tr>
                            <td>STT</td>
                            <td>Size</td>
                            <td>Số lượng sp</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="item in listSize">
                            <td>@{{ $index + 1 }}</td>
                            <td>@{{ item.size }}</td>
                            <td>@{{ item.sl }}</td>
                            <td>
                                <a ng-if="edit" ng-click="xemct(item.id)" class="btn btn-outline-primary">Xem chi tiết</a>
                            </td>
                            <td>
                                <a ng-if="edit" ng-click="sua($index)" class="btn btn-outline-warning">Edit</a>
                            </td>
                            <td>
                                <form action="{{ route('admin.size.remove') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="@{{ item.id }}">
                                    <button class="btn btn-outline-danger" ng-click="xoa($event)">X</button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div ng-if="!edit">
                <form action="{{ route('admin.size.edit') }}" method="post">
                    @csrf
                    <input type="hidden" required class="form-control" name="id" value="@{{ id }}">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Tên:</td>
                                <td><input type="text" required class="form-control" name="name"
                                        value="@{{ name }}"></td>
                            </tr>
                        </tbody>
                    </table>
                    <a class="btn btn-outline-secondary" ng-click="sua(0)">Quay lại</a>
                    <button type="submit" class="btn btn-outline-danger">Xác nhận</button>

                </form>
            </div>
            <div ng-if="!danhmuc">
                <form action="{{ route('admin.size.add') }}" method="post">
                    @csrf
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Tên</td>
                                <td>
                                    <input type="text" required name="size" class="form-control"
                                        value="{{ old('name') ? old('name') : '' }}"><br>
                                    @error('size')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <a class="btn btn-secondary" ng-if="!danhmuc" ng-click="them()">Quay lại</a>
                    <button class="btn btn-danger" ng-if="!danhmuc" type="submit">Thêm</button>
                </form>
            </div>

        </div>
        <div ng-if="!xem">
            <div ng-if="thems">
                <a ng-click="xemct()" class="btn btn-outline-secondary">Quay lại</a>
                <a ng-click="themsp()" class="btn btn-outline-primary">Thêm sản phẩm</a>
                <table class="table">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="item in listsp">
                            <td>@{{ $index + 1 }}</td>
                            <td>@{{ item.ten }}</td>
                            <td>
                                <form action="{{ route('admin.size.removesp') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="idsp" value="@{{ item.id }}">
                                    <input type="hidden" name="idsize" value="@{{ idctsp }}">
                                    <button class="btn btn-outline-danger" ng-click="xoasp($event)">X</button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div ng-if="!thems">
                <form action="{{ route('admin.size.addct') }}" method="post">
                    @csrf
                <table class="table">
                    <tbody>
                        <tr>
                           <input type="hidden" name="idsize" value="@{{idctsp}}">
                            <td>Sản phẩm</td>
                            <td>
                                <select name="idsp" id="">
                                    <option ng-repeat="item in listsanpham |loc:listsp" class="form-control" value="@{{item.id}}">@{{item.ten}}</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <a ng-click="themsp()" class="btn btn-outline-secondary">Quay lại</a>
                <button type="submit" class="btn btn-outline-danger">Thêm</button>
            </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        var app = angular.module('myapp', [])
        app.filter('loc', function($rootScope) {
            return function(input,ts1) {
                var out=[]
                for(i=0;i<input.length;i++)
                {   
                    kt=0
                    for(j=0;j<ts1.length;j++)
                    {
                        if(input[i].id==ts1[j].id)
                        {
                            kt=1
                        }
                    }
                    if(kt==0)
                    {
                        out.push(input[i])
                    }
                }
                return out
            }
        })
        app.controller('sizecontroller', function($scope) {
            $scope.danhmuc = true
            $scope.thems = true
            $scope.edit = true
            $scope.sua = function(i) {
                $scope.name = $scope.listSize[i].size
                $scope.id = $scope.listSize[i].id
                $scope.edit = !$scope.edit
            }
            $scope.them = function() {
                $scope.danhmuc = !$scope.danhmuc
            }
            $scope.listSize = [
                @foreach ($listSize as $item)
                    {
                        'id': {{ $item->id }},
                        'size': '{{ $item->size }}',
                        @php
                            $sl = DB::select('SELECT COUNT(id) as sl FROM `sizect` WHERE idsize= ?', [$item->id]);
                            $sp = DB::select('SELECT * FROM `sizect` WHERE idsize= ?', [$item->id]);
                        @endphp 'sl': {{ $sl[0]->sl }},
                        'sp': [
                            @foreach ($sp as $row)
                                @php
                                    $spct = DB::select('SELECT * FROM `sanpham` WHERE id= ?', [$row->idsp]);
                                @endphp {
                                    'id': {{ $spct[0]->id }},
                                    'ten': '{{ $spct[0]->ten }}',
                                },
                            @endforeach
                        ]
                    },
                @endforeach
            ]

            @if ($errors->any())
                $scope.danhmuc = false
            @endif
            $scope.xoa = function(event) {
                if (!confirm(
                        'bạn có muốn xóa nó không\n nếu bạn xóa tất cả các sản phẩm thuộc Size cũng sẽ xóa')) {
                    event.preventDefault();
                }
            }
            $scope.xoasp = function(event) {
                if (!confirm(
                        'bạn có muốn xóa nó không')) {
                    event.preventDefault();
                }
            }
            $scope.xem = true
            $scope.listsp = []
            $scope.xemct = function(i) {
                $scope.xem = !$scope.xem
                $scope.idctsp = i
                $scope.listSize.forEach(e => {
                    if (e.id == $scope.idctsp) {
                        $scope.listsp = e.sp
                    }
                })
            }
            $scope.themsp = function()
            {
                $scope.thems=!$scope.thems
            }
            @php
                $listsanpham =  DB::select('SELECT * FROM `sanpham`');
            @endphp
            $scope.listsanpham=[
                @foreach ($listsanpham as $item)
                {
                    
                    'id':{{$item->id}},
                    'ten':'{{$item->ten}}',
                },
                @endforeach
            
               
            ]
        })  
    </script>
@endsection
