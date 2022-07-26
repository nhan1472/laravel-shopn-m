@extends('layout.admin')
@section('title')
    {{ $listSanpham[0]->ten }}
@endsection
@section('content')
    <div class="mt-5" ng-controller="spcontroller">
        <div class="d-flex justify-content-end me-3">
            @php
                $today = date('d/m/Y');
                echo $today;
            @endphp
        </div>
        <div>
            <h1 class="text-center">Chỉnh sưa nội dung {{ $listSanpham[0]->ten }}</h1>
            <hr size="4">
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('admin.sanpham.update') }}" enctype="multipart/form-data" method="post">
            @csrf
            <input type="hidden" name="id" value="{{ $listSanpham[0]->id }}">
            <table class="table">
                <tr>
                    <td>Tên</td>
                    <td><input type="text" name="name" value="{{ $listSanpham[0]->ten }}" class="form-control">
                        <br>
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td>Ảnh </td>

                    <td>

                        <img src="{{ asset($listSanpham[0]->img) }}" width="100px" height="50px" alt=""> <br>
                        <input type="file" name="img" class="form-control">
                        <br>
                        @error('img')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td>
                        Nội dung:
                    </td>
                    <td>
                        <textarea name="noidung" id="noidung" rows="10" cols="80">
                            {{ $listSanpham[0]->noidung }}
                        </textarea>
                        <script>
                            window.onload = function() {
                                CKEDITOR.replace('noidung');
                            };
                        </script>
                        <br>
                        @error('noidung')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td>Giá</td>
                    <td><input type="number" min="0" value="{{ $listSanpham[0]->gia }}" name="gia"
                            class="form-control">
                        <br>
                        @error('gia')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </td>
                </tr>

                <tr>
                    <td>Danh mục</td>
                    @php
                        $dm = DB::select('SELECT * FROM `loaisp` WHERE `id` = ?', [$listSanpham[0]->maloai]);
                        $dmsp = DB::select('SELECT * FROM `loaisp`');
                    @endphp
                    <td ng-if="thaydoi">
                        {{ $dm[0]->name }}
                        <input type="hidden" name="danhmuc" value="{{ $dm[0]->id }}">
                        <a class="ms-2 btn btn-danger" ng-click="thaydoidm()">Thay đỗi </a>
                    </td>
                    <td ng-if="!thaydoi">
                        <select class="form-control" name="danhmuc">
                            @foreach ($dmsp as $row)
                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                </tr>
            </table>
            <a href="{{ route('admin.sanpham.index') }}" class="btn btn-secondary">Quay lại</a>
            <button type="submit" class="btn btn-danger">Cập nhật</button>
        </form>


    </div>
@endsection
@section('js')
    <script>
        var app = angular.module('myapp', [])

        app.controller('spcontroller', function($scope, $rootScope) {
            $scope.thaydoi = true

            $scope.thaydoidm = function() {
                $scope.thaydoi = !$scope.thaydoi
            }
        })
    </script>
@endsection
