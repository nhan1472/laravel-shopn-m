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
        <div>
            <h1 >Slogan</h1>
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
            <form action="{{ route('admin.menu.update') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="@{{slogan.id}}">
            <table class="table">
                <thead>
                    <tr>
                    <th>Nội dung</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td ng-if="hien">@{{slogan.text}}</td>
                        <td ng-if="!hien">
                            <input type="text" name="text" class="form-control" value="@{{slogan.text}}">
                        </td>
                        <td><a ng-if="hien" ng-click="thaydoi()" class="btn btn-danger">Thay đỗi</a></td>
                        <td>
                            <a ng-if="!hien" ng-click="thaydoi()" class="btn btn-secondary">Quay lại</a>
                            <button type="submit" ng-if="!hien"  class="btn btn-primary">Xác nhận</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
        </div>
    </div>
@endsection
@section('js')
    <script>
        var app = angular.module('myapp', [])
        app.controller('adcontroller',function($scope)
        {
            $scope.slogan={
                'id':{{$slogan[0]->id}},
                'text':'{{$slogan[0]->text}}',
            }
            $scope.hien=true
            $scope.thaydoi= function()
            {
                $scope.hien=!$scope.hien
            }
        })
        
    </script>
@endsection
