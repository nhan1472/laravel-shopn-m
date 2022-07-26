<style>
    .activemenu {
        background-color: #0081f1;
        font-weight: 800;
    }

</style>

<header class="bg-success" style="height: 50em">
    <ul class="nav flex-column">
        <li class="nav-item mt-5">
            <a class="nav-link " href="{{ route('index') }}">Quay
                lại</a></a>
        </li>
        <li class="nav-item">
            <a class="nav-link  {{ Request::routeIs('admin.index') ? 'activemenu' : '' }}" data-bs-toggle="collapse"
                href="#collapseExample" role="button" aria-expanded="true" aria-controls="collapseExample">Tài
                khoản <i class="fa-regular fa-list-dropdown"></i></a>
            <div class="collapse" id="collapseExample">
                <div class="card card-body bg-success">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('admin.index') }}">Thông tin </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.resetpass') }}">Thay đỗi mật khẩu</a>
                        </li>
                    </ul>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::routeIs('user.giohang') ? 'activemenu' : '' }}" data-bs-toggle="collapse" href="#collapseExample2" role="button"
                aria-expanded="false" aria-controls="collapseExample2">Quản lý Trang</a>
            <div class="collapse" id="collapseExample2">
                <div class="card card-body bg-success">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link " aria-current="page" href="{{ route('admin.menu.index') }}">Header</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " aria-current="page" href="{{ route('admin.slider.index') }}">Slider</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " aria-current="page" href="{{ route('admin.footer.index') }}">Footer</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " aria-current="page" href="{{ route('admin.phanhoi.index') }}">Phản hồi</a>
                            <a class="nav-link " aria-current="page" href="{{ route('admin.thongke.index') }}">Thông kê</a>
                        </li>
                    </ul>
                </div>
            </div>
  
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::routeIs('user.giohang') ? 'activemenu' : '' }}" data-bs-toggle="collapse" href="#collapseExample1" role="button"
                aria-expanded="false" aria-controls="collapseExample1">Quản lý Sản phẩm</a>

            <div class="collapse" id="collapseExample1">
                <div class="card card-body bg-success">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link " aria-current="page" href="{{ route('admin.sanpham.index') }}">Sản phâm</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " aria-current="page" href="{{ route('admin.danhmuc.index') }}">Danh mục</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " aria-current="page" href="{{ route('admin.size.index') }}">Size</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " aria-current="page" href="{{ route('admin.sale.index') }}">Sale</a>
                        </li>
                    </ul>
                </div>
            </div>
  
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::routeIs('user.giohang') ? 'activemenu' : '' }}" data-bs-toggle="collapse" href="#collapseExample6" role="button"
                aria-expanded="false" aria-controls="collapseExample6">Quản lý Bài viết</a>
            <div class="collapse" id="collapseExample6">
                <div class="card card-body bg-success">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link " aria-current="page" href="{{ route('admin.tintuc.index') }}">Tin tức</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " aria-current="page" href="{{ route('admin.tintuc.danhmuc') }}">Danh mục</a>
                        </li>
                    </ul>
                </div>
            </div>
  
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::routeIs('user.giohang') ? 'activemenu' : '' }}" data-bs-toggle="collapse" href="#collapseExample3" role="button"
                aria-expanded="false" aria-controls="collapseExample2">Quản lý Hóa đơn</a>
            <div class="collapse" id="collapseExample3">
                <div class="card card-body bg-success">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link " aria-current="page" href="{{ route('admin.hoadon.index') }}">Hoa đơn</a>
                        </li>
                    </ul>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::routeIs('user.giohang') ? 'activemenu' : '' }}" data-bs-toggle="collapse" href="#collapseExample4" role="button"
                aria-expanded="false" aria-controls="collapseExample4">Quản lý User</a>
            <div class="collapse" id="collapseExample4">
                <div class="card card-body bg-success">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link " aria-current="page" href="{{ route('admin.user.index') }}">Khách hàng</a>
                            <a class="nav-link " aria-current="page" href="{{ route('admin.user.nhanvien') }}">Nhân viên</a>
                        </li>
                    </ul>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dangxuat') }}">Đăng xuất</a>
        </li>
    </ul>
</header>
