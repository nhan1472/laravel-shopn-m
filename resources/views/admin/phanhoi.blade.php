@extends('layout.admin')
@section('title')
    {{ $title }}
@endsection
@section('content')
    <div class="mt-5" ng-controller="adcontroller">
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
        <div ng-if="phanhoi">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <table class="table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Nội dung</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="item in listPhanhoi |limitTo  :page:start">
                        <td>@{{ $index + 1 }}</td>
                        <td>@{{ item.name }}</td>
                        <td>@{{ item.email }}</td>
                        <td>@{{ item.noidung }}</td>
                        <td>
                            <button ng-if="item.tinhtrang==0" class="btn btn-primary" ng-click="traloi(item.email,item.name,item.id)">Trả lời</button>
                            <button ng-if="item.tinhtrang==1" class="btn btn-primary" disabled> Đã trả lời</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <nav aria-label="Page navigation example" class="mt-2">
                <ul class="pagination">
                    <li class="page-item " ng-repeat="item in listCount" style="cursor: pointer;"><a class="page-link"
                            ng-class="active[$index]" ng-click="pageClick(item)">@{{ item }}</a></li>
                </ul>
            </nav>
        </div>
        <div ng-if="!phanhoi">
            <div class="row">
                <div class="col-12">
                    <button class="btn btn-secondary" ng-click="traloi(0)">Quay lại</button>
                </div>
                <div class="col-12">
                    <h2 class="text-center">Trả lời email: @{{ email }}</h2>
                    <form action="{{ route('admin.phanhoi.traloi') }}" ng-submit="gui()" method="post">
                        @csrf
                        <input type="hidden" name="email" value="@{{ email }}">
                        <input type="hidden" name="name" value="@{{ name }}">
                        <input type="hidden" name="id" value="@{{ id }}">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Nội dung</td>
                                    <td>
                                        <textarea name="noidung" required rows="10" style="width: 100%"></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button ng-if="kt==0"  class="btn btn-primary">Gửi</button>
                        <button ng-if="kt==1" disabled="disabled" class="button cart_button_checkout">
                            <div class="spinner-border text-primary mt-2" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        var app = angular.module('myapp', [])
        app.controller('adcontroller', function($scope, $rootScope) {
            $scope.listPhanhoi = [
                @foreach ($listPhoi as $item)
                    {
                        'id': {{ $item->id }},
                        'name': '{{ $item->name }}',
                        'email': '{{ $item->email }}',
                        'noidung': '{{ $item->noidung }}',
                        'tinhtrang': {{ $item->tinhtrang }},
                    },
                @endforeach
            ]
            $scope.phanhoi = true
            $rootScope.start = 0
            $rootScope.page = 10
            $rootScope.listCount = []
            $rootScope.count = Math.ceil($scope.listPhanhoi.length / $rootScope.page)
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
            $scope.kt=0
            $scope.gui = function()
            {
                $scope.submitted = true;
                $scope.kt=1
            }
            $scope.traloi = function(i,j,k) {
                $scope.phanhoi = !$scope.phanhoi
                $scope.email = i
                $scope.name = j
                $scope.id = k
            }
        })
    </script>
@endsection
