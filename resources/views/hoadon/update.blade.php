@extends('layout/backend')

@section('content')

<div align="center">
    <h2>Sửa thông tin Dịch Vụ</h2>

    <form action="{{route('dichvu-updatesave')}}" method="post" name="myForm" onsubmit="return validateForm()">
        <table class="table table-bordered">
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
            <input type="hidden" name="txt_id" value="{{ old('id_dichvu', $getDichVuById['id_dichvu']) }}">
            <tr>
                <th>Tên dịch vụ</th>
                <td>
                    <input class="form-control" type="text" name="txt_tendichvu" id="tendichvu" value="{{ old('tendichvu', $getDichVuById['tendichvu']) }}" >
                </td>
            </tr>
            <tr>
                <th>Giá</th>
                <td>
                    <input class="form-control" type="text" name="txt_gia" id="gia" value="{{ old('gia', $getDichVuById['gia']) }}" >
                </td>
            </tr>
            <tr>
                <th>Mô tả</th>
                <td>
                    <textarea class="table table-bordered" name="txt_mota" id="mota" cols="30" rows="10">{{ old('mota', $getDichVuById['mota']) }}</textarea>
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