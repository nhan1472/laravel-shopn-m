@extends('layout.client')
@section('title')
    {{ $title }}
@endsection
@section('css')
    <style>
        ul {
            list-style: none;
            margin-bottom: 0px
        }

        .button {
            display: inline-block;
            background: #0e8ce4;
            border-radius: 5px;
            height: 48px;
            -webkit-transition: all 200ms ease;
            -moz-transition: all 200ms ease;
            -ms-transition: all 200ms ease;
            -o-transition: all 200ms ease;
            transition: all 200ms ease
        }

        .button a {
            display: block;
            font-size: 18px;
            font-weight: 400;
            line-height: 48px;
            color: #FFFFFF;
            padding-left: 35px;
            padding-right: 35px
        }

        .button:hover {
            opacity: 0.8
        }

        .cart_section {
            width: 100%;
            padding-top: 93px;
        }

        .cart_title {
            font-size: 30px;
            font-weight: 500
        }

        .cart_items {
            margin-top: 8px
        }

        .cart_list {
            border: solid 1px #e8e8e8;
            box-shadow: 0px 1px 5px rgba(0, 0, 0, 0.1);
            background-color: #fff
        }

        .cart_item {
            width: 100%;
            padding: 0px;
            padding-right: 46px
        }

        .cart_item_image {
            width: 133px;
            height: 133px;
            float: left
        }

        .cart_item_image img {
            max-width: 100%
        }

        .cart_item_info {
            width: calc(100% - 133px);
            float: left;
            padding-top: 18px
        }

        .cart_item_name {
            margin-left: 7.53%
        }

        .cart_item_title {
            font-size: 21px;
            font-weight: 400;
            color: rgba(0, 0, 0, 0.5)
        }

        .cart_item_text {
            font-size: 18px;
            margin-top: 35px
        }

        .cart_item_text span {
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            margin-right: 11px;
            -webkit-transform: translateY(4px);
            -moz-transform: translateY(4px);
            -ms-transform: translateY(4px);
            -o-transform: translateY(4px);
            transform: translateY(4px)
        }

        .cart_item_price {
            text-align: right
        }

        .cart_item_total {
            text-align: right
        }

        .order_total {
            width: 100%;
            height: 60px;
            margin-top: 30px;
            border: solid 1px #e8e8e8;
            box-shadow: 0px 1px 5px rgba(0, 0, 0, 0.1);
            padding-right: 46px;
            padding-left: 15px;
            background-color: #fff
        }

        .order_total_title {
            display: inline-block;
            font-size: 21px;
            color: rgba(0, 0, 0, 0.5);
            line-height: 60px
        }

        .order_total_amount {
            display: inline-block;
            font-size: 18px;
            font-weight: 500;
            margin-left: 26px;
            line-height: 60px
        }

        .cart_buttons {
            margin-top: 60px;
            text-align: center
        }

        .cart_button_clear {
            display: inline-block;
            border: none;
            font-size: 18px;
            font-weight: 400;
            line-height: 48px;
            color: rgba(0, 0, 0, 0.5);
            background: #FFFFFF;
            border: solid 1px #b2b2b2;
            padding-left: 35px;
            padding-right: 35px;
            outline: none;
            cursor: pointer;
            margin-right: 26px
        }

        .cart_button_clear:hover {
            border-color: #0e8ce4;
            color: #0e8ce4
        }

        .cart_button_checkout {
            display: inline-block;
            border: none;
            font-size: 18px;
            font-weight: 400;
            line-height: 48px;
            color: #FFFFFF;
            padding-left: 35px;
            padding-right: 35px;
            outline: none;
            cursor: pointer;
            vertical-align: top
        }

        .cart_button_checkout:disabled {
            background: #dddddd;
            cursor: no-drop;
        }
    </style>
@endsection
@section('content')
    <div class="cart_section">
        <div class="container-fluid">
            <div class="row">
                @php $sl = 0 @endphp
                @if (session('cart'))
                    @foreach (session('cart') as $id => $items)
                        @php $sl +=  $items['sl'] @endphp
                    @endforeach
                @endif
                <div class="col-md-1 col-1"></div>
                <div class="col-md-10   col-10">
                    <div class="cart_container">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                @if (session('success1'))
                                    <a href="{{ route('user.giohang') }}"> Xem hóa đơn</a>
                                @endif
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="cart_title  d-none d-md-block">Giỏ hàng của bạn<small> ({{ $sl }} sản phẩm
                                trông
                                giỏ) </small>
                        </div>
                        <div class="cart_title text-center  d-block d-md-none">Giỏ hàng của bạn<small> ({{ $sl }}
                                sản phẩm trông giỏ) </small>
                        </div>
                        <div class="cart_items">
                            @php
                                $total = 0;
                            @endphp
                            @if (session('cart'))
                                <div class="d-none d-md-block">
                                    <table class="table"
                                        style="background-color: #fff;min-height: 300px;
                                         border: solid 1px #e8e8e8;box-shadow: 0px 1px 5px rgba(0, 0, 0, 0.1);">
                                        <thead>
                                            <tr style="font-size:24px ">
                                                <th>STT</th>
                                                <th>ảnh</th>
                                                <th>Tên sản phẩm</th>
                                                <th>Size</th>
                                                <th>Số lượng</th>
                                                <th>Giá</th>
                                                <th>Thành tiền</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (session('cart') as $id => $items)
                                                <tr class="fw h4 align-items-center">
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td><img src="{{ $items['img'] }}"
                                                            style="max-height: 75px;width: 100px;"
                                                            alt="{{ $items['ten'] }}"></td>
                                                    <td>{{ $items['ten'] }}</td>
                                                    <td>{{ $items['size'] }}</td>
                                                    <td class="d-flex">
                                                        @if ($items['sl'] > 1)
                                                            <form action="{{ route('cart.giam') }} " method="post">
                                                                @csrf
                                                                <input type="hidden" name="id"
                                                                    value="{{ $items['id'] }}">
                                                                <button type="submit" class="btn btn-primary">-</button>
                                                            </form>
                                                        @endif
                                                        {{ $items['sl'] }}
                                                        @if ($items['sl'] >= 1)
                                                            <form action="{{ route('cart.tang') }} " method="post">
                                                                @csrf
                                                                <input type="hidden" name="id"
                                                                    value="{{ $items['id'] }}">
                                                                <button type="submit" class="btn btn-primary">+</button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                    <td> {{ number_format(($items['gia'] * (100 - $items['giamgia'])) / 100) }}Đ
                                                    </td>
                                                    <td>{{ number_format((($items['gia'] * (100 - $items['giamgia'])) / 100) * $items['sl']) }}Đ
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('cart.remove') }} " method="post">
                                                            @csrf
                                                            <input type="hidden" name="id"
                                                                value="{{ $items['id'] }}">
                                                            <button type="submit" class="btn btn-danger xoa">X</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                @php $total += $items['gia']*(100-$items['giamgia'])/100 * $items['sl'] @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-block d-md-none">
                                    <table class="table"
                                        style="background-color: #fff;min-height: 300px;
                                         border: solid 1px #e8e8e8;box-shadow: 0px 1px 5px rgba(0, 0, 0, 0.1);">
                                        <tbody class="fw h6 align-items-center">
                                            @foreach (session('cart') as $id => $items)
                                                <tr class="h4">
                                                    <td>TênSP</td>
                                                    <td>{{ $items['ten'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Ảnh</td>
                                                    <td>
                                                        <img src="{{ $items['img'] }}"
                                                            style="max-height: 35px;width: 50px;"
                                                            alt="{{ $items['ten'] }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Size</td>
                                                    <td>{{ $items['size'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td>số lượng</td>
                                                    <td class="d-flex">
                                                        @if ($items['sl'] > 1)
                                                            <form action="{{ route('cart.giam') }} " method="post">
                                                                @csrf
                                                                <input type="hidden" name="id"
                                                                    value="{{ $items['id'] }}">
                                                                <button type="submit" class="btn btn-primary">-</button>
                                                            </form>
                                                        @endif
                                                        {{ $items['sl'] }}
                                                        @if ($items['sl'] >= 1)
                                                            <form action="{{ route('cart.tang') }} " method="post">
                                                                @csrf
                                                                <input type="hidden" name="id"
                                                                    value="{{ $items['id'] }}">
                                                                <button type="submit" class="btn btn-primary">+</button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>giá</td>
                                                    <td> {{ number_format(($items['gia'] * (100 - $items['giamgia'])) / 100) }}Đ
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>thành tiền</td>
                                                    <td>{{ number_format((($items['gia'] * (100 - $items['giamgia'])) / 100) * $items['sl']) }}Đ
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>
                                                        <form action="{{ route('cart.remove') }} " method="post">
                                                            @csrf
                                                            <input type="hidden" name="id"
                                                                value="{{ $items['id'] }}">
                                                            <button type="submit" class="btn btn-danger xoa">X</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <hr size="4 my-2">
                                                    </td>
                                                </tr>
                                                @php $total += $items['gia']*(100-$items['giamgia'])/100 * $items['sl'] @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <li class="cart_item clearfix d-none d-md-block"
                                    style="background-color:#fff; border: solid 1px #e8e8e8;
                                 box-shadow: 0px 1px 5px rgba(0, 0, 0, 0.1); ">
                                    <div class="cart_item_info d-flex flex-md-row flex-column justify-content-between">

                                        <div class="cart_item_quantity cart_info_col" style="margin: auto">
                                            <img src="{{ asset('img/rong.png') }}" class="ms-5 my-5"
                                                alt="không có sản phẩm">
                                            <h2 class="text-danger mb-2">Không có sản phẩm trong giỏ</h2>
                                        </div>
                                    </div>
                                </li>
                                <div class="row d-block d-md-none"
                                    style="background-color:#fff;min-height:200px;border: solid 1px #e8e8e8;
                                box-shadow: 0px 1px 5px rgba(0, 0, 0, 0.1);width:100%;margin: auto;">
                                    <div class="col-12">
                                        <img src="{{ asset('img/rong.png') }}" class="mt-3 mx-5" style="max-height: 100px;"
                                            alt="không có sản phẩm">
                                        <h2 class="text-danger text-center">Không có sản phẩm trong giỏ</h2>
                                    </div>
                                </div>
                            @endif
                            <div class="order_total d-none d-md-block">
                                <div class="order_total_content text-md-right">
                                    <div class="order_total_title">Tổng tiền:</div>
                                    <div class="order_total_amount">{{ number_format($total) }}Đ</div>
                                </div>
                            </div>
                            <div class="row d-block d-md-none mb-2"  style="background-color:#fff; border: solid 1px #e8e8e8;
                            box-shadow: 0px 1px 5px rgba(0, 0, 0, 0.1); ">
                                    <div class="col-10 ps-5 p2-4">Tổng tiền {{ number_format($total) }}Đ</div>
                            </div>
                            <div class="cart_buttons mb-3 d-none d-md-block"> <a
                                    href="{{ route('sanpham.index') }}"><button type="button"
                                        class="button cart_button_clear">quay về
                                    </button></a>
                                @if ($sl > 0)
                                    <button type="button" class="button cart_button_checkout" onclick="kt()"
                                        id="thanhtoan">Đặt hàng
                                    </button>
                                @else
                                    <button type="button" class="button cart_button_checkout " disabled="disabled">Đặt
                                        hàng
                                    </button>
                                @endif
                            </div>
                            <div class="row mb-3 d-block d-md-none">

                                <a href="{{ route('sanpham.index') }}" class="col-6"><button type="button"
                                        class="btn btn-outline-secondary  btn-sm  ">quay về
                                    </button></a>
                                @if ($sl > 0)
                                    <button type="button" class="btn btn-outline-primary btn-sm col-6 " onclick="kt()"
                                        id="thanhtoan">Đặt hàng
                                    </button>
                                @else
                                    <button type="button" class="btn btn-outline-primary btn-sm col-6 "
                                        disabled="disabled">Đặt
                                        hàng
                                    </button>
                                @endif
                            </div>
                            {{-- {{ Auth::user()->email }} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('js')
        <script>
            for (i = 0; i < document.getElementsByClassName("xoa").length; i++) {
                document.getElementsByClassName("xoa")[i].addEventListener("click", function(event) {
                    if (!confirm("bạn có muốn xóa sản phẩm này không")) {
                        event.preventDefault()
                    }
                });
            }

            @guest

            function kt() {
                if (confirm("bạn Chưa đăng nhập \n đăng nhập để thanh toán")) {
                    window.location = "{{ route('dangnhap') }}";
                }

            }
            @else
                function kt() {
                    window.location = " {{ route('cart.dathang') }}"
                }
            @endguest
        </script>
    @endsection
