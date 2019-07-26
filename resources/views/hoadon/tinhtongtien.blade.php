<?php
/**
 * Created by PhpStorm.
 * User: Tuyen
 * Date: 12-Jan-19
 * Time: 03:19 PM
 */
//    dd($danhsachphongtinhtongtien, $tongtien, $tiendatcoc, $id_hoadon);

?>

<?php //dd($_SESSION)
//dd($id_hoadon);
?>

@extends('layout/backend')

@section('content')

    <div align="center">
        <h2>Thông tin thanh toán</h2>
        <form action="{{ route('hoadon-thanhtoan') }}" method="post">
            <table class="table-bordered">
                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                <input type="hidden" name="txt_id_hoadon" value="{{ $id_hoadon }}">
                <?php foreach ($danhsachphongtinhtongtien as $phong){ ?>
                <tr>
                    <th style="padding: 10px; color: red">Tên phòng: </th>
                    <th style="padding: 10px; color: red">{{ $phong['phong']->tenphong }}</th>
                </tr>
                <tr>
                    <th style="padding: 5px">Giá phòng: </th>
                    <td>{{ number_format($phong['phong']->giadatphong_phong) }} VNĐ/ngày</td>
                </tr>
                <tr>
                    <th style="padding: 5px">Ngày nhận: </th>
                    <td>{{ $phong['phong']->ngaynhan_thucte }}</td>
                </tr>
                <tr>
                    <th style="padding: 5px">Ngày trả: </th>
                    <td>{{ $phong['phong']->ngaytra_thucte }}</td>
                </tr>
                <tr>
                    <th style="padding: 5px">Tiền phòng: </th>
                    <td>{{ number_format($phong['tienphong']) }} VNĐ</td>
                </tr>
                <tr>
                    <th style="padding: 5px" colspan="2">Dịch vụ: </th>
                </tr>
                <?php
                    if (!isset($phong['dichvu'])){
                        echo '<tr><td colspan="2">Không đặt dịch vụ</td></tr>';
                    } else{
                        foreach ($phong['dichvu'] as $dichvu){ ?>
                            <tr>
                                <th style="padding: 5px">Tên dịch vụ: </th>
                                <td>{{ $dichvu->tendichvu }}</td>
                            </tr>
                            <tr>
                                <th style="padding: 5px">Số lượng: </th>
                                <td>{{ number_format($dichvu->soluong) }} chiếc/cốc</td>
                            </tr>

                            <tr>
                                <th style="padding: 5px">Giá dịch vụ: </th>
                                <td>{{ number_format($dichvu->giadichvu) }} VNĐ</td>
                            </tr>
                <?php
                        }
                    }
                ?>

                <tr>
                    <th style="padding: 5px">Tiền dịch vụ: </th>
                    <td>{{ number_format($phong['tiendichvu']) }} VNĐ</td>
                </tr>

                <tr>
                    <td><hr></td>
                </tr>
                <?php } ?>

                <tr>
                    <th style="padding: 5px">Tổng tiền: </th>
                    <td>{{ number_format($tongtien) }} VNĐ</td>
                </tr>
                <tr>
                    <th style="padding: 5px">Tiền đặt cọc: </th>
                    <td>{{ number_format($tiendatcoc) }} VNĐ</td>
                </tr>
                <tr>
                    <th style="padding: 5px;">Thanh toán: </th>
                    <td style="color: red;">{{ number_format($tongtien - $tiendatcoc) }} VNĐ</td>
                    <input type="hidden" name="txt_tongtienthanhtoan" value="{{ $tongtien - $tiendatcoc }}">
                </tr>
            </table>
            <hr>
            <a href="{{route('hoadon-thanhtoan')}}">
                <button type="submit" class="btn btn-primary btn-sm">Thanh toán</button>
            </a>
        </form>

    </div>


@endsection
