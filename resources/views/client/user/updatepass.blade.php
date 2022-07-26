@extends('layout.user')
@section('title')
    {{ $title }}
@endsection
@section('content')
    <div ng-controller="upcontroller" class="container">
        <div class="row" style="margin: 100px;">
            @if (session('success'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <h1 class="text-center">
                    Thây đỗi mật khẩu
                </h1>
                <hr size="4">
                <form  method="POST" action="{{ route('user.updatepass') }}" ng-if="xacthuc">
                    @csrf

                    <div class="row mb-3">
                        <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Nhập mật khẩu củ') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Xác nhận') }}
                            </button>
                        </div>
                    </div>
                </form>
                <form  method="POST" action="{{ route('user.updatepass1') }}" ng-if="!xacthuc">
                    @csrf

                    <div class="row mb-3">
                        <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('mật khẩu mới') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Xác nhận lại Mật khẩu') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Thay đỗi') }}
                            </button>
                        </div>
                    </div>
                </form>
        </div>
    </div>
@endsection
@section('js')
    <script>
          var app = angular.module('myapp', [])
          app.controller('upcontroller', function($scope, $rootScope) {
            $scope.xacthuc=true
            @if (session('role'))
            $scope.xacthuc=false
            @endif
          })
    </script>
@endsection
