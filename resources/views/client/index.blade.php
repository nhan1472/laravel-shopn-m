@extends('layout.client')
@section('title')
    {{ $title }}
@endsection
@section('css')
    <style>
        img {
            vertical-align: middle;
        }

        /* Slideshow container */
        .slideshow-container {
            max-width: 1200px;
            position: relative;
            margin: auto;
        }

        /* Next & previous buttons */
        .prev,
        .next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            padding: 16px;
            margin-top: -22px;
            color: white;
            font-weight: bold;
            font-size: 18px;
            transition: 0.6s ease;
            border-radius: 0 3px 3px 0;
            user-select: none;
        }

        /* Position the "next button" to the right */
        .next {
            right: 0;
            border-radius: 3px 0 0 3px;
        }

        /* On hover, add a black background color with a little bit see-through */
        .prev:hover,
        .next:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }

        /* Caption text */
        .text {
            color: #000;
            font-weight: 700;
            font-size: 15px;
            padding: 8px 12px;
            position: absolute;
            bottom: 8px;
            width: 100%;
            text-align: center;
        }

        /* Number text (1/3 etc) */
        .numbertext {
            color: #f2f2f2;
            font-size: 12px;
            padding: 8px 12px;
            position: absolute;
            top: 0;
        }

        /* The dots/bullets/indicators */
        .dot {
            cursor: pointer;
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
            transition: background-color 0.6s ease;
        }

        .active,
        .dot:hover {
            background-color: #0081f1;
        }

        /* Fading animation */
        .hieuung {
            animation-name: hieuung;
            animation-duration: 1.5s;
        }

        @keyframes hieuung {
            from {
                opacity: .4
            }

            to {
                opacity: 1
            }
        }

        /* On smaller screens, decrease text size */
        @media only screen and (max-width: 300px) {

            .prev,
            .next,
            .text {
                font-size: 18px
            }
        }

        .yeuthich {
            position: absolute;
            top: 10%;
            right: 0%;
            cursor: pointer;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
        }

        .card:hover {
            box-shadow: 0 8px 12px 0 rgba(0, 0, 0, 0.2)
        }

        .giamgia {
            position: absolute;
            top: 10%;
            left: 10%;
            cursor: pointer;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
        }
    </style>
@endsection
@section('content')
    <div ng-controller="idcontroller" >
        <div class="slideshow-container mt-4">

            <div ng-repeat="item in listSlider |limitTo  :page:start" class="mySlides hieuung">
                <div class="numbertext" style="color: #000;">@{{ start + 1 }} / @{{ listSlider.length }}</div>
                <img src="@{{ item.img }}" style="max-height: 450px;width: 100%;">
                <div class="text">@{{ item.content }}</div>
            </div>


            <a class="prev" ng-click="prev()">❮</a>
            <a class="next" ng-click="next()">❯</a>

        </div>
        <br>
        <div style="text-align:center">
            <span ng-repeat="item in listSlider" ng-class="active[$index]" class="dot"
                ng-click="currentSlide($index)"></span>
        </div>
        <div id="cmtio"></div>

        <script src="http://cmtio.vercel.app/client.js" data-site-id="336703667773112911"></script>
        
        <script>
          initCmtioIframe(document.getElementById("cmtio"));
        </script>
        <div class="container mt-5">
            <h1 class="text-center text-danger">Các sản phẩm nổi bật</h1>
            <div ng-repeat="item in listloai" class="row border pb-5 ">
                <div class="col-12 py-3">
                    <h2 class="text-center">@{{ item.name }}</h2>
                </div>
                <div class="col-md-3 col-lg-3 col-6 mt-md-0 mt-3" ng-repeat="items in listItems |loc :$index |limitTo  :4:0">
                    <a href="/sanpham/@{{ items.id }}">
                        <div class="card" style="width: 100%;">
                            <img src="@{{ items.img }}" class="card-img-top image" style="max-height:300px"
                                alt="@{{ items.ten }}">
                            <div class="yeuthich d-none d-md-block">
                                <div>
                                    <img src="{{ asset('img/yeuthich.png') }}" ng-if="!yt[items.id]"
                                        ng-click="addyt(items.id,$event)" height="33px" width="50px" alt="yeuthich">
                                    <img src="{{ asset('img/yeuthich1.png') }}" ng-if="yt[items.id]"
                                        ng-click="addyt(items.id,$event)" height="40px" width="50px" alt="yeuthich">
                                </div>
                            </div>
                            <div class="giamgia  ">
                                <div ng-if="items.giamgia>0">
                                    <a class="btn btn-danger">@{{ items.giamgia }}%</a>
                                </div>
                            </div>
                            <h5 class="card-title text-center">@{{ items.ten }}</h5>
                            </h5>
                            <div ng-if="items.giamgia>0" class="text-center text-danger">
                                <p class="card-text ">
                                    <span style="text-decoration:line-through; ">@{{ items.gia | number }}</span>
                                    <br>
                                    @{{ items.gia * (100 - items.giamgia) / 100 | number }}đ
                                </p>
                            </div>
                            <div ng-if="items.giamgia==0">
                                <p class="card-text text-danger text-center">
                                    <br>
                                    @{{ items.gia | number }}đ
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="container">
            <h1 class="text-center">Các tin tức nổi bật</h1>
            <div class="row">
                <div class="col-md-3 col-6 mt-3 mt-md-0" ng-repeat="item in listTin |limitTo  :4:0">
                    <a href="/tintuc/@{{ item.id }}" class="text-dark" style="text-decoration: none;">
                        <div class="card" style="width: 100%;">
                            <img src="@{{ item.img }}" class="card-img-top image" style="max-height:300px"
                                alt="@{{ item.tieude }}">
                            <h5 class="card-title text-center text-truncate">@{{ item.tieude }}</h5>
                            <h5 class="card-title text-center text-truncate">@{{ item.ngaydang | date: 'dd-MM-yyyy' }}</h5>
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
        app.filter('loc', function($rootScope) {
            return function(input, ts1) {
                var out = []
                for (i = 0; i < input.length; i++) {
                    if (input[i].maloai == $rootScope.listloai[ts1].id) {
                        out.push(input[i])
                    }
                }
                return out
            }
        })
        app.controller('idcontroller', function($scope, $rootScope) {
            $scope.listSlider = [
                @foreach ($listSlider as $item)
                    {
                        'id': {{ $item->id }},
                        'img': '{{ $item->img }}',
                        'content': '{{ $item->content }}',
                    },
                @endforeach
            ]
            $scope.listTin = [
                @foreach ($listTin as $item)
                    {
                        'id': {{ $item->id }},
                        'tieude': '{{ $item->title }}',
                        'img': '{{ $item->img }}',
                        'tomtat': '{{ $item->tomtat }}',
                        'loaitt': {{ $item->idloai }},
                        'luotxem': {{ $item->luotxem }},
                        'ngaydang': new Date('{{ $item->ngaydang }}'),
                    },
                @endforeach
            ]
            $rootScope.listItems = [
                @foreach ($listSanpham as $item)
                    {
                        'id': {{ $item->id }},
                        'ten': '{{ $item->ten }}',
                        'img': '{{ $item->img }}',
                        'gia': {{ $item->gia }},
                        'giamgia': {{ $item->giamgia }},
                        'maloai': {{ $item->maloai }}
                    },
                @endforeach
            ]
            $rootScope.listloai = [
                @foreach ($listLoai as $item)
                    {
                        'id': {{ $item->id }},
                        'name': '{{ $item->name }}',
                    },
                @endforeach
            ]
            $scope.page = 1
            $scope.start = 0
            $scope.next = function() {
                if ($scope.start + 1 >= $scope.listSlider.length) {
                    $scope.start = 0
                } else {
                    $scope.start += 1
                }
                for (i = 0; i < $scope.listSlider.length; i++) {
                    if (i == $scope.start) {
                        $scope.active[i] = 'active'
                    } else {
                        $scope.active[i] = ''
                    }
                }
            }
            $scope.prev = function() {
                if ($scope.start - 1 < 0) {
                    $scope.start = $scope.listSlider.length - 1
                } else {
                    $scope.start -= 1
                }
                for (i = 0; i < $scope.listSlider.length; i++) {
                    if (i == $scope.start) {
                        $scope.active[i] = 'active'
                    } else {
                        $scope.active[i] = ''
                    }
                }
            }
            $scope.active = []
            $scope.active[0] = 'active'
            $scope.currentSlide = function(i) {
                $scope.start = i
                $scope.id = i
                for (i = 0; i < $scope.listSlider.length; i++) {
                    if (i == $scope.id) {
                        $scope.active[i] = 'active'
                    } else {
                        $scope.active[i] = ''
                    }
                }
            }
            $rootScope.yt = []
            for (i = 0; i < $rootScope.listItems.length; i++) {
                $rootScope.yt[$rootScope.listItems[i].id] = false
            }
            if (JSON.parse(localStorage.getItem("cartyt"))) {
                $rootScope.cartyt = JSON.parse(localStorage.getItem("cartyt"))
            } else {
                $rootScope.cartyt = []
            }
            for (i = 0; i < $rootScope.cartyt.length; i++) {
                $rootScope.yt[$rootScope.cartyt[i].id] = true
            }
            $rootScope.addyt = function(i) {
                $rootScope.idyt = i
                if ($rootScope.yt[i] == false) {
                    $rootScope.yt[i] = !$rootScope.yt[i]
                    for (i = 0; i < $rootScope.listItems.length; i++) {
                        if ($rootScope.listItems[i].id == $rootScope.idyt) {
                            $rootScope.cartyt.push($rootScope.listItems[i])
                        }
                    }
                    localStorage.setItem("cartyt", JSON.stringify($rootScope.cartyt))
                } else {
                    $rootScope.yt[i] = !$rootScope.yt[i]
                    for (i = 0; i < $rootScope.cartyt.length; i++) {
                        if ($rootScope.cartyt[i].id == $rootScope.idyt) {
                            $rootScope.cartyt.splice(i, 1)
                        }
                    }
                    localStorage.setItem("cartyt", JSON.stringify($rootScope.cartyt))
                }
                event.preventDefault();
            }
        })
    </script>
@endsection
