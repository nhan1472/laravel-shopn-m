@extends('layout.client')
@section('title')
    {{ $title }}
@endsection
@section('css')
@endsection
@section('content')
    <div class="container mt-5" ng-controller="ttcontroller">
        <div class="row">
            <h1 class="text-center">Các tin tức mơi nhất</h1>
            <select ng-model="loaitt" class="form-control" ng-change="ktdm()">
                <option ng-repeat="item in listtt" value="@{{item.value}}">@{{item.name}}</option>
            </select>
            <div class="col-10" ng-show="kt">
                <div class="row" ng-repeat="item in listTin |loctt :loaitt |limitTo  :page:start">
                    <a href="/tintuc/@{{item.id}}" class="text-dark" style="text-decoration: none;">
                    <div class="row mt-4 py-2 border">
                        <div class="col-md-4">
                            <img src="@{{ item.img }}" class="img-fluid rounded-start" alt="@{{ item.tieude }}">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">@{{ item.tieude }}</h5>
                                <p class="card-text">@{{ item.tomtat }}</p>
                                <p class="card-text">Thể loại: @{{ item.theloai }}</p>
                                <p class="card-text"><small class="text-muted">@{{ item.ngaydang | date: 'dd-MM-yyyy HH:mm:ss' }}</small></p>
                            </div>
                        </div>
                    </div>
                </a>
                </div>
                <nav aria-label="Page navigation example" class="mt-2">
                    <ul class="pagination">
                        <li class="page-item " ng-repeat="item in listCount" style="cursor: pointer;"><a
                                class="page-link" ng-class="active[$index]" ng-click="pageClick(item)">@{{ item }}</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-10" ng-if="!kt">
                <h1 class="text-center">Không có tin tức thuộc danh mục này</h1>
            </div>
            <div class="col-2">
                <h2>Các sản phẩm mới nhất</h2>
                <div ng-repeat="item in listItems">
                    <hr class="my-3">
                    <a href="/sanpham/@{{item.id}}">
                    <div class="card" style="width: 15rem; height: 200px;">
                        <img src="@{{ item.img }}" height="150px" class="card-img-top" alt="@{{ item.ten }}">
                        <div class="card-body">
                            <p class="card-text text-center" style="text-decoration: none">@{{ item.ten }}</p>
                        </div>
                    </div>
                </a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        var app = angular.module('myapp', [])
        app.filter('loctt', function($rootScope) {
            return function(input, ts1) {
                if(ts1=='')
                {
                    $rootScope.listCount = []
                    $rootScope.count = Math.ceil(input.length / $rootScope.page)
                    for (i = 1; i <= $rootScope.count; i++) {
                        $rootScope.listCount.push(i)
                    }
                    $rootScope.kt=true
                    return input

                }
                var out=[]
                $rootScope.kt=true
                for(i=0;i<input.length;i++)
                {
                    if(input[i].loaitt==ts1)
                    {
                        out.push(input[i])
                    }
                }
                if(out.length==0)
                {
                    $rootScope.kt=false
                }
                $rootScope.listCount = []
                $rootScope.count = Math.ceil(out.length / $rootScope.page)
                for (i = 1; i <= $rootScope.count; i++) {
                    $rootScope.listCount.push(i)
                }
                return out
            }
        })
        app.controller('ttcontroller', function($scope, $rootScope) {
            $rootScope.kt=true
            $scope.listTin = [
                @foreach ($listTin as $item)
                    {
                        'id': {{ $item->id }},
                        'tieude': '{{ $item->title }}',
                        'img':'{{asset($item->img)}}',
                        'tomtat': '{{ $item->tomtat }}',
                        'loaitt': {{ $item->idloai }},
                        'luotxem': {{ $item->luotxem }},
                        'ngaydang': new Date('{{ $item->ngaydang }}'),
                        @php
                            $loaitt1 = DB::select('SELECT * FROM `loaitt` WHERE `id`=?', [$item->idloai]);
                        @endphp
                        'theloai':'{{$loaitt1[0]->name}}',
                    },
                @endforeach
            ]
            $rootScope.listItems = [
                @foreach ($listSpham as $item)
                    {
                        'id': {{ $item->id }},
                        'ten': '{{ $item->ten }}',
                        'img': '{{ $item->img }}',
                        'gia': {{ $item->gia }},
                        'giamgia': {{ $item->giamgia }},
                        'maloai': {{ $item->maloai }},

                    },
                @endforeach
            ]
            $scope.loaitt=''
            $scope.listtt=[
                {
                    'value':'',
                    'name':'------Mặc đinh-------'
                },
                @foreach ($listDmtin as $item)
                    {
                        'value':{{$item->id}},
                        'name':'{{$item->name}}',
                    },
                @endforeach
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
            $rootScope.page = 6
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
        })
    </script>
@endsection
