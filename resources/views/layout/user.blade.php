<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')-N$M</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/css.css') }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    @yield('css')
</head>

<body ng-app="myapp">
    <div class="row">
        <div class="col-3  bg-success">@include('include.user.header')</div>
        <div class="col-9">
            <div class="load" style="margin: 15% 25% " >
                <div class="d-flex justify-content-center"  >
                    <div class="spinner-border"   style="width: 3rem; height: 3rem;"role="status">
                      <span class="visually-hidden">Loading...</span>
                    </div>
                  </div>
            </div>
            <div class="reload">
            @yield('content')
            </div>
        </div>
    </div>
    @include('include.user.footer')
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/js.js') }}"></script>

    <script src="{{ asset('js/angular.min.js') }}"></script>
    @yield('js')
</body>

</html>
