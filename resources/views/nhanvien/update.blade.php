@extends('layout/backend')

@section('content')

<div align="center">
    <h2>Sửa thông tin Nhân Viên</h2>

    <form action="{{route('nhanvien-updatesave')}}" method="post" name="myForm" onsubmit="return validateForm()">
        <table class="table table-bordered">
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
            <input type="hidden" name="txt_id" value="{{ old('id', $getNhanVienById['id']) }}">
            <tr>
                <th>Họ tên</th>
                <td>
                    <input class="form-control" type="text" name="txt_hoten" id="hoten" value="{{ old('hoten', $getNhanVienById['hoten']) }}" >
                </td>
            </tr>
            <tr>
                <th>Giới tính</th>
                <td>
                    <input type="radio" name="rd_gioitinh" id="nam" value="1" <?= (old('gioitinh', $getNhanVienById['gioitinh']) == 1) ? 'checked': ''?> >Nam
                    &emsp;&emsp;&emsp;&emsp;&emsp;
                    <input type="radio" name="rd_gioitinh" id="nu" value="0" <?= (old('gioitinh', $getNhanVienById['gioitinh']) == 0) ? 'checked': ''?> >Nữ
                </td>
            </tr>
            <tr>
                <th>Địa chỉ</th>
                <td>
                    <input class="form-control" type="text" name="txt_diachi" id="diachi" value="{{ old('diachi', $getNhanVienById['diachi']) }}" >
                </td>
            </tr>
            <tr>
                <th>Email</th>
                <td>
                    <input class="form-control" type="text" name="txt_email" id="email" value="{{ old('email', $getNhanVienById['email']) }}" >
                </td>
            </tr>
            <tr>
                <th>Số ĐT</th>
                <td>
                    <input class="form-control" type="text" name="txt_sdt" id="sdt" value="{{ old('sdt', $getNhanVienById['sdt']) }}" >
                </td>
            </tr>
            <tr>
                <th>Số CMND</th>
                <td>
                    <input class="form-control" type="text" name="txt_socmnd" id="socmnd"  value="{{ old('socmnd', $getNhanVienById['socmnd']) }}" >
                </td>
            </tr>
            <tr>
                <th>Tên đăng nhập</th>
                <td>
                    <input class="form-control" type="text" name="txt_tendangnhap" id="tendangnhap" value="{{ old('tendangnhap', $getNhanVienById['tendangnhap']) }}" >
                </td>
            </tr>
            <tr>
                <th>Mật khẩu</th>
                <td>
                    <input class="form-control" type="text" name="txt_matkhau" id="matkhau" value="{{ old('matkhau', $getNhanVienById['matkhau']) }}" >
                </td>
            </tr>
            <tr>
                <th>Phân quyền</th>
                <td>
                    <select name="sl_phanquyen" id="">
                        <option value="1" <?= (old('phanquyen', $getNhanVienById['phanquyen']) == 1) ? 'selected': '' ?> >Admin</option>
                        <option value="0" <?= (old('phanquyen', $getNhanVienById['phanquyen']) == 0) ? 'selected': '' ?> >Nhân Viên</option>
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