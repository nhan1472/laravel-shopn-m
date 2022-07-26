@extends('layout.client')
@section('title')
    {{ $title }}
@endsection
@section('content')
    <div ng-controller="lgcontroller" class="container">
        <div class="row" style="margin: 100px;">
            <div ng-if="anhien" class="col-12 border" style="padding: 50px;box-shadow: 0px 1px 5px rgb(0 0 0 / 10%);border-radius:10%; ">
                <h1 class="text-center mb-5">Đăng nhập</h1>
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="row mb-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Đăng nhập') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Mật khẩu') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- <div class="row mb-3">
                        <div class="col-md-6 offset-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Nhớ tôi') }}
                                </label>
                            </div>
                        </div>
                    </div> --}}

                    <div class="row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Login') }}
                            </button>

                            @if (Route::has('password.request'))
                                <a class="btn btn-link" ng-click="nhan()">
                                    {{ __('Quên mật khẩu?') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
            <div ng-if="!anhien" class="col-12 border" style="padding: 50px;box-shadow: 0px 1px 5px rgb(0 0 0 / 10%);border-radius:10%; ">
                <h1 class="text-center mb-5">Lấy lại mật khẩu</h1>
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="row mb-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Đăng nhập') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Gửi ') }}
                            </button>
                            <a class="btn btn-link" ng-click="nhan()">
                                {{ __('Quay lại') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
          var app = angular.module('myapp', [])
          app.controller('lgcontroller', function($scope, $rootScope) {
              $scope.anhien=true
              $scope.nhan = function()
              {
                $scope.anhien=!$scope.anhien
              }
          })
    </script>
@endsection
