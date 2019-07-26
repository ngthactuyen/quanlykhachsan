@extends('layout/backend')

@section('content')

<div align="center">
    <h2>Thêm mới Loại Phòng</h2>

    <form action="{{route('loaiphong-addsave')}}" method="post" name="myForm" onsubmit="return validateForm()">
        <table class="table table-bordered">
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
            <tr>
                <th>Tên loại phòng</th>
                <td>
                    <input class="form-control" type="text" name="txt_tenloaiphong" id="tenloaiphong">
                </td>
            </tr>
            <tr>
                <th>Giá</th>
                <td>
                    <input class="form-control" type="text" name="txt_giaphong" id="giaphong" placeholder="VNĐ">
                </td>
            </tr>
            <tr>
                <th>Mô tả</th>
                <td>
                    <textarea class="form-control" name="txt_mota" id="mota" cols="30" rows="10"></textarea>
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