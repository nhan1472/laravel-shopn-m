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
        <div class="row">        
            <div class="col-2">
                Lọc:
            </div>
            <div class="col-2"></div>
            <div class="col-4"><input type="text" ng-model="seach" class="form-control" placeholder="nhâp tên cần tìm"></div>
            <div class="col-2 form-check text-center d-flex form-switch align-items-center">
            <input type="checkbox" ng-model="giamgia" ng-change="ktdm()" class="form-check-input"
                style="height: 30px;cursor: pointer;">
            <p class="">Giảm giá</p>

        </div>
    </div>

        <div ng-if="thaydoi">
            <table class="table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên </th>
                        <th>Giảm giá</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="item in listitem |seachname :seach |locgiamgia :giamgia |limitTo  :page:start">
                        <td>@{{ $index + 1 }}</td>
                        <td>@{{ item.ten }}</td>
                        <td>@{{ item.giamgia }}</td>
                        <td><a ng-click="thaydoisale(item.id)" class="btn btn-danger">Thay đỗi</a>
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
        <div ng-if="!thaydoi">
            <a ng-click="thaydoisale(0)" class="btn btn-secondary">Quay lại</a>
            <form action="{{ route('admin.sale.add') }}" method="post">
                @csrf
                <input type="hidden" name="id" value="@{{idsp}}">
            <table class="table">
                <tbody>
                    <tr>
                        <td>Giam giá</td>
                        <td><input type="number" class="form-control" name="giamgia" value="@{{giamgia}}">
                        <br>
                        @error('giamgia')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror</td>
                    </tr>
                </tbody>
            </table>
            <button class="btn btn-primary">Cập nhật</button>
        </form>
        </div>
    </div>
@endsection
@section('js')
    <script>
        var app = angular.module('myapp', [])
        app.filter('seachname', function($rootScope) {
            return function(input, ts1) {
                input = input.filter(item => item.ten.toLowerCase().indexOf(ts1.toLowerCase()) !== -1)
                $rootScope.listCount = []
                $rootScope.count = Math.ceil(input.length / $rootScope.page)
                for (i = 1; i <= $rootScope.count; i++) {
                    $rootScope.listCount.push(i)
                }
                return input;
            }
        })
        app.filter('locgiamgia', function($rootScope) {
            return function(input, ts1) {
                if (ts1 != true) {
                    return input
                }  
                var output = []
                for (i = 0; i < input.length; i++) {
                    if (input[i].giamgia > 0) {
                        output.push(input[i])
                    }
                }
                $rootScope.listCount = []
                $rootScope.count = Math.ceil(output.length / $rootScope.page)
                for (i = 1; i <= $rootScope.count; i++) {
                    $rootScope.listCount.push(i)
                }
                return output
            }
        })
        app.controller('sizecontroller', function($scope, $rootScope) {
            $scope.listitem = [
                @foreach ($listSanpham as $item)
                    {
                        'id': {{ $item->id }},
                        'ten': '{{ $item->ten }}',
                        'giamgia': {{ $item->giamgia }},
                    },
                @endforeach
            ]
            $scope.seach=''
            $scope.thaydoi = true
            $rootScope.start = 0
            $rootScope.page = 10
            $rootScope.listCount = []
            $rootScope.count = Math.ceil($scope.listitem.length / $rootScope.page)
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
            @if ($errors->any())
                $scope.thaydoi = false
            @endif
            $scope.thaydoisale = function(i) {
                $scope.idsp=i
                $scope.listitem.forEach(e=>{
                    if(e.id==$scope.idsp)
                    {
                        $scope.giamgia=e.giamgia
                    }
                })
                $scope.thaydoi = !$scope.thaydoi
            }
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
        })
    </script>
@endsection
