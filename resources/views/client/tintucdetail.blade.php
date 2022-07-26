@extends('layout.client')
@section('title')
    {{ $listTin[0]->title }}
@endsection
@section('css')
@endsection
@section('content')
    <div class="container mt-5" ng-controller="ttcontroller">
            <h1 class="text-center"> {{$listTin[0]->title}}</h1>
            <hr size="4" class="my-5">
            <i class="my-2">{{$listTin[0]->ngaydang}}</i><br>
            <i class="my-2">Lượt xem{{$listTin[0]->luotxem}}</i>
            <div class="row">
                <div class="col-12">
                    {!! $listTin[0]->noidung !!}
                </div>
            </div>
    </div>
@endsection
@section('js')
    <script>
        var app = angular.module('myapp', [])
        app.controller('ttcontroller', function($scope, $rootScope) {
        })
    </script>
@endsection
