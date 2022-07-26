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
            <h1 class="text-center">Quản lý nội dung Footer</h1>
            <hr size="4">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <h1>Cam kết</h1>
            <div ng-if="themck">
                <button class="btn btn-primary" ng-click="them1()">Thêm cam kết</button>
                <table class="table" ng-if="editck">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>icons</th>
                            <th>Nội dung</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="item in camket">
                            <td>@{{ $index + 1 }}</td>
                            <td><img src="@{{ item.img }}" height="35px" width="30px" alt="@{{ item.text }}">
                            </td>
                            <td>@{{ item.text }}</td>
                            <td>
                                <button class="btn btn-outline-warning" ng-click="suack($index)">Sữa</button>
                            </td>
                            <td>
                                <form action="{{ route('admin.footer.xoack') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="@{{ item.id }}">
                                    <button class="btn btn-outline-danger" ng-click="xoasp($event)">X</button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div ng-if="!editck">
                    <form action="{{ route('admin.footer.suack') }}" method="post" enctype="multipart/form-data">
                    <table class="table">
                        @csrf
                        <input type="hidden" name="id"  value="@{{idck}}">
                        <tbody>
                            <tr><td>
                                <img src="@{{imgck}}" height="35px" width="30px" alt="">
                                </td>
                                <td><input type="file" name="img"></td>
                            </tr>
                            <tr>
                                <td>Nội dung</td>
                                <td><input type="text" class="form-control" name="noidung" required value="@{{textck}}"></td>
                            </tr>
                        </tbody>
                    </table>
                    <a class="btn btn-secondary" ng-click="suack(0)">Quay lại</a>
                    <button class="btn btn-primary" type="submit">Thêm</button>
                </form>
                </div>
            </div>
            <div ng-if="!themck">
                <form action="{{ route('admin.footer.themck') }}" method="post" enctype="multipart/form-data">
                    @csrf
                <table class="table">
                    <tbody>
                        <tr>
                            <td>icons</td>
                            <td>
                                <img src="@{{ img1 }}" width="200px" height="100px" alt="banner"><br>
                                <br>
                                <input type="file" required name="img" fileread="img1" >
                                @error('img')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                            </td>
                        </tr>
                        <tr>
                            <td>nội dung</td>
                            <td><input type="text" required class="form-control" name="noidung"></td>
                        </tr>
                    </tbody>
                </table>
                <a class="btn btn-secondary" ng-click="them1()">Quay lại</a>
                <button class="btn btn-primary" type="submit">Thêm</button>
             </form>
            </div>
            <h1>Liên hệ</h1>
            <div ng-if="themlh">
                <button class="btn btn-primary" ng-click="them()">Thêm liên hệ</button>
                <div ng-if="editlh">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Nội dung</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="item in lienhe">
                                <td>@{{ $index + 1 }}</td>
                                <td>@{{ item.text }}</td>
                                <td>
                                    <button class="btn btn-outline-warning" ng-click="sua($index)">Sữa</button>
                                </td>
                                <td>
                                    <form action="{{ route('admin.footer.xoa') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="@{{ item.id }}">
                                        <button class="btn btn-outline-danger" ng-click="xoasp($event)">X</button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div ng-if="!editlh">
                    <form action="{{ route('admin.footer.sua') }}" method="post">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nội dung</th>
                                </tr>
                            </thead>

                            @csrf
                            <input type="hidden" name="id" value="@{{ idlh }}">
                            <tbody>
                                <tr>
                                    <td><input type="text" class="form-control" name="noidung"
                                            value="@{{ noidunglh }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td><a class="btn btn-secondary" ng-click="sua(0)">Quay lại</a>
                                        <button type="submit" class="btn btn-primary">cập nhật</button>
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                    </form>
                </div>
            </div>
            <div ng-if="!themlh">
                <form action="{{ route('admin.footer.them') }}" method="post">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nội dung</th>
                            </tr>
                        </thead>

                        @csrf
                        <tbody>
                            <tr>
                                <td><input type="text" required class="form-control" name="noidung">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button class="btn btn-secondary" ng-click="them()">Quay lại</button>
                    <button type="submit" class="btn btn-primary">Thêm</button>
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
        app.controller('adcontroller', function($scope) {
            $scope.camket = [
                @foreach ($camket as $item)
                    {
                        'id': {{ $item->id }},
                        'text': '{{ $item->text }}',
                        'img': '{{ asset($item->img) }}',
                    },
                @endforeach
            ]
            $scope.editlh = true
            $scope.editck = true
            $scope.themlh = true
            $scope.themck = true
            $scope.lienhe = [
                @foreach ($lienhe as $item)
                    {
                        'id': {{ $item->id }},
                        'text': '{{ $item->text }}',
                    },
                @endforeach
            ]
            $scope.xoasp = function(event) {
                if (!confirm('bạn có muốn xóa nó không')) {
                    event.preventDefault();
                }
            }
            $scope.suack = function(i) {
                $scope.editck = !$scope.editck
                $scope.imgck = $scope.camket[i].img
                $scope.textck = $scope.camket[i].text
                $scope.idck = $scope.camket[i].id
            }
            $scope.sua = function(i) {
                $scope.editlh = !$scope.editlh
                $scope.noidunglh = $scope.lienhe[i].text
                $scope.idlh = $scope.lienhe[i].id
            }
            $scope.them = function() {
                $scope.themlh = !$scope.themlh
            }
            $scope.them1 = function() {
                $scope.themck = !$scope.themck
            }
            @if ($errors->any())
                $scope.themck = false
            @endif
        })
    </script>
@endsection
