@extends('layout.admin')
@section('title')
    {{ $title }}
@endsection
@section('content')
    <div class="mt-5" ng-controller="dmcontroller">
        <div class="d-flex justify-content-end me-3">
            @php
                $today = date('d/m/Y');
                echo $today;
            @endphp
        </div>
        <div>
            <h1 class="text-center">Quản lý nội dung {{ $title }}</h1>
            <hr size="4">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
           
        </div>
        <div ng-if="edit">
            <button class="btn btn-primary" ng-if="danhmuc" ng-click="them()">Thêm danh mục</button>
        <table class="table" ng-if="danhmuc">
            <thead>
                <tr>
                    <td>STT</td>
                    <td>tên</td>
                    <td>số lượng sản phẩm</td>
                    <td></td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="item in listDanhmuc">
                  
                        <td>@{{ $index + 1 }}</td>
                        <td ng-if="edit">@{{ item.name }}</td>
                        <td>@{{ item.sl }}</td>
                        <td>

                            <a ng-if="edit" ng-click="sua($index)" class="btn btn-outline-warning">Edit</a>
                          
                    </td>

                    <td ng-if="edit">

                        <form action="{{ route('admin.danhmuc.remove') }}" method="post">
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
        <form action="{{ route('admin.danhmuc.edit') }}" method="post">
            @csrf
            <input type="hidden" required class="form-control" name="id" value="@{{id}}">
        <table class="table">
            <tbody>
                <tr>
                    <td>Tên:</td>
                    <td><input type="text" required class="form-control" name="name" value="@{{name}}"></td>
                </tr>
            </tbody>
        </table>
        <a class="btn btn-outline-secondary" ng-click="sua(0)">Quay lại</a>
        <button type="submit" class="btn btn-outline-danger">Xác nhận</button>
    </form>
    </div>
        <div ng-if="!danhmuc">
            <form action="{{ route('admin.danhmuc.add') }}" method="post">
                @csrf
                <table class="table">
                    <tbody>
                        <tr>
                            <td>Tên</td>
                            <td>
                                <input type="text" required name="name" class="form-control"
                                    value="{{ old('name') ? old('name') : '' }}"><br>
                                @error('name')
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
@endsection
@section('js')
    <script>
        var app = angular.module('myapp', [])
        app.controller('dmcontroller', function($scope) {
            $scope.danhmuc = true
            $scope.edit = true
            $scope.sua = function(i) {
                $scope.name=$scope.listDanhmuc[i].name
                $scope.id=$scope.listDanhmuc[i].id
                $scope.edit = !$scope.edit
            }
            $scope.them = function() {
                $scope.danhmuc = !$scope.danhmuc
            }
            $scope.xoa = function(event) {
                if (!confirm(
                        'bạn có muốn xóa nó không\n nếu bạn xóa tất cả các sản phẩm thuộc danh mục cũng sẽ xóa'
                    )) {
                    event.preventDefault();
                }
            }
            $scope.listDanhmuc = [
                @foreach ($listDanhmuc as $item)
                    {
                        'id': {{ $item->id }},
                        'name': '{{ $item->name }}',
                        @php
                            $sl = DB::select('SELECT COUNT(id) as sl FROM `sanpham` WHERE `maloai`=' . $item->id);
                        @endphp 'sl': {{ $sl[0]->sl }},
                    },
                @endforeach
            ]
            @if ($errors->any())
                $scope.danhmuc = false
            @endif
        })
    </script>
@endsection
