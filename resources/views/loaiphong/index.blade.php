@extends('layout/backend')

@section('content')

<div align="center">
    <h2>Danh sách Loại Phòng</h2>
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
            <input type="text" name="txt_keyword" class="form-control" value="<?= isset($_GET['txt_keyword']) ? $_GET['txt_keyword']: ''?>" placeholder="Tìm kiếm theo Tên loại phòng, giá, mô tả">
            <span class="input-group-btn">
                <button type="submit" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
    </form>
    <!-- /.search form -->


    <a href="{{route('loaiphong-add')}}">
        <button type="button" class="btn btn-primary btn-sm">Thêm mới</button>
    </a>
    <table class="table table-bordered">
        <tr>
            <th>Id</th>
            <th>Tên loại phòng</th>
            <th>Giá</th>
            <th>Mô tả</th>
            <th colspan="2" align="center">Thao tác</th>
        </tr>
        <?php foreach ($loaiphongList as $loaiphong): ?>
        <tr>
            <td>{{$loaiphong->id_loaiphong}}</td>
            <td>{{$loaiphong->tenloaiphong}}</td>
            <td>{{number_format($loaiphong->giaphong)}} VNĐ/ngày</td>
            <td>{{$loaiphong->mota}}</td>
            <td>
                <a href="loaiphong/<?= $loaiphong->id_loaiphong?>/update">
                    <button type="button" class="btn btn-primary btn-sm">Sửa</button>
                </a>
            </td>
            <td>
                <a onclick="return confirm('Xác nhận xóa?')" href="loaiphong/<?= $loaiphong->id_loaiphong?>/delete">
                    <button type="button" class="btn btn-danger btn-sm">Xóa</button>
                </a>
            </td>
        </tr>
        <?php endforeach ?>
    </table>
    {!! $loaiphongList->links() !!}
</div>


@endsection