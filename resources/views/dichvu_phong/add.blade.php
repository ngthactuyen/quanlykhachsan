@extends('layout/backend')

@section('content')

<div align="center">
    <h2>Đặt dịch vụ</h2>

    <form action="{{route('dichvu_phong-addsave')}}" method="post" name="myForm" onsubmit="return validateForm()">
        <table class="table table-bordered">
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
            <input type="hidden" name="txt_phong_id" value="{{ $getPhongById[0]->id_phong }}">
            <tr>
                <th>Tên dịch vụ</th>
                <td>
                    <select class="form-control" name="sl_dichvu_id" id="dichvu_id">
                        <?php foreach ($dichvuList as $dichvu): ?>
                        <option value="{{ $dichvu->id_dichvu }}">{{ $dichvu->tendichvu }}</option>
                        <?php endforeach ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Giá</th>
                <td>
                    <input class="form-control" type="text" name="txt_giadichvu" id="giadichvu" placeholder="VNĐ">
                </td>
            </tr>
            <tr>
                <th>Số lượng</th>
                <td>
                    <input class="form-control" type="number" name="txt_soluong" id="soluong">
                </td>
            </tr>
            <tr>
                <th>Ghi chú</th>
                <td>
                    <textarea class="form-control" name="txt_ghichu" id="ghichu" cols="30" rows="10"></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input class="btn btn-primary btn-sm" type="submit" value="Đặt dịch vụ">
                </td>
            </tr>
        </table>
    </form>
</div>


@endsection