@extends('layout.client')
@section('title')
    {{ $title }}
@endsection
@section('css')
    <Style>
        .timeline {
            position: relative;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* The actual timeline (the vertical ruler) */
        .timeline::after {
            content: '';
            position: absolute;
            width: 6px;
            background-color: white;
            top: 0;
            bottom: 0;
            left: 50%;
            margin-left: -3px;
        }

        /* Container around content */
        .card {
            padding: 10px 40px;
            position: relative;
            background-color: inherit;
            width: 50%;
        }

        /* The circles on the timeline */
        .card::after {
            content: '';
            position: absolute;
            width: 25px;
            height: 25px;
            right: -17px;
            background-color: white;
            border: 4px solid #FF9F55;
            top: 15px;
            border-radius: 50%;
            z-index: 1;
        }

        /* Place the container to the left */
        .left {
            left: 0;
        }

        /* Place the container to the right */
        .right {
            left: 50%;
        }

        /* Add arrows to the left container (pointing right) */
        .left::before {
            content: " ";
            height: 0;
            position: absolute;
            top: 22px;
            width: 0;
            z-index: 1;
            right: 30px;
            border: medium solid white;
            border-width: 10px 0 10px 10px;
            border-color: transparent transparent transparent white;
        }

        /* Add arrows to the right container (pointing left) */
        .right::before {
            content: " ";
            height: 0;
            position: absolute;
            top: 22px;
            width: 0;
            z-index: 1;
            left: 30px;
            border: medium solid white;
            border-width: 10px 10px 10px 0;
            border-color: transparent white transparent transparent;
        }

        /* Fix the circle for containers on the right side */
        .right::after {
            left: -16px;
        }

        /* The actual content */
        .content {
            padding: 20px 30px;
            background-color: white;
            position: relative;
            border-radius: 6px;
        }

        /* Media queries - Responsive timeline on screens less than 600px wide */
        @media screen and (max-width: 600px) {

            /* Place the timelime to the left */
            .timeline::after {
                left: 31px;
            }

            /* Full-width containers */
            .card {
                width: 100%;
                padding-left: 70px;
                padding-right: 25px;
            }

            /* Make sure that all arrows are pointing leftwards */
            .card::before {
                left: 60px;
                border: medium solid white;
                border-width: 10px 10px 10px 0;
                border-color: transparent white transparent transparent;
            }

            /* Make sure all circles are at the same spot */
            .left::after,
            .right::after {
                left: 15px;
            }

            /* Make all right containers behave like the left ones */
            .right {
                left: 0%;
            }
        }

        .title1 {
            color: #fff;
            font-size: 65px;
            font-weight: 600;
            font-family: "Roboto";
            font-style: normal;
            line-height: 70px;
            margin-bottom: 20px;
            text-align: center;
        }
        .content2{
            color: #fff;
            font-size: 35px;
            font-weight: 600;
            font-family: "Roboto";
            font-style: normal;
            line-height: 70px;
            margin-bottom: 10px;
            text-align: left;
        }
    </Style>
@endsection
@section('content')
    <div class="img mt-5" style="background: #3c87ff">
        <div class="container ">
        
            <div class="title1 mt-5 ">
                 ShopN$M
            </div>
            <div class="content2 mb-5">
                Về chung tôi chuyên cung cấp các sản phẩm thời trang đảm bảo chất lượng. <br>
                    @foreach ($camket as $item)
                        -{{$item->text}} <br>
                    @endforeach
            </div>
        </div>
    </div>
    <div class="container" style="background-color: #ccc">
        <h1 class="title1 text-dark mt-2">Các cột mốc quan trọng</h1>
        <div class="timeline my-5">
            @foreach ($cotmoc as $item )
            <div class="card {{$item->type}}">
                <div class="content">
                    <h2>{{$item->title}}</h2>
                    <p>{{$item->text}}</p>
                </div>
            </div>
            @endforeach
        </div>
        <br><br>
    </div>
    <div class="container my-4">
        <div class="row">
            <div class="col-6 border-end">
                <h1 class="title1 text-dark">Địa chỉ</h1>
                <h4>Quận 6 thành phố Hồ Chí Minh</h4>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15679.428574286572!2d106.6293227345053!3d10.745491458978103!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752e7cff633fdd%3A0x85ee85db9cb263ba!2zUXXhuq1uIDYsIFRow6BuaCBwaOG7kSBI4buTIENow60gTWluaCwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1652620862173!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="col-6 border-start">
                <h1 class="title1 text-dark">Liên hệ</h1>
                <form method="post" action="{{ route('phanhoi') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Họ và tên</label>
                        <input type="text" required class="form-control" name="name" id="name" >
                      </div>
                    <div class="mb-3">
                      <label for="email" class="form-label">Email liên hệ</label>
                      <input type="email" required class="form-control"  name="email" id="email">
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" required name="noidung" style="height: 250px"  id="noidung"></textarea>
                        <label for="noidung">Nội dung</label>
                      </div>
                      <i>* đong gói ý kiển để shop có thể cải thiện tốt hơn</i><br>
                      <i>* liện hệ phân phối sản phẩm thời trang</i><br>
                      <i>* gửi các phản ánh về sản phẩm</i><br>
                      <i>* các phản hồi của shop sẽ được gửi lại email của bạn</i><br>
                    <button type="submit" class="btn btn-primary">Gửi</button>
                  </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
         @if (session('success'))
                alert("{{ session('success') }}")            
            @endif
    </script>
@endsection
