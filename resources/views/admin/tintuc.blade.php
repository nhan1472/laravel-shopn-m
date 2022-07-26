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
            <div ng-show="them">
                <button class="btn btn-primary" ng-click="themtt()">Thêm tin tức</button>
                <select ng-model="loaitt" class="form-control" ng-change="ktdm()">
                    <option ng-repeat="item in listtt" value="@{{ item.value }}">@{{ item.name }}</option>
                </select>
                <table class="table">
                    <thead>
                        <th>STT</th>
                        <th>Tiêu đề</th>
                        <th>Ảnh đại diện</th>
                        <th>Tóm tất</th>
                        <th>Lượt xem</th>
                    </thead>
                    <tbody>
                        <tr ng-repeat="item in listTin |loctt :loaitt |limitTo  :page:start">
                            <td>@{{ $index + 1 }}</td>
                            <td>@{{ item.title }}</td>
                            <td><img src="@{{ item.img }}" width="100px" height="50px" alt="@{{ item.tieude }}">
                            </td>
                            <td>
                                <p>@{{ item.tomtat }}</p>
                            </td>
                            <td>@{{ item.luotxem }}</td>
                            <td>
                                <form action="{{ route('admin.tintuc.xem') }}" method="get">
                                    <input type="hidden" name="id" value="@{{ item.id }}">
                                    <button type="submit" class="btn btn-primary" href="">Xem
                                    </button>
                                </form>
                            </td>

                            <td>
                                <form action="{{ route('admin.tintuc.xoa') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="@{{ item.id }}">
                                    <button type="submit" class="btn btn-danger" ng-click="xoa($event)">Xoa</button>
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
            <div ng-if="!them">
                <form action="{{ route('admin.tintuc.add') }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Tiêu đề</td>
                                <td><input type="text" required class="form-control" name="tieude"></td>
                            </tr>
                            <tr>
                                <td>Tóm tắt</td>
                                <td><input type="text" required class="form-control" name="tomtat"></td>
                            </tr>
                            <tr>
                                <td>Ảnh đại diện</td>
                                <td><img src="@{{ img1 }}" width="200px" height="100px" alt="banner"><br>
                                    <br>
                                    <input type="file" required name="img" fileread="img1">
                                    @error('img')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <td>nội dung</td>
                                <td>
                                    <textarea name="noidung" required id="noidung" rows="10" cols="80">
                                        </textarea>
                                    <script>
                                        CKEDITOR.replace('noidung');
                                    </script>
                                </td>
                            </tr>
                            <tr>
                                <td>Loại Tin tức</td>
                                <td>
                                    <select name="loaitt" required class="form-control">
                                        @foreach ($listDmtin as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <a class="btn btn-secondary" ng-click="themtt()">Quay lại</a>
                    <button class="btn btn-danger" type="submit">Thêm</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        var app = angular.module('myapp', [])
        app.directive("fileread", [function() {
            return {
                scope: {
                    fileread: "="
                },
                link: function(scope, element, attributes) {
                    element.bind("change", function(changeEvent) {
                        var reader = new FileReader();
                        reader.onload = function(loadEvent) {
                            scope.$apply(function() {
                                scope.fileread = loadEvent.target.result;
                            });
                        }
                        reader.readAsDataURL(changeEvent.target.files[0]);
                    });
                }
            }
        }]);
        app.filter('loctt', function($rootScope) {
            return function(input, ts1) {
                if (ts1 == '') {
                    $rootScope.listCount = []
                    $rootScope.count = Math.ceil(input.length / $rootScope.page)
                    for (i = 1; i <= $rootScope.count; i++) {
                        $rootScope.listCount.push(i)
                    }
                    $rootScope.kt = true
                    return input

                }
                var out = []
                $rootScope.kt = true
                for (i = 0; i < input.length; i++) {
                    if (input[i].loaitt == ts1) {
                        out.push(input[i])
                    }
                }
                if (out.length == 0) {
                    $rootScope.kt = false
                }
                $rootScope.listCount = []
                $rootScope.count = Math.ceil(out.length / $rootScope.page)
                for (i = 1; i <= $rootScope.count; i++) {
                    $rootScope.listCount.push(i)
                }
                return out
            }

        })
        app.controller('dmcontroller', function($scope, $rootScope) {
            $scope.them = true
            $scope.themtt = function() {
                $scope.them = !$scope.them
            }

            $scope.listTin = [
                @foreach ($listTin as $item) {
                        'id': {{ $item->id }},
                        'title': '{{ $item->title }}',
                        'img': '{{ asset($item->img) }}',
                        'tomtat': '{{ $item->tomtat }}',
                        'loaitt': '{{ $item->idloai }}',
                        'luotxem': {{ $item->luotxem }},
                    }, @endforeach
            ]
            $scope.loaitt = ''
            $scope.listtt = [{
                    'value': '',
                    'name': '------Mặc đinh-------'
                },
                @foreach ($listDmtin as $item) {
                        'value':{{ $item->id }},
                        'name':'{{ $item->name }}',
                    }, @endforeach
            ]
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
            $rootScope.start = 0
            $rootScope.page = 10
            $rootScope.listCount = []
            $rootScope.count = Math.ceil($scope.listTin.length / $rootScope.page)
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
            $scope.xoa = function(event) {
                if (!confirm('bạn có muốn xóa nó không')) {
                    event.preventDefault();
                }
            }
            @if ($errors->any())
                $scope.them = false
            @endif
        })
    </script>
@endsection
