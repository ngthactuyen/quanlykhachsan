@extends('layout/backend')

@section('content')

<div align="center">
    <h2>Thêm mới Hóa đơn</h2>

    <form action="{{route('hoadon-chonphongthanhtoan')}}" method="post" name="myForm" onsubmit="return validateForm()">
        <table class="table table-bordered">
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
            <tr>
                <th style="width: 300px; ">Tên khách hàng</th>
                <td>
                    <input class="form-control" type="text" name="txt_tenkh" id="tenkh">
                </td>
            </tr>
            <tr>
                <th>Số CMND</th>
                <td>
                    <input class="form-control" type="text" name="txt_socmnd" id="socmnd">
                </td>
            </tr>
            <tr>
                <th>Số SĐT</th>
                <td>
                    <input class="form-control" type="text" name="txt_sdt" id="sdt">
                </td>
            </tr>
            <tr>
                <th>Người lập hóa đơn</th>
                <td>
                    <input class="form-control" type="text" name="" id="" value="{{ $_SESSION['tenNhanVien'] }}" disabled>
                    <input class="form-control" type="hidden" name="txt_nguoilap_id" id="nguoilap_id" value="{{ $_SESSION['idNhanVien'] }}">
                </td>
            </tr>
            <tr>
                <th>Ngày lập hóa đơn</th>
                <td>
                    <?php
                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                    echo '<input class="form-control" type="text" name="txt_ngaytao" id="ngaytao" value="'.date('Y-m-d H:i').'">';
                    ?>

                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input class="btn btn-primary btn-sm" type="submit" value="Chọn phòng thanh toán">
                </td>
            </tr>
        </table>
    </form>
</div>


@endsection