@extends('layout.in')
@section('title')
   phản hồi email
@endsection

@section('content')
    <div>
        <center>
            <h1>Phải hồi từ Shop N$M </h1>
            <table style=" border: 1px solid;width: 100%;">
                <tr style="padding: 15px 15px; font-size: 28px;">
                    <td style="  border: 1px solid; text-align: center;  height: 50px;">Đống góp ý kiến của {{$data[0]->name}}</td>
                    <td style="  border: 1px solid; text-align: left    ;  height: 50px;">{{$data[0]->noidung}}</td>
                </tr>
                <tr style="padding: 15px 15px; font-size: 28px;">
                    <td style="  border: 1px solid; text-align: center;  height: 50px;">trả lời</td>
                    <td style="  border: 1px solid; text-align: left;  height: 50px;">{{$noidung}}</td>
                </tr>
            </table>
        </center>
    </div>
@endsection
