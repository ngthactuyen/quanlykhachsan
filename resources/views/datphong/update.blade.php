<?php //dd($ngaynhanphong);?>

@extends('layout/backend')

@section('content')

<div align="center">
    <h2>Sửa thông tin Đặt phòng</h2>
    <?php
    if (isset($_SESSION['err_message'])){
        echo "<p style='color: red'>".$_SESSION['err_message']."</p>";
        unset($_SESSION['err_message']);
    }
    ?>
    <form action="{{route('datphong-updatesave')}}" method="post" name="myForm" onsubmit="return validateForm()">
        <table class="table table-bordered">
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
            <input type="hidden" name="txt_id" value="{{ old('id_datphong', $getDatPhongById['id_datphong']) }}">
            <tr>
                <th>Tên khách hàng</th>
                <td>
                    <input class="form-control" type="text" name="txt_tenkh" id="tenkh" value="{{ old('tenkh', $getDatPhongById['tenkh']) }}" >
                </td>
            </tr>
            <tr>
                <th>Số CMND</th>
                <td>
                    <input class="form-control" type="text" name="txt_socmnd" id="socmnd" value="{{ old('socmnd', $getDatPhongById['socmnd']) }}" >
                </td>
            </tr>
            <tr>
                <th>Số điện thoại</th>
                <td>
                    <input class="form-control" type="text" name="txt_sdt" id="sdt" value="{{ old('sdt', $getDatPhongById['sdt']) }}" >
                </td>
            </tr>
            <tr>
                <th>Ngày nhận phòng</th>
                <td>
                    <input type="datetime-local" name="txt_ngaynhan_lythuyet" id="ngaynhan_lythuyet" value="<?php
                    echo $ngaynhan_lythuyet['nam'].'-'.$ngaynhan_lythuyet['thang'].'-'.$ngaynhan_lythuyet['ngay'].'T'.$ngaynhan_lythuyet['gio'].':'.$ngaynhan_lythuyet['phut'] ?>" min="date('Y-m-d')" max="">
                </td>
            </tr>
            <tr>
                <th>Ngày trả phòng</th>
                <td>
                    <input type="datetime-local" name="txt_ngaytra_lythuyet" id="ngaytra_lythuyet" value="<?php
                    echo $ngaytra_lythuyet['nam'].'-'.$ngaytra_lythuyet['thang'].'-'.$ngaytra_lythuyet['ngay'].'T'.$ngaytra_lythuyet['gio'].':'.$ngaytra_lythuyet['phut']
                    ?>" min="date('Y-m-d')" max="">
                </td>
            </tr>
            <tr>
                <th>Ghi chú</th>
                <td>
                    <textarea class="form-control" name="txt_ghichu" id="ghichu" cols="30" rows="10">
                        {{old('ghichu', $getDatPhongById['ghichu'])}}
                    </textarea>
                </td>
            </tr>
            <tr>
                <th>Tiền đặt cọc</th>
                <td>
                    <input class="form-control" type="text" name="txt_tiendatcoc" id="tiendatcoc" placeholder="VNĐ" value="{{ old('tiendatcoc', $getDatPhongById['tiendatcoc']) }}" >
                </td>
            </tr>
            <tr>
                <th>Trạng thái</th>
                <td>
                    <input type="radio" name="rd_trangthaidatphong" id="danhanphong" value="1" <?= (old('trangthaidatphong', $getDatPhongById['trangthaidatphong']) == 1) ? 'checked': ''?> >Đã đến nhận phòng
                    &emsp;&emsp;&emsp;&emsp;&emsp;
                    <input type="radio" name="rd_trangthaidatphong" id="chuanhanphong" value="0" <?= (old('trangthaidatphong', $getDatPhongById['trangthaidatphong']) == 0) ? 'checked': ''?> >Chưa đến nhận phòng
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input class="btn btn-primary btn-sm" type="submit" value="Sửa">
                </td>
            </tr>
        </table>
    </form>
</div>


@endsection