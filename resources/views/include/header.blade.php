<header>
    <div>
        <div class="bg-success">
            <div class="container">
                <div class="row align-items-center text-light fw-bold">
                    <div class="col-2">
                        <h4>Hotline:0901234567</h4>
                    </div>
                    <div class="col-8"></div>
                    <div class="col-2"> 
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
                                        @if (Auth::user()->role==1)
                                        <a class="dropdown-item" href="{{ route('admin.index') }}" >
                                            {{ __('Quản lý trang') }}
                                        </a>
                                        @else

                                        <a class="dropdown-item" href="{{ route('user.index') }}" >
                                            {{ __('Quản lý tài khoản') }}
                                        </a>
                                        @endif
                                        <a class="dropdown-item" href="{{ route('dangxuat') }}" >
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
        <div>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-2">
                        <a href="{{ route('index') }}"><img src="{{ asset('img/logo.png') }}" alt="logo"
                                class="icon-header"></a>
                    </div>
                    <div class="col-8">
                        <p class="content1 text-center"> {{$slogan[0]->text}}</p>
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn btn-light">
                            @php $sl = 0 @endphp
                            @if (session('cart'))
                                @foreach (session('cart') as $id => $items)
                                    @php $sl +=  $items['sl'] @endphp
                                @endforeach
                            @endif
                            <div class="dropdown">
                            <a  class="dropdown-toggle" href="#"
                            role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ asset('img/cart.png') }}"
                                    class="icon-header" alt="giỏ hàng"><span
                                    class="badge bg-danger">{{ $sl }}</span>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    @if (session('cart'))
                                    @foreach (session('cart') as $id => $items)
                                    <li class="d-flex"><img src="{{ $items['img'] }}"
                                        style="max-height: 70px;width: 60px;" alt="">
                                    <p>Tên:{{ $items['ten'] }} <br>
                                        SL:{{$items['sl']}} <br>
                                        Size:{{$items['size']}} </p></li>
                                    @endforeach
                                    
                                    <li><hr class="dropdown-divider"></li>
                                    <li class="bg-primary"><a class="dropdown-item text-white" href="{{ route('cart.index') }}">Xem giỏ hàng</a></li>
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
    </div>
    <div class="bg-success">
        <div class="container">
            <ul class="nav  nav-fill">
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
            </ul>
        </div>
    </div>
    </div>
</header>
{{-- modal Register --}}
<div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Đăng Ký</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="email"
                            class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                <script>
                                    // document.getElementById("exampleModal").click();
                                </script>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="password"
                            class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="password-confirm"
                            class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control"
                                name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
