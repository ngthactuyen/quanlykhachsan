@extends('layout/backend')

@section('content')

<div align="center">
    <h2>Sửa thông tin Phòng</h2>

    <form action="{{route('phong-updatesave')}}" method="post" name="myForm" onsubmit="return validateForm()">
        <table class="table table-bordered">
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
            <input type="hidden" name="txt_id" value="{{ old('id_phong', $getPhongById['id_phong']) }}">
            <tr>
                <th>Tên phòng</th>
                <td>
                    <input class="form-control" type="text" name="txt_tenphong" id="tenphong" value="{{ old('tenphong', $getPhongById['tenphong']) }}" >
                </td>
            </tr>
            <tr>
                <th>Loại phòng</th>
                <td>
                    <select name="sl_loaiphong" id="loaiphong">
                        <?php foreach ($loaiphongList as $loaiphong): ?>
                        <option value="{{$loaiphong['id_loaiphong']}}" <?= (old('loaiphong_id', $getPhongById['loaiphong_id']) == $loaiphong['id_loaiphong']) ? 'selected': '' ?> >{{$loaiphong['tenloaiphong']}}</option>
                        <?php endforeach ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Trạng thái</th>
                <td>
                    <input type="radio" name="rd_trangthaiphong" id="cokhach" value="1" <?= (old('trangthaiphong', $getPhongById['trangthaiphong']) == 1) ? 'checked': ''?> >Có khách
                    &emsp;&emsp;&emsp;&emsp;&emsp;
                    <input type="radio" name="rd_trangthaiphong" id="khongcokhach" value="0" <?= (old('trangthaiphong', $getPhongById['trangthaiphong']) == 0) ? 'checked': ''?> >Không có khách
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