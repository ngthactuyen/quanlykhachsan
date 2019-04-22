@extends('layout/backend')

@section('content')

<div align="center">
    <h2>Thêm mới Khách Hàng</h2>

    <form action="{{route('khachhang-addsave')}}" method="post" name="myForm" onsubmit="return validateForm()">
        <table class="table table-bordered">
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
            <tr>
                <th>Họ tên</th>
                <td>
                    <input class="form-control" type="text" name="txt_hoten" id="hoten">
                </td>
            </tr>
            <tr>
                <th>Giới tính</th>
                <td>
                    <input type="radio" name="rd_gioitinh" id="nam" value="1">Nam
                    &emsp;&emsp;&emsp;&emsp;&emsp;
                    <input type="radio" name="rd_gioitinh" id="nu" value="0">Nữ
                </td>
            </tr>
            <tr>
                <th>Địa chỉ</th>
                <td>
                    <input class="form-control" type="text" name="txt_diachi" id="diachi">
                </td>
            </tr>
            <tr>
                <th>Email</th>
                <td>
                    <input class="form-control" type="text" name="txt_email" id="email">
                </td>
            </tr>
            <tr>
                <th>Số ĐT</th>
                <td>
                    <input class="form-control" type="text" name="txt_sdt" id="sdt">
                </td>
            </tr>
            <tr>
                <th>Số CMND</th>
                <td>
                    <input class="form-control" type="text" name="txt_socmnd" id="socmnd">
                </td>
            </tr>
            <tr>
                <th>Tên đăng nhập</th>
                <td>
                    <input class="form-control" type="text" name="txt_tendangnhap" id="tendangnhap">
                </td>
            </tr>
            <tr>
                <th>Mật khẩu</th>
                <td>
                    <input class="form-control" type="text" name="txt_matkhau" id="matkhau">
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