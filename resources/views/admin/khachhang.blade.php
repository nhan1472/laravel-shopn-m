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
        <div>
            <table class="table">
                <thead>
                    <th>STT</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>SDT</th>
                    <th>Địa chỉ</th>
                    <Th>Ngày đăng ký</Th>
                    <Th>Số lần mua hàng</Th>
                </thead>
                <tbody>

                    <tr ng-repeat="item in listuser |limitTo  :page:start"">
                            <td>@{{ $index + 1 }}</td>
                            <td>@{{ item.name }}</td>
                            <td>@{{ item.email }}</td>
                            <td>@{{ item.ct.sdt }}</td>
                            <td>@{{ item.ct.diachi }}</td>
                            <td>@{{ item.ngaydk }}</td>
                            <td>mua:@{{ item.slmua.mua }}
                            <br>hủy:@{{ item.slmua.huy }}</td>
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
    </div>
@endsection
@section('js')
    <script>
        var app = angular.module('myapp', [])
        app.controller('sizecontroller', function($scope, $rootScope) {
            $scope.listuser = [
                @foreach ($listUser as $index => $item)
                    {
                        'id': {{ $item->id }},
                        'name': '{{ $item->name }}',
                        'email': '{{ $item->email }}',
                        'ngaydk': '{{ $item->created_at }}',
                        @php
                            $userct = DB::select('SELECT * FROM `ctusers` WHERE iduser= ' . $item->id);
                            $sl = DB::select('SELECT COUNT(id) as sl FROM `hoadon` WHERE tinhtrang!=3 AND idkh= ' . $item->id);
                            $slh = DB::select('SELECT COUNT(id) as sl FROM `hoadon` WHERE tinhtrang=3 AND idkh= ' . $item->id);
                        @endphp 'ct': {
                            @if ($userct)
                                @foreach ($userct as $row)
                                    'diachi': '{{ $row->daichi }}',
                                    'sdt': '{{ $row->sdt }}',
                                @endforeach
                            @else
                                'diachi': 'Chưa cập nhật',
                                'sdt': 'Chưa cập nhật',
                            @endif

                        },
                        'slmua': {
                            'mua': {{ $sl[0]->sl }},
                            'huy': {{ $slh[0]->sl }},
                        }
                    },
                @endforeach
            ]
            $rootScope.start = 0
            $rootScope.page = 10
            $rootScope.listCount = []
            $rootScope.count = Math.ceil($scope.listuser.length / $rootScope.page)
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
        })
    </script>
@endsection
