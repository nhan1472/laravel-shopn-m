@extends('layout.user')
@section('title')
    {{ $title }}
@endsection
@section('content')
    <div class="mt-5" ng-controller="usercontroller">
        <div class="d-flex justify-content-end me-3">
            @php
                $today = date('d/m/Y');
                echo $today;
            @endphp
        </div>
        <h1 class="text-center">Xin chào: {{ Auth::user()->name }}</h1>
        <hr size="4">
        <div class="container">
            <div class="row">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="col-12">
                    <div>
                        <table class="table" ng-if="!capnhat">
                            <tbody>
                                <tr>
                                    <td>Tên:</td>
                                    <td>{{ Auth::user()->name }}</td>
                                </tr>
                                <tr>
                                    <td>Email:</td>
                                    <td>{{ Auth::user()->email }}</td>
                                </tr>
                                @if ($user)
                                    <tr>
                                        <td>SDT:</td>
                                        <td>{{ $user[0]->sdt }}</td>
                                    </tr>
                                    <tr>
                                        <td>Địa chỉ:</td>
                                        <td>{{ $user[0]->daichi }}</td>
                                    </tr>
                                    <tr>
                                        <td>Giới tính:</td>
                                        <td>{{ $user[0]->gioitinh }}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td>SDT:</td>
                                        <td>rổng</td>
                                    </tr>
                                    <tr>
                                        <td>Địa chỉ:</td>
                                        <td>rổng</td>
                                    </tr>
                                    <tr>
                                        <td>Giới tính:</td>
                                        <td>rổng</td>
                                    </tr>
                                @endif
                        </table>
                        <form action="{{ route('user.updateusert') }}" method="post">
    
                            @csrf
                            <table class="table" ng-if="capnhat">
                                @if ($user)
                                <input type="hidden" name="id" value="{{$user[0]->id}}">
                                @endif
                                <tbody>
                                    <tr>
                                        <td>Tên:</td>
                                        <td><input type="text" class="form-control" required name="name"
                                                value="{{ old('name') ? old('name') : Auth::user()->name }}">
                                            <br>
                                            @error('name')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>Email:</td>
                                        <td><input type="text" class="form-control" disabled required name="email"
                                                value="{{ Auth::user()->email }}"></td>
                                    </tr>
                                    @if ($user)
                                        <tr>
                                            <td>SDT:</td>
                                            <td><input type="text" name="sdt" class="form-control"
                                                    value="{{ old('sdt') ? old('sdt') : $user[0]->sdt }}" required><br>
                                                @error('sdt')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>Địa chỉ:</td>
                                            <td>
                                                <textarea class="form-control" required name="daichi">
                                                {{ $user[0]->daichi }}
                                                </textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Giới tính:</td>
                                            <td><select name="gioitinh" value="{{ $user[0]->gioitinh }}" required
                                                    class="form-control">
                                                    <option value="">Gới tính</option>
                                                    <option value="Nam">Nam</option>
                                                    <option value="Nữ">Nữ</option>
                                                    <option value="Khác">Khác</option>
                                                </select></td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td>SDT:</td>
                                            <td><input type="text" name="sdt" class="form-control"
                                                    value="{{ old('sdt') ? old('sdt') : '' }}" required><br>
                                                @error('sdt')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>Địa chỉ:</td>
                                            <td>
                                                <textarea class="form-control" required name="daichi" value="">
                                        </textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Giới tính:</td>
                                            <td><select name="gioitinh" required class="form-control">
                                                    <option value="">Gới tính</option>
                                                    <option value="Nam">Nam</option>
                                                    <option value="Nữ">Nữ</option>
                                                    <option value="Khác">Khác</option>
                                                </select></td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <a class="btn btn-primary" ng-if="!capnhat" ng-click="nhan()">Cập nhật thông tin</a>
                            <a class="btn btn-secondary" ng-if="capnhat" ng-click="nhan()">Quay lại</a>
                            <button class="btn btn-danger" ng-if="capnhat" type="submit">Thay đỗi</button>
                        </form>
                    </div>
                </div>
                <div class="col-12">
                    <h1 class="text-center">Thông kê</h1>
                    @if(Auth::user()->role==0)
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Số lần mua hàng</td>
                                @php
                                    $slln = DB::select('SELECT COUNT(`id`) as sl FROM `hoadon` WHERE `tinhtrang`!=3 AND `idkh`=' . Auth::user()->id);
                                    $tongln = DB::select('SELECT SUM(`tong`) as tong FROM `hoadon` WHERE `tinhtrang`!=3 AND `idkh`=' . Auth::user()->id);
                                @endphp
                                <td>{{ $slln[0]->sl }}</td>
                            </tr>
                            <tr>
                                <td>tổng chi tiêu</td>
                                <td>{{ number_format($tongln[0]->tong) }}đ</td>
                            </tr>
                        </tbody>
                    </table>
                    @else
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Số đơn duyệt</td>
                                @php
                                    $sdd = DB::select("SELECT COUNT(`id`) AS sl FROM `hoadon` WHERE `idnv`=? AND `tinhtrang`=3",[Auth::user()->id]);
                                    $sdy = DB::select("SELECT COUNT(`id`) AS sl FROM `hoadon` WHERE `idnv`=? AND `tinhtrang`!=3",[Auth::user()->id]);
                                @endphp
                                <td>{{ $sdy[0]->sl }}</td>
                            </tr>
                            <tr>
                                <td>số  đơn hủy</td>
                                <td>{{ $sdd[0]->sl }}</td>
                            </tr>
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        var app = angular.module('myapp', [])
        app.controller('usercontroller', function($scope, $rootScope) {
            $scope.capnhat = false
            $scope.nhan = function() {
                $scope.capnhat = !$scope.capnhat
            }
            @if ($errors->any())
                $scope.capnhat = true
            @endif
        })
    </script>
@endsection
