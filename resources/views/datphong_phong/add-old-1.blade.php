@extends('layout/backend')

@section('content')

<div align="center">
    <h2>Chọn phòng cho Hóa đơn Đặt phòng có Id = {{$getDatPhongById['id_datphong']}}</h2>

    <?php
    echo '<h3>Ngày nhận phòng: '.$getDatPhongById['ngaynhanphong'].', Ngày trả phòng: '.$getDatPhongById['ngaytraphong'].'</h3>';

    if (isset($_SESSION['err_message'])){
        echo "<p style='color: red'>".$_SESSION['err_message']."</p>";
        unset($_SESSION['err_message']);
    }
    ?>
    <form action="{{route('datphong_phong-addsave')}}" method="post" name="myForm" onsubmit="return validateForm()">
        <table class="table table-bordered">
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />

            {{--<input type="hidden" name="txt_datphong_id" value="{{{ $getDatPhongById['id_datphong'] }}}" />--}}
            {{--<tr>--}}
                {{--<th>Tên phòng</th>--}}
                {{--<th>Tên loại phòng</th>--}}
                {{--<th>Mô tả</th>--}}
                {{--<th>Chọn phòng</th>--}}
            {{--</tr>--}}

            <?php
//            foreach ($datphong_phongList as $datphong_phong){
//                if (strtotime($getDatPhongById['ngaynhanphong']) > strtotime($datphong_phong->ngaytraphong) || strtotime($getDatPhongById['ngaytraphong']) < strtotime($datphong_phong->ngaynhanphong) ){
//                    echo '<tr><td>'.$datphong_phong->tenphong.'</td>';
//                    echo '<td>'.$datphong_phong->tenloaiphong.'</td>';
//                    echo '<td>'.$datphong_phong->mota.'</td>';
//                    echo '<td><input type="checkbox" value="'.$datphong_phong->id_phong.'"></td></tr>';
//                }
//            }
            ?>

            {{--<?php foreach ($phongList as $phong):?>--}}
            {{--<tr>--}}
                {{--<td>{{$phong->tenphong}}</td>--}}
                {{--<td>{{$phong->tenloaiphong}}</td>--}}
                {{--<td>{{$phong->mota}}</td>--}}
                {{--<td>--}}
                    {{--<input type="checkbox" name="cb_id_phong" value="{{$phong->id_phong}}">--}}
                {{--</td>--}}
            {{--</tr>--}}
            {{--<?php endforeach?>--}}

            <input type="hidden" name="txt_getDatPhongById_ngaynhanphong" value="{{ $getDatPhongById['ngaynhanphong'] }}">
            <input type="hidden" name="txt_getDatPhongById_ngaytraphong" value="{{ $getDatPhongById['ngaytraphong'] }}">
            <tr>
                <th>Id Hóa đơn đặt phòng</th>
                <td>
                    <input type="text" name="txt_datphong_id" value="{{ $getDatPhongById['id_datphong']  }}">
                </td>
            </tr>
            <tr>
                <th>Tên phòng</th>
                <td>
                    <select name="sl_phong_id" id="phong_id">
                        <option value="">Chọn phòng</option>
                        <?php foreach ($phongList as $phong):?>
                        <option value="{{ $phong->id_phong }}">{{ $phong->tenphong }}</option>
                        <?php endforeach?>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input class="btn btn-primary btn-sm" type="submit" value="Thêm mới">
                </td>
            </tr>
        </table>
    </form>
</div>



@endsection