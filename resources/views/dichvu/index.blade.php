@extends('layout/backend')

@section('content')
<div align="center">
    <h2>Danh sách Dịch Vụ</h2>
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
            <input type="text" name="txt_keyword" class="form-control" value="<?= isset($_GET['txt_keyword']) ? $_GET['txt_keyword']: ''?>" placeholder="Tìm kiếm theo Tên dịch vụ, giá, mô tả">
            <span class="input-group-btn">
                <button type="submit" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
    </form>
    <!-- /.search form -->

    <a href="{{route('dichvu-add')}}">
        <button type="button" class="btn btn-primary btn-sm">Thêm mới</button>
    </a>
    <table class="table table-bordered">
        <tr>
            <th>Id</th>
            <th>Tên dịch vụ</th>
            <th>Giá</th>
            <th>Mô tả</th>
            <th colspan="2" align="center">Thao tác</th>
        </tr>
        <?php foreach ($dichvuList as $dichvu): ?>
        <tr>
            <td>{{$dichvu->id_dichvu}}</td>
            <td>{{$dichvu->tendichvu}}</td>
            <td>{{number_format($dichvu->gia)}} VNĐ</td>
            <td>{{$dichvu->mota}}</td>
            <td>
                <a href="dichvu/<?= $dichvu->id_dichvu?>/update">
                    <button type="button" class="btn btn-primary btn-sm">Sửa</button>
                </a>
            </td>
            <td>
                <a onclick="return confirm('Xác nhận xóa?')" href="dichvu/<?= $dichvu->id_dichvu?>/delete">
                    <button type="button" class="btn btn-danger btn-sm">Xóa</button>
                </a>
            </td>
        </tr>
        <?php endforeach ?>
    </table>
    {!! $dichvuList->render() !!}
</div>


@endsection