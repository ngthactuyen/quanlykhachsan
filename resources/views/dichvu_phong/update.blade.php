<?php //dd($getDichVu_PhongById);?>
@extends('layout/backend')

@section('content')

<div align="center">
    <h2>Sửa thông tin Đặt dịch vụ</h2>

    <form action="{{route('dichvu_phong-updatesave')}}" method="post" name="myForm" onsubmit="return validateForm()">
        <table class="table table-bordered">
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
            <input type="hidden" name="txt_id_dichvu_phong" value="{{ old('id_dichvu_phong', $getDichVu_PhongById['id_dichvu_phong']) }}">
            <input type="hidden" name="txt_phong_id" value="{{ old('phong_id', $getDichVu_PhongById['phong_id']) }}">
            <tr>
                <th>Tên dịch vụ</th>
                <td>
                    <select class="form-control" name="sl_dichvu_id" id="dichvu_id">
                        <?php foreach ($dichvuList as $dichvu): ?>
                        <option value="{{ $dichvu->id_dichvu }}" <?= ($getDichVu_PhongById['dichvu_id'] == $dichvu->id_dichvu) ? 'selected': ''?> >{{ $dichvu->tendichvu }}</option>
                        <?php endforeach ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Giá</th>
                <td>
                    <input class="form-control" type="text" name="txt_giadichvu" id="giadichvu" value="{{ old('giadichvu', $getDichVu_PhongById['giadichvu']) }}" >
                </td>
            </tr>
            <tr>
                <th>Số lượng</th>
                <td>
                    <input class="form-control" type="number" name="txt_soluong" id="soluong" value="{{ $getDichVu_PhongById['soluong'] }}">
                </td>
            </tr>
            <tr>
                <th>Ghi chú</th>
                <td>
                    <textarea class="form-control" name="txt_ghichu" id="ghichu" cols="30" rows="10">{{ $getDichVu_PhongById['ghichu'] }}</textarea>
                </td>
            </tr>
            <input type="hidden" name="rd_trangthaidichvu_phong" value="{{ $getDichVu_PhongById['trangthaidichvu_phong'] }}">
            <tr>
                <td colspan="2" align="center">
                    <input class="btn btn-primary btn-sm" type="submit" value="Sửa">
                </td>
            </tr>
        </table>
    </form>
</div>


@endsection