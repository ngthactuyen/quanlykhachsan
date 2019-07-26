@extends('layout/backend')

@section('content')

<div align="center">
    <h2>Thêm mới Phòng</h2>

    <form action="{{route('phong-addsave')}}" method="post" name="myForm" onsubmit="return validateForm()">
        <table class="table table-bordered">
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
            <tr>
                <th>Tên phòng</th>
                <td>
                    <input class="form-control" type="text" name="txt_tenphong" id="tenphong">
                </td>
            </tr>
            <tr>
                <th>Loại phòng</th>
                <td>
                    <select name="sl_loaiphong_id" id="loaiphong_id">
                        <?php foreach ($loaiphongList as $loaiphong): ?>
                        <option value="{{$loaiphong['id_loaiphong']}}">{{$loaiphong['tenloaiphong']}}</option>
                        <?php endforeach ?>
                    </select>
                </td>
            </tr>
            {{--<tr>--}}
                {{--<th>Trạng thái</th>--}}
                {{--<td>--}}
                    {{--<input type="radio" name="rd_trangthaiphong" id="dadat" value="1">Có khách--}}
                    {{--&emsp;&emsp;&emsp;&emsp;&emsp;--}}
                    {{--<input type="radio" name="rd_trangthaiphong" id="chuadat" value="0">Không có khách--}}
                {{--</td>--}}
            {{--</tr>--}}

            {{--<tr>--}}
                {{--<th>Id Hóa đơn đặt phòng</th>--}}
                {{--<td>--}}
                    {{--<input class="form-control" type="text" name="txt_datphong_id" id="datphong_id">--}}
                {{--</td>--}}
            {{--</tr>--}}
            <tr>
                <td colspan="2" align="center">
                    <input class="btn btn-primary btn-sm" type="submit" value="Thêm mới">
                </td>
            </tr>
        </table>
    </form>
</div>



@endsection