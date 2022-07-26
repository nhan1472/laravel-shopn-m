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
        <div ng-if="them">
            <div class="row">
                <div class="col-2">
                    <button class="btn btn-primary" ng-click="nhanvien()">Thêm nhân viên</button>
                </div>
            </div>
            <table class="table">
                <thead>
                    <th>STT</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>SDT</th>
                    <th>Địa chỉ</th>
                    <Th>Ngày đăng ký</Th>
                    <th>đơn đã duyệt</th>
                </thead>
                <tbody>

                    <tr ng-repeat="item in listuser |limitTo  :page:start"">
                                        <td>@{{ $index + 1 }}</td>
                                        <td>@{{ item.name }}</td>
                                        <td>@{{ item.email }}</td>
                                        <td>@{{ item.ct.sdt }}</td>
                                        <td>@{{ item.ct.diachi }}</td>
                                        <td>@{{ item.ngaydk }}</td>
                                        <td>duyệt: @{{ item.slmua }}
                                        <br>hủy:@{{ item.slmua1 }}</td>
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
        <div ng-if="!them">
            <button class="btn btn-secondary" ng-click="nhanvien()">Quay lại</button>
            <form method="POST" action="{{ route('admin.register') }}">
                @csrf

                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Họ và Tên') }}</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name') }}" required autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Mật khẩu') }}</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <input id="password" type="hidden" class="form-control1" name="job" value="2">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password-confirm"
                        class="col-md-4 col-form-label text-md-end">{{ __('Nhập lại mật khẩu') }}</label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                            required autocomplete="new-password">
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Thêm ') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script>
        var app = angular.module('myapp', [])
        app.controller('sizecontroller', function($scope, $rootScope) {
            $scope.them = true
            $scope.nhanvien = function() {
                $scope.them = !$scope.them
            }
            $scope.listuser = [
                @foreach ($listUser as $index => $item)
                    {
                        'id': {{ $item->id }},
                        'name': '{{ $item->name }}',
                        'email': '{{ $item->email }}',
                        'ngaydk': '{{ $item->created_at }}',
                        @php
                            $userct = DB::select('SELECT * FROM `ctusers` WHERE iduser= ' . $item->id);
                            $sl = DB::select('SELECT COUNT(id) as sl FROM `hoadon` WHERE tinhtrang!=3 AND idnv= ' . $item->id);
                            $sl1 = DB::select('SELECT COUNT(id) as sl FROM `hoadon` WHERE tinhtrang=3 AND idnv= ' . $item->id);
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
                        'slmua': {{ $sl[0]->sl }},
                        'slmua1': {{ $sl1[0]->sl }}
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
            @if ($errors->any())
                $scope.them = false
            @endif
        })
    </script>
@endsection
