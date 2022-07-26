<footer style="box-shadow: 0px 1px 5px rgb(0 0 0 / 10%);background-color: #fff;">
    <hr size="4" class="mt-4">
    <div>
        <div class="container">
            <div class="row g-3">
                <div class="col-12 col-md-4">
                    <div class="p-1 border bg-light">
                    <h4 class="pt-2">ShopN$M</h4>
                    <hr>
                    @foreach ($camket as $item)
                        <p>
                            <a>
                                <img src="{{ asset($item->img) }}" alt="kt" height="35px"
                                    width="30px">{{ $item->text }}
                            </a>
                        </p>
                    @endforeach
                </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="p-1 border bg-light">
                    <h4 class="pt-2">Danh mục sản phẩm</h4>
                    <hr>
                            @foreach ($loaisp as $item)
                                <p>{{ $item->name }}</p>
                            @endforeach
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="p-1 border bg-light">
                    <h4 class="pt-2">Liên hệ</h4>
                    <hr>
                            @foreach ($lienhe as $item)
                                <p>{{ $item->text }} </p>
                            @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-dark">
        <h4 class="text-center text-light py-2 ">CopyRight:ShopN$M</h4>
    </div>
</footer>
