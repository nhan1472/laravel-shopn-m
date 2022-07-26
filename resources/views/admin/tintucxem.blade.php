@extends('layout.admin')
@section('title')
    {{ $tintuc[0]->title }}
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
            <h1 class="text-center">Quản lý nội dung {{ $tintuc[0]->title }}</h1>
            <hr size="4">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div ng-if="sua">
                <a href="{{ route('admin.tintuc.index') }}" class="btn btn-secondary">Quay lại</a>
                <a class="btn btn-warning" ng-click="suatt()">Sữa</a>
                <h1 class="text-center">{{$tintuc[0]->title}}</h1>
                <hr size="4">
                <br>
                <i> ngày đăng:{{ $tintuc[0]->ngaydang }}</i>
                <div>
                    {!! $tintuc[0]->noidung !!}
                </div>
            </div>
            <div ng-if="!sua">
                <form action="{{ route('admin.tintuc.update') }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{$tintuc[0]->id}}">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Tiêu đề</td>
                                <td><input type="text" required class="form-control" name="tieude"
                                        value="{{$tintuc[0]->title}}"></td>
                            </tr>
                            <tr>
                                <td>Tóm tắt</td>
                                <td><input type="text"  required class="form-control" name="tomtat"
                                        value="{{$tintuc[0]->tomtat}}"></td>
                            </tr>
                            <tr>
                                <td>img</td>
                                <td>
                                    <img width="100px"  height="50px" src="{{ asset($tintuc[0]->img) }}" alt="">
                                    <input type="file"   name="img"
                                       ></td>
                            </tr>
                            <tr>
                                <td>nội dung</td>
                                <td>
                                    <textarea name="noidung" required id="noidung" rows="10" cols="80">
                                        {{ $tintuc[0]->noidung }}
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
                   
                    <a class="btn btn-secondary" ng-click="suatt()">Quay lại</a>
                    <button class="btn btn-danger" type="submit">Thay đỗi</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        var app = angular.module('myapp', [])
        app.controller('dmcontroller', function($scope, $rootScope) {
            $scope.sua = true
            $scope.suatt = function() {
                $scope.sua = !$scope.sua
            }
        })
    </script>
@endsection
