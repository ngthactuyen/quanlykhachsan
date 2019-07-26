@extends('layout/backend')

@section('content')

<div align="center">
    <h2>Chọn phòng khác cho Hóa đơn Đặt phòng có Id = {{ $getDatPhong_PhongById['datphong_id'] }}</h2>
    <?php
    echo '<h3>Ngày nhận phòng: '.$getDatPhongById[0]->ngaynhanphong.', Ngày trả phòng: '.$getDatPhongById[0]->ngaytraphong.'</h3>';

    if (isset($_SESSION['err_message'])){
        echo "<p style='color: red'>".$_SESSION['err_message']."</p>";
        unset($_SESSION['err_message']);
    }
    ?>
    <form action="{{route('datphong_phong-updatesave')}}" method="post" name="myForm" onsubmit="return validateForm()">
        <table class="table table-bordered">
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
            <input type="hidden" name="txt_id_datphong_phong" value="{{ old('id_datphong_phong', $getDatPhong_PhongById['id_datphong_phong']) }}">
            <input type="hidden" name="txt_getDatPhongById_ngaynhanphong" value="{{ $getDatPhongById[0]->ngaynhanphong }}">
            <input type="hidden" name="txt_getDatPhongById_ngaytraphong" value="{{ $getDatPhongById[0]->ngaytraphong }}">

            <tr>
                <th>Id Hóa đơn đặt phòng</th>
                <td>
                    <input type="text" name="txt_datphong_id" value="{{ old('datphong_id', $getDatPhong_PhongById['datphong_id']) }}">
                </td>
            </tr>
            <tr>
                <th>Tên phòng</th>
                <td>
                    <select name="sl_phong_id" id="phong_id">
                        <option value="">Chọn phòng</option>
                        <?php foreach ($phongList as $phong):?>
                        <option value="{{ $phong->id_phong }}" <?= ($phong->id_phong == old('phong_id', $getDatPhong_PhongById['phong_id']) )? 'selected': ''?> >{{ $phong->tenphong }}</option>
                        <?php endforeach?>
                    </select>
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