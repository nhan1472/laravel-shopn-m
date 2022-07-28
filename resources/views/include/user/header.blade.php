<style>
    .activemenu {
        background-color: #0081f1;
        font-weight: 800;
    }
    @media only screen and (max-width: 321px) {
        .nav-link{
            font-size: 10px;
        }
    }
</style>

<header class="bg-success d-none d-md-block" style="height: 50em">
    <ul class="nav flex-column">
        <li class="nav-item mt-5">
            <a class="nav-link " href="{{ route('index') }}">Quay
                lại</a></a>
        </li>
        <li class="nav-item">
            <a class="nav-link  {{ Request::routeIs('user.index') ? 'activemenu' : '' }}" data-bs-toggle="collapse"
                href="#collapseExample" role="button" aria-expanded="true" aria-controls="collapseExample">Tài
                khoản <i class="fa-regular fa-list-dropdown"></i></a>
            <div class="collapse" id="collapseExample">
                <div class="card card-body bg-success">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('user.index') }}">Thông tin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.updatepass') }}">Thay đỗi mật khẩu</a>
                        </li>
                    </ul>
                </div>
            </div>
        </li>
        @if (Auth::user()->role==0)
        <li class="nav-item">
            <a class="nav-link {{ Request::routeIs('user.giohang') ? 'activemenu' : '' }}" data-bs-toggle="collapse" href="#collapseExample1" role="button"
                aria-expanded="false" aria-controls="collapseExample1">Giỏ hàng</a>

            <div class="collapse" id="collapseExample1">
                <div class="card card-body bg-success">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link " aria-current="page" href="{{ route('user.giohang') }}">Lịch sử mua hàng</a>
                        </li>
                    </ul>
                </div>
            </div>
  
        </li>
        @endif
        @if (Auth::user()->role==2)
        <li class="nav-item">
            <a class="nav-link {{ Request::routeIs('user.hoadon.index') ? 'activemenu' : '' }}" data-bs-toggle="collapse" href="#collapseExample3" role="button"
                aria-expanded="false" aria-controls="collapseExample3">Quản lý đơn hàng</a>

            <div class="collapse" id="collapseExample3">
                <div class="card card-body bg-success">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link " aria-current="page" href="{{ route('user.hoadon.index') }}">Hóa đơn</a>
                        </li>
                    </ul>
                </div>
            </div>
        </li>
        @endif
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dangxuat') }}">Đăng xuất</a>
        </li>
    </ul>
</header>
<header class="bg-success d-block d-md-none">
    <div class="container">
    <div class="row">
        <ul class="nav">
            <li class="nav-item">
              <a class="nav-link " href="{{ route('index') }}">Trang Mua hàng</a>
            </li>
            <li class="nav-item">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">chức năng</a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="{{ route('user.index') }}">Tài khoản</a></li>
                  <li><a class="dropdown-item" href="{{ route('user.updatepass') }}">Thây đỗi mật khẩu</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="{{ route('user.giohang') }}">kiểm tra hóa đơn</a></li>
                </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('dangxuat') }}">Đăng xuất</a>
            </li>
          </ul>
    </div>
</div>
</header>