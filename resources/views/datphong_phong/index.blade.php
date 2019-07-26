@extends('layout/backend')

@section('content')

<div align="center">
    <h2>Danh sách Phòng đã đặt</h2>
    <?php
    if (isset($_SESSION['err_message'])){
        echo "<p style='color: red'>".$_SESSION['err_message']."</p>";
        unset($_SESSION['err_message']);
    }
    if (isset($_SESSION['nhanvien_success_message'])){
        echo "<p style='color: green'>".$_SESSION['nhanvien_success_message']."</p>";
        unset($_SESSION['nhanvien_success_message']);
    }
    ?>

<!-- search form -->
    <form action="" method="get" class="sidebar-form">
        <div class="input-group">
            <input type="text" name="txt_keyword" class="form-control" value="<?= isset($_GET['txt_keyword']) ? $_GET['txt_keyword']: ''?>" placeholder="Tìm kiếm theo tất cả các cột">
            <span class="input-group-btn">
                <button type="submit" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
    </form>
    <!-- /.search form -->

        {{--<a href="{{route('datphong_phong-add')}}">--}}
            {{--<button type="button" class="btn btn-primary btn-sm">Thêm mới</button>--}}
        {{--</a>--}}
    <table class="table table-bordered">
        <tr>
            <th>Tên phòng</th>
            <th>Loại phòng</th>
            <th>Giá phòng</th>
            <th>Ngày nhận phòng</th>
            <th>Ngày trả phòng</th>
            {{--<th>Tên khách hàng</th>--}}
            {{--<th>Số CMND</th>--}}
            {{--<th>Số ĐT</th>--}}
            <th>Id Đặt phòng</th>
            <th>Trạng thái</th>
            <th>Id Hóa đơn</th>
            <th colspan="3" align="center">Thao tác</th>
        </tr>
        <?php foreach ($datphong_phongList as $datphong_phong): ?>
        <tr>
            <td>{{$datphong_phong->tenphong}}</td>
            <td>{{$datphong_phong->tenloaiphong}}</td>
            <td>{{number_format($datphong_phong->giadatphong_phong)}} VNĐ/ngày</td>
            <td>{{$datphong_phong->ngaynhan_thucte}}</td>
            <td>{{$datphong_phong->ngaytra_thucte}}</td>
            {{--<td>{{$datphong_phong->tenkh}}</td>--}}
            {{--<td>{{$datphong_phong->socmnd}}</td>--}}
            {{--<td>{{$datphong_phong->sdt}}</td>--}}
            <td>{{$datphong_phong->datphong_id}}</td>
            <?php
                   if ($datphong_phong->trangthaidatphong_phong == 0){
                       echo '<td>Chưa nhận phòng</td>';
                   } else if ($datphong_phong->trangthaidatphong_phong == 1){
                       echo '<td style="color: red;">Đã nhận phòng</td>';
                   } else if ($datphong_phong->trangthaidatphong_phong == 2){
                       echo '<td style="color: green;">Đã thanh toán</td>';
                   }
            ?>
            <td>{{ (isset($datphong_phong->hoadon_id)) ? $datphong_phong->hoadon_id : 'Chưa có' }}</td>
            <td>
                <a href="datphong_phong/<?= $datphong_phong->id_datphong_phong?>/update">
                    <button type="button" class="btn btn-primary btn-sm">Sửa</button>
                </a>
            </td>
            <td>
                <a onclick="return confirm('Xác nhận xóa?')" href="datphong_phong/<?= $datphong_phong->id_datphong_phong?>/delete">
                    <button type="button" class="btn btn-danger btn-sm">Xóa</button>
                </a>
            </td>
        </tr>
        <?php endforeach ?>
    </table>
    {!!$datphong_phongList->render()!!}
{{--    {!!$datphong_phongList->links()!!}--}}
</div>


@endsection