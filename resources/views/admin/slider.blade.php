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
        <div ng-if="hien1">
            <h1 class="text-center" ng-if="hien">Quản lý Slider</h1>
            <h1 class="text-center" ng-if="!hien">Edit Slider</h1>
        </div>
        <h1 class="text-center" ng-if="!hien1">Thêm Slider</h1>
        <hr size="4">
        <div ng-if="hien1">
            <button class="btn btn-primary" ng-if="hien" ng-click="quaylai1()">Thêm sản slider</button>
        </div>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div ng-if="hien1">
            <table class="table" ng-if="hien">
                <thead>
                    <tr>
                        <th>
                            STT
                        </th>
                        <th>
                            Ảnh
                        </th>
                        <th>
                            Content
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="item in listSlider">
                        <td>@{{ $index + 1 }}</td>
                        <td>
                            <img src="@{{ item.img }}" width="200px" height="100px" alt="banner">
                        </td>
                        <td>@{{ item.content }}</td>
                        <td>
                            <form action="{{ route('admin.slider.remove') }}" method="post">
                                <input type="hidden" name="id" value="@{{ item.id }}">
                                @csrf
                                <a class="btn btn-outline-warning" ng-click="edit(item.id)">Edit</a>
                                <button class="btn btn-outline-danger" ng-click="xoa($event)" type="submit">X</button>
                            </form>
                        </td>

                    </tr>
                </tbody>
            </table>
            <form ng-if="!hien" enctype="multipart/form-data" action="{{ route('admin.slider.update') }}" method="post">
                @csrf
                <input type="hidden" name="id" value="@{{id}}">
                <table ng-if="!hien" class="table">
                    <tbody>
                        <tr>
                            <td>
                                Ảnh
                            </td>
                            <td>
                                <img src="@{{ img }}" width="200px" height="100px" alt="banner"><br>
                                <br>
                                <input type="file"  name="img" class="form-control" value="@{{img}}" fileread="img">
                            </td>
                        </tr>
                        <tr>
                            <td>Content</td>
                            <td>
                                <input type="text" required class="form-control" name="content" ng-model="content">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <a class="btn btn-secondary" ng-if="!hien" ng-click="quaylai()">Quay lai</a>
                <button class="btn btn-danger" ng-if="!hien" type="submit" >Thay đỗi</button>
            </form>
        </div>
        <form action="{{ route('admin.slider.add') }}" enctype="multipart/form-data" method="post">
            @csrf
            <table ng-if="!hien1" class="table">
                <tbody>
                    <tr>
                        <td>
                            Ảnh
                        </td>
                        <td>

                            <img src="@{{ img1 }}" width="200px" height="100px" alt="banner"><br>
                            <br>
                            <input type="file" name="img" class="form-control" fileread="img1"
                                value="{{ old('img') }}">
                            <br>
                            @error('img')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td>Content</td>
                        <td>
                            <input type="text" class="form-control" required name="content"
                                value="{{ old('Content') }}">
                        </td>
                    </tr>
                </tbody>
            </table>
            <a class="btn btn-secondary" ng-if="!hien1" ng-click="quaylai1()">Quay lai</a>
            <button class="btn btn-primary" type="submit" ng-if="!hien1" >Thêm</button>
        </form>

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
        app.controller('adcontroller', function($scope, $rootScope) {
            $scope.listSlider = [
                @foreach ($listSlider as $item)

                    {
                        'id': {{ $item->id }},
                        'img': '{{ asset( $item->img )}}',
                        'content': '{{ $item->content }}',
                    },
                @endforeach
            ]
            $scope.hien = true
            $scope.hien1 = true
            $scope.edit = function(i) {
                $scope.id = i
                for (i = 0; i < $scope.listSlider.length; i++) {
                    if ($scope.listSlider[i].id == $scope.id) {
                        $scope.img = $scope.listSlider[i].img
                        $scope.content = $scope.listSlider[i].content
                    }
                }
                $scope.hien = !$scope.hien
            }
            $scope.quaylai = function() {
                $scope.hien = !$scope.hien
            }
            $scope.quaylai1 = function() {
                $scope.hien1 = !$scope.hien1
            }
            @if ($errors->any())
                $scope.hien1 = false
            @endif
            $scope.img1 = ''
            $scope.content1 = ''
            $scope.xoa = function (event)
            {
                if(!confirm('bạn có muốn xóa không'))
                {
                    event.preventDefault();
                }
            }
        })
    </script>
@endsection
