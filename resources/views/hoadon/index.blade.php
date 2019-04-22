@extends('layout/backend')

@section('content')
<div align="center">
    <h2>Danh sách Hóa đơn</h2>
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

    <a href="{{route('hoadon-add')}}">
        <button type="button" class="btn btn-primary btn-sm">Thêm mới</button>
    </a>

<!-- search form -->
    <form action="" method="get" class="sidebar-form">
        <div class="input-group">
            <input type="text" name="txt_keyword" class="form-control" value="<?= isset($_GET['txt_keyword']) ? $_GET['txt_keyword']: ''?>" placeholder="Tìm kiếm theo Tên khách hàng, số CMND, số ĐT">
            <span class="input-group-btn">
                <button type="submit" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
    </form>
    <!-- /.search form -->

    <table class="table table-bordered">
        <tr>
            <th>Id</th>
            <th>Tên khách hàng</th>
            <th>Số CMND</th>
            <th>Số ĐT</th>
            <th>Tổng tiền</th>
            <th>Người lập hóa đơn</th>
            <th>Ngày tạo</th>
            <th colspan="2" align="center">Thao tác</th>
        </tr>
        <?php foreach ($hoadonList as $hoadon): ?>
        <tr>
            <td>{{$hoadon->id_hoadon}}</td>
            <td>{{$hoadon->tenkh}}</td>
            <td>{{$hoadon->socmnd}}</td>
            <td>{{$hoadon->sdt}}</td>
            <td>{{number_format($hoadon->tongtien)}} VNĐ</td>
            <td>{{$_SESSION['tenNhanVien']}}</td>
            <td>{{$hoadon->ngaytao}}</td>
            <td>
                <a href="">
                    <button type="button" class="btn btn-primary btn-sm">Sửa</button>
                </a>
            </td>
            <td>
                <a onclick="return confirm('Xác nhận xóa?')" href="hoadon/<?= $hoadon->id_hoadon?>/delete">
                    <button type="button" class="btn btn-danger btn-sm">Xóa</button>
                </a>
            </td>
        </tr>
        <?php endforeach ?>
    </table>
    {!! $hoadonList->render() !!}
</div>


@endsection