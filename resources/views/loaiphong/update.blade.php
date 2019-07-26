@extends('layout/backend')

@section('content')

<div align="center">
    <h2>Sửa thông tin Loại Phòng</h2>

    <form action="{{route('loaiphong-updatesave')}}" method="post" name="myForm" onsubmit="return validateForm()">
        <table class="table table-bordered">
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
            <input type="hidden" name="txt_id" value="{{ old('id_loaiphong', $getLoaiPhongById['id_loaiphong']) }}">
            <tr>
                <th>Tên loại phòng</th>
                <td>
                    <input class="form-control" type="text" name="txt_tenloaiphong" id="tenloaiphong" value="{{ old('ten', $getLoaiPhongById['tenloaiphong']) }}" >
                </td>
            </tr>
            <tr>
                <th>Giá</th>
                <td>
                    <input class="form-control" type="text" name="txt_giaphong" id="giaphong" value="{{ old('giaphong', $getLoaiPhongById['giaphong']) }}" >
                </td>
            </tr>
            <tr>
                <th>Mô tả</th>
                <td>
                    <textarea class="form-control" name="txt_mota" id="mota" cols="30" rows="10">{{ old('mota', $getLoaiPhongById['mota']) }}</textarea>
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