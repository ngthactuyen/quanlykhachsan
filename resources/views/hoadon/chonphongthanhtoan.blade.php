<?php //dd($_SESSION)
//dd($id_hoadon);
?>

@extends('layout/backend')

@section('content')

<div align="center">
    <h2>Danh sách Phòng</h2>
    <hr>
    <form action="{{ route('hoadon-tinhtongtien') }}" method="post">
        <table class="table-bordered">
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
            <tr>
                <td></td>
                <th style="width: 100px;padding: 10px;">Tên phòng</th>
                <th style="width: 200px;padding: 10px;">Loại phòng</th>
            </tr>
            <?php foreach ($phongList as $phong): ?>
            <tr>
                <td style="width: 50px; padding: 10px;">
                    <input type="checkbox" name="cb_phongList[]" value="{{$phong->id_phong}}">
                </td>
                <td>{{$phong->tenphong}}</td>
                <td>{{$phong->tenloaiphong}}</td>
            </tr>
            <?php endforeach ?>
            <input type="hidden" name="txt_hoadon_id" value="{{ $id_hoadon }}">
        </table>
        <hr>
        <a href="{{route('hoadon-tinhtongtien')}}">
            <button type="submit" class="btn btn-primary btn-sm">Tính tổng tiền</button>
        </a>
    </form>

    {{--{!!$phongList->render()!!}--}}
{{--    {!!$phongList->links()!!}--}}
</div>


@endsection