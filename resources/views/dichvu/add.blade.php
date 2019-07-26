@extends('layout/backend')

@section('content')

<div align="center">
    <h2>Thêm mới Dịch Vụ</h2>

    <form action="{{route('dichvu-addsave')}}" method="post" name="myForm" onsubmit="return validateForm()">
        <table class="table table-bordered">
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
            <tr>
                <th>Tên dịch vụ</th>
                <td>
                    <input class="form-control" type="text" name="txt_tendichvu" id="tendichvu">
                </td>
            </tr>
            <tr>
                <th>Giá</th>
                <td>
                    <input class="form-control" type="text" name="txt_gia" id="gia">
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