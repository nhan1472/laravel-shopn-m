<header class="">
    <div class="bg-success">
        <div class="container">
            <div class="row align-items-center text-light fw-bold">
                <div class="col-md-2 col-lg-2 d-none d-md-block">
                    <h4>Hotline:0901234567</h4>
                </div>
                <div class="col-md-6 col-lg-7 d-none d-md-block"></div>
                <div class="col-md-4 col-lg-3 d-none d-md-block">
                    <nav class="nav">
                        @guest
                            <a class="nav-link {{ Request::routeIs('dangnhap') ? 'activemenu' : '' }}"
                                href="{{ route('dangnhap') }}">Đăng nhập</a>
                            <a class="nav-link {{ Request::routeIs('dangky') ? 'activemenu' : '' }}"
                                href="{{ route('dangky') }}">Đăng ký</a>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Xin chào: {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    @if (Auth::user()->role == 1)
                                        <a class="dropdown-item" href="{{ route('admin.index') }}">
                                            {{ __('Quản lý trang') }}
                                        </a>
                                    @else
                                        <a class="dropdown-item" href="{{ route('user.index') }}">
                                            {{ __('Quản lý tài khoản') }}
                                        </a>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('dangxuat') }}">
                                        {{ __('Đăng xuất') }}
                                    </a>
                                </div>
                            </li>
                        @endguest
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-light">
    <div class="container ">
        <div class="row align-items-center">
            <div class="col-2 d-none d-md-block">
                <a href="{{ route('index') }}"><img src="{{ asset('img/logo.png') }}" alt="logo"
                        class="icon-header"></a>
            </div>
            <div class="col-8  d-none d-md-block">
                <p class="content1 text-center"> {{ $slogan[0]->text }}</p>
            </div>
            <div class="col-2 d-none d-md-block">
                <button type="button" class="btn btn-light">
                    @php $sl = 0 @endphp
                    @if (session('cart'))
                        @foreach (session('cart') as $id => $items)
                            @php $sl +=  $items['sl'] @endphp
                        @endforeach
                    @endif
                    <div class="dropdown">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('img/cart.png') }}" class="icon-header" alt="giỏ hàng"><span
                                class="badge bg-danger">{{ $sl }}</span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            @if (session('cart'))
                                @foreach (session('cart') as $id => $items)
                                    <li class="d-flex"><img src="{{ $items['img'] }}"
                                            style="max-height: 70px;width: 60px;" alt="">
                                        <p>Tên:{{ $items['ten'] }} <br>
                                            SL:{{ $items['sl'] }} <br>
                                            Size:{{ $items['size'] }} </p>
                                    </li>
                                @endforeach

                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li class="bg-primary"><a class="dropdown-item text-white"
                                        href="{{ route('cart.index') }}">Xem giỏ hàng</a></li>
                            @else
                                <li class="text-center">Không có sản phẩm trong giỏ</li>
                            @endif
                        </ul>
                    </div>
                </button>
            </div>
        </div>
    </div>
</div>
    <div class="bg-success">
        <div class="container">
            <ul class=" nav nav-fill align-items-center justify-content-center navbar-expand-md navbar-light">
                <a href="{{ route('index') }}" class="d-block mx-1  d-md-none"><img src="{{ asset('img/logo.png') }}"
                        alt="logo" class="icon-header"></a>

                <div class="dropdown mx-1 d-block d-md-none">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                        aria-expanded="false">@guest Tài khoản
                        @else
                        {{ Auth::user()->name }} @endguest
                    </a>
                    <ul class="dropdown-menu ">
                        @guest
                            <li> <a class="nav-link text-dark {{ Request::routeIs('dangnhap') ? 'activemenu' : '' }}"
                                    href="{{ route('dangnhap') }}">Đăng nhập</a></li>
                            <li> <a class="nav-link text-dark {{ Request::routeIs('dangky') ? 'activemenu' : '' }}"
                                    href="{{ route('dangky') }}">Đăng ký</a></li>
                        @else
                            @if (Auth::user()->role == 1)
                                <li>
                                    <a class="dropdown-item text-dark" href="{{ route('admin.index') }}">
                                        {{ __('Quản lý trang') }}
                                    </a>
                                </li>
                            @else
                                <li>
                                    <a class="dropdown-item text-dark" href="{{ route('user.index') }}">
                                        {{ __('Quản lý tài khoản') }}
                                    </a>
                                </li>
                            @endif
                            <li>
                                <a class="dropdown-item text-dark" href="{{ route('dangxuat') }}">
                                    {{ __('Đăng xuất') }}
                                </a>
                            </li>
                        @endguest
                    </ul>
                </div>

                <a class="d-block d-md-none d-flex mx-1 " style="text-decoration: none"
                    href="{{ route('cart.index') }}">
                    <i class="fa fa-shopping-cart   py-1" style="font-size:24px;color:#000;"></i>
                    <p class="text-light " style="font-weight:700 ">({{ $sl }})</p>
                </a>

                <button class=" navbar-toggler justify-content-end" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('index') ? 'activemenu' : '' }}"
                            href="{{ route('index') }}">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('gioithieu.index') ? 'activemenu' : '' }}"
                            href="{{ route('gioithieu.index') }}">Giới thiệu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('sanpham.index') ? 'activemenu' : '' }}"
                            href="{{ route('sanpham.index') }}">Sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('tintuc.index') ? 'activemenu' : '' }}"
                            href="{{ route('tintuc.index') }}">Tin tức</a>
                    </li>
                </div>
            </ul>
        </div>
    </div>
</header>
