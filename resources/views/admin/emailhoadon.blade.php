@extends('layout.in')
@section('title')
    In hóa đơn
@endsection

@section('content')
    <div>
        <center>
            <p style="font-size: 48px;font-weight: 700">Hóa đơn Shop N$M</p>
        </center>
        <hr size="4">
        <br>
        <h1>vào lúc: {{ $startTime = date('H:i:s d-m-Y ') }}</h1>
        <h1>Mã hóa đơn :{{ $data[0]->id }} </h1>
        @php
            $mang = DB::select('SELECT * FROM `cthd` WHERE `idct`=?', [$data[0]->id]);
        @endphp
        <table style=" border: 1px solid;width: 100%;">
            <tr style="padding: 15px 15px; font-size: 28px;">
                <th style="  border: 1px solid; text-align: center;  height: 50px;">STT</th>
                <th style="  border: 1px solid; text-align: center;  height: 50px;">Tên</th>
                <th style="  border: 1px solid; text-align: center;  height: 50px;">Size</th>
                <th style="  border: 1px solid; text-align: center;  height: 50px;">Số lượng</th>
                <th style="  border: 1px solid; text-align: center;  height: 50px;">Giá</th>
                <th style="  border: 1px solid; text-align: center;  height: 50px;">Thành tiền</th>
            </tr>
            @foreach ($mang as $index => $row)
                <tr style="padding: 15px 15px; font-size: 28px;">
                    <td style="  border: 1px solid; text-align: center;  height: 50px;">{{ $index + 1 }}</td>
                    <td style="  border: 1px solid; text-align: center;  height: 50px;">{{ $row->ten }}</td>
                    <td style="  border: 1px solid; text-align: center;  height: 50px;">{{ $row->size }}</td>
                    <td style="  border: 1px solid; text-align: center;  height: 50px;">{{ $row->sl }}</td>
                    <td style="  border: 1px solid; text-align: center;  height: 50px;">{{ number_format(($row->gia * (100 - $row->giamgia)) / 100) }}</td>
                    <td style="  border: 1px solid; text-align: center;  height: 50px;">{{ number_format(($row->sl * $row->gia * (100 - $row->giamgia)) / 100) }}</td>
                </tr>
            @endforeach
            <tr style="padding: 15px 15px; font-size: 28px;">
                <td style="  border: 1px solid; text-align: center;  height: 50px;">Tổng sô lượng:</td>
                <td style="  border: 1px solid; text-align: center;  height: 50px;" colspan="2">{{ $data[0]->tongsl }}</td>
                <td style="  border: 1px solid; text-align: center; height: 50px;">Tổng tiền:</td>
                <td style="  border: 1px solid; text-align: center;  height: 50px;" colspan="2">{{ number_format($data[0]->tong) }}</td>
            </tr>
        </table>
        <h1>Tên khách hàng : {{Auth::user()->name}}</h1>
        @php
           $user = DB::select('SELECT * FROM `ctusers` WHERE `iduser`=?', [Auth::user()->id]);
        @endphp
        <h1>Đại chỉ : {{$user[0]->daichi}}</h1>
        <h1>SDT : {{$user[0]->sdt}}</h1>
    </div>
@endsection
