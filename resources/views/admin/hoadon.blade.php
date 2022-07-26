
@extends(Auth::user()->role==1?'layout.admin':'layout.user')
@section('title')
    {{ $title }}
@endsection
@section('content')
    <div class="mt-5" ng-controller="sizecontroller">
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
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('success1'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('success1') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @php
            $sl = DB::select('SELECT COUNT(`id`) as sl FROM `hoadon` ');
        @endphp
              <div ng-if="huyhd">
        <h2>Có tổng cộng {{ $sl[0]->sl }} Hóa đơn</h2>
        <div class="row">
            <div class="col-2">Tìm kiếm</div>
            <div class="col-4"><input type="text" ng-model="seach" ng-change="ktdm()" class="form-control"
                    placeholder="nhập mã hóa đơn cần tìm"></div>
            <div class="col-1 ">Lọc tình trạng:</div>
            <div class="col-2">
                <select ng-model="tthd" class="p-2 bd-highlight" ng-change="ktdm()">
                    <option ng-repeat="item in tt" value="@{{ item.value }}">@{{ item.name }}
                    </option>
                </select>
            </div>
            <div class="col-2 form-check text-center d-flex form-switch align-items-center">
                <input type="checkbox" ng-change="ktdm()" ng-model="trongngay"  class="form-check-input"
                style="height: 30px;cursor: pointer;">
                <p class="">Trong ngày</p>
            </div>

        </div>
  
        <div ng-show="hoadon">
            <table class="table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã hóa đơn</th>
                        <th>Khách hàng</th>
                        @if (Auth::user()->role==1)
                        <th ng-if="hien1">Người duyệt</th>
                        @endif
                        <th ng-if="hien1">Chi tiết</th>
                        <th>Số lượng</th>
                        <th>Tổng tiền</th>
                        <th>Ngày mua</th>
                        <th>Tình trạng</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="item in listitem |seachid:seach | loctt :tthd |locngay :trongngay  |limitTo  :page:start">
                        <td>@{{ $index + 1 }}</td>
                        <td>@{{ item.id }}
                        <td>@{{ item.kh.name }}
                            <br>
                            <p ng-if="hien[item.id]">địa chỉ: @{{ item.kh.daichi }}
                                <br>
                                SDT:@{{ item.kh.sdt }} <br>
                                Email:@{{ item.kh.email }}
                            </p>
                        </td>
                        
                            @if (Auth::user()->role==1)
                            <td ng-if="hien[item.id]">
                            <p > @{{item.nvkt}}</p>
                            </td>
                            @endif
                       
                        <td ng-if="hien[item.id]">
                            <p ng-repeat="items in item.sp">
                                Tên sản phẩm: @{{ items.ten }} <br>
                                Giá: @{{ items.gia * (100 - items.giamgia) / 100 | number }} <br>
                                Số lượng: @{{ items.sl }} <br>
                                Size: @{{ items.size }} <br>
                            </p>
                        </td>
                        <td>@{{ item.tongsl }}</td>
                        <td>@{{ item.tong | number }}</td>
                        <td>@{{ item.ngaymua | date: 'dd-MM-yyyy HH:mm:ss' }}</td>
                        <td ng-switch="item.tinhtrang">
                            <div class="d-flex" ng-switch-when="0">
                                <p class="text-warning">Đang chờ
                                    @if(Auth::user()->role==1)
                                <form action="{{ route('admin.hoadon.duyet') }}" id="huydon" method="post">
                                    @else
                                <form action="{{ route('user.hoadon.duyet') }}" id="huydon" method="post">
                                    @endif
                                    @csrf
                                    <input type="hidden" name="id" value="@{{ item.id }}">
                                    <input type="hidden" name="idnv" value="{{ Auth::user()->id }}">
                                    <button class="btn btn-warning">Duyệt</button>
                                </form>
                                <button ng-click="huy(item.id)" class="ms-2 btn btn-danger">huy</button>
                                </p>
                            </div>
                            <div class="d-flex" ng-switch-when="1">
                                <p class="text-primary">Đang giao
                                    @if(Auth::user()->role==1)
                                    <form action="{{ route('admin.hoadon.giao') }}" id="huydon" method="post">
                                        @else
                                        <form action="{{ route('user.hoadon.giao') }}" id="huydon" method="post">
                                        @endif
                                    @csrf
                                    <input type="hidden" name="id" value="@{{ item.id }}">
                                    <button class="btn btn-primary">Dã giao</button>
                                </form>
                                </p>
                            </div>
                            <p class="text-success" ng-switch-when="2">Đã Giao</p>
                            <p class="text-danger" ng-switch-when="3"> Đã Hủy <br>
                                        
                                <p ng-if="hien[item.id]" ng-switch-when="3" class="text-danger">  lý do: @{{item.lydo}}</p>
                              </p>
                        </td>
                        <td>
                   

                            <a ng-click="hien(item.id)" style="cursor: pointer;">Xem chi tiết</a>
                            <br>
                            @if(Auth::user()->role==1)
                            <a ng-if="item.tinhtrang==2 || item.tinhtrang==1" href="/admin/inhoadon/@{{item.id}}"  style="cursor: pointer;">in hóa đơn</a>
                            @else
                            <a ng-if="item.tinhtrang==2 || item.tinhtrang==1" href="/user/hoadon/inhoadon/@{{item.id}}"  style="cursor: pointer;">in hóa đơn</a>
                            @endif
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
    </div>
    <div ng-if="!huyhd">
        <h1 class="text-center">Bạn có muôn hủy hóa đơn mã:@{{title}}</h1>
        @if (Auth::user()->role==1)
        <form action="{{ route('admin.hoadon.huy') }}" method="post">
        @else
        <form action="{{ route('user.hoadon.huy') }}" method="post">
        @endif
   
            @csrf
            <input type="hidden" class="form-control"  name="idnv" value="{{Auth::user()->id}}">
            <input type="hidden" class="form-control"  name="id" value="@{{title}}">
        <table class="table">
            <tr>
                <td>Lý do</td>
                <td><input type="text" required class="form-control"  name="lydo"></td>
            </tr>
        </table>
        <a  class="btn btn-secondary" ng-click="huy(0)">Quay lại</a>
        <button type="submit" class="btn btn-primary">Xác nhận</button>
    </form>
       
    </div>
        <div ng-if="!hoadon">
            <h1 class="text-center my-5">Không có hoa đơn phù hợp</h1>
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
                    $rootScope.hoadon=true
                    return input
                }
                var out = []
                for (i = 0; i < input.length; i++) {
                    if (input[i].tinhtrang == ts1) {
                        out.push(input[i])
                    }
                }
                if(out.length==0)
                    {
                        $rootScope.hoadon=false
                    }  
                    $rootScope.listCount = []
                    $rootScope.count = Math.ceil(out.length / $rootScope.page)
                    for (i = 1; i <= $rootScope.count; i++) {
                        $rootScope.listCount.push(i)
                    }
                return out
            }
            
        })
        app.filter('locngay', function($rootScope) {
            return function(input, ts1) {
                    if(ts1 ==false)
                    {
                        $rootScope.hoadon=true
                        return input
                    }
                    var out=[]
                    let date = new Date()
                    for(i=0;i<input.length;i++)
                    {
                        
                        if(date.getFullYear()==input[i].ngaymua.getFullYear() && 
                        date.getMonth()==input[i].ngaymua.getMonth() &&
                        date.getDate()==input[i].ngaymua.getDate() )
                        {
                            out.push(input[i])
                        }
                    }
                    if(out.length==0)
                    {
                        $rootScope.hoadon=false
                    }  
                    $rootScope.listCount = []
                    $rootScope.count = Math.ceil(out.length / $rootScope.page)
                    for (i = 1; i <= $rootScope.count; i++) {
                        $rootScope.listCount.push(i)
                    }
                    return out
            }
        })
        app.filter('seachid', function($rootScope) {
            return function(input, ts1) {
                
                $rootScope.hoadon=true
                if (ts1 != '') {
                    input = input.filter(item => item.id == ts1)
                    if(input.length==0)
                    {
                        $rootScope.hoadon=false
                    }  
                    $rootScope.listCount = []
                    $rootScope.count = Math.ceil(input.length / $rootScope.page)
                    for (i = 1; i <= $rootScope.count; i++) {
                        $rootScope.listCount.push(i)
                    }
                    return input;
                } else {
                    $rootScope.listCount = []
                    $rootScope.count = Math.ceil(input.length / $rootScope.page)
                    for (i = 1; i <= $rootScope.count; i++) {
                        $rootScope.listCount.push(i)
                    }
                    return input
                }
            }
        })
        app.controller('sizecontroller', function($scope, $rootScope) {
            $scope.listitem = [
             
                @foreach ($listhoadon as $item)
                    {
                        'id': {{ $item->id }},
                        @php
                            $kh = DB::select('SELECT * FROM `users` WHERE `id`=?', [$item->idkh]);
                            $khct = DB::select('SELECT * FROM `ctusers` WHERE `iduser`=?', [$kh[0]->id]);
                        @endphp 'kh': {
                            'name': '{{ $kh[0]->name }}',
                            'email': '{{ $kh[0]->email }}',
                            'sdt': '{{ $khct[0]->sdt }}',
                            'daichi': '{{ $khct[0]->daichi }}',
                        },
                        'sp': [
                            @php
                                $cthd = DB::select('SELECT * FROM `cthd` WHERE `idct`=' . $item->id);
                            @endphp
                            @foreach ($cthd as $rowas)
                                {
                                    'ten': '{{ $rowas->ten }}',
                                    'img': '{{ $rowas->img }}',
                                    'size': '{{ $rowas->size }}',
                                    'gia': {{ $rowas->gia }},
                                    'giamgia': {{ $rowas->giamgia }},
                                    'sl': {{ $rowas->sl }},
                                },
                            @endforeach
                        ],
                        'tongsl': {{ $item->tongsl }},
                        'tong': {{ $item->tong }},
                        'ngaymua': new Date('{{ $item->ngaymua }}'),
                        'tinhtrang': {{ $item->tinhtrang }},
                        'lydo': '{{ $item->lydo }}',
                        @if (Auth::user()->role==1)
                        @php
                            $nvd = DB::select('SELECT * FROM `users` WHERE id='.$item->idnv)
                        @endphp
                        @if($nvd)
                        'nvkt':'{{$nvd[0]->name}}'
                        @else
                        'nvkt':'không   '
                        @endif
                        @endif
                    },
                @endforeach
            ]
            $scope.trongngay=false
            $rootScope.hoadon = true
            $scope.seach = ''
            $scope.hien = []
            $scope.hien1 = false
            $scope.hien = function(i) {
                if ($scope.hien[i] == true) {
                    $scope.hien[i] = false
                } else {
                    $scope.hien[i] = true
                }
                
                $scope.hien1 = !$scope.hien1

                
            }
            $rootScope.start = 0
            $rootScope.page = 10
            $rootScope.listCount = []
            $rootScope.count = Math.ceil($scope.listitem.length / $rootScope.page)
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
            $scope.tthd=''
            $scope.ngay=''
            $scope.ngayht=new Date()
            $scope.ngaythang=[
                {
                    value: '',
                    name: '---Mặc Định---',
                },
                {
                    value: $scope.ngayht,
                    name: 'Trong ngày',
                },
            ]
            $scope.tt = [{
                    value: '',
                    name: '---Mặc Định---',
                },
                {
                    value: 0,
                    name: 'Đang duyệt',
                },
                {
                    value: 1,
                    name: 'Đang dao',
                },
                {
                    value: 2,
                    name: 'Đã dao',
                },
                {
                    value: 3,
                    name: 'Đã hủy',
                },
            ]
            $scope.huyhd=true
            $scope.huy =function(i)
            {
                $scope.idhd=i
                $scope.listitem.forEach(e=>
                {
                    if(e.id==$scope.idhd)
                    {
                        $scope.title=e.id
                    }
                })
                $scope.huyhd=!$scope.huyhd
            }
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
        })
    </script>
@endsection
