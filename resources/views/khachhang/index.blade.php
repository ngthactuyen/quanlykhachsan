@extends('layout/backend')

@section('content')

<div align="center">
    <h2>Danh sách Khách Hàng</h2>
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
            <input type="text" name="txt_keyword" class="form-control" value="<?= isset($_GET['txt_keyword']) ? $_GET['txt_keyword']: ''?>" placeholder="Tìm kiếm theo Họ tên, Địa chỉ, Email, Số ĐT, Số CMND">
            <span class="input-group-btn">
                <button type="submit" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
    </form>
    <!-- /.search form -->

    <a href="{{route('khachhang-add')}}">
        <button type="button" class="btn btn-primary btn-sm">Thêm mới</button>
    </a>
    <table class="table table-bordered">
        <tr>
            <th>Id</th>
            <th>Họ tên</th>
            <th>Giới tính</th>
            <th>Địa chỉ</th>
            <th>Email</th>
            <th>Số ĐT</th>
            <th>Số CMND</th>
            <th>Tên đăng nhập</th>
            <th>Mật khẩu</th>
            <th>Ngày tạo</th>
            <th colspan="2" align="center">Thao tác</th>
        </tr>
        <?php foreach ($khachhangList as $khachhang): ?>
        <tr>
            <td>{{$khachhang->id}}</td>
            <td>{{$khachhang->hoten}}</td>
            <td>
                <?php
                if ($khachhang->gioitinh == 1){
                    echo "Nam";
                }else if ($khachhang->gioitinh == 0){
                    echo "Nữ";
                }else{
                    echo '';
                }
                ?>
            </td>
            <td>{{$khachhang->diachi}}</td>
            <td>{{$khachhang->email}}</td>
            <td>{{$khachhang->sdt}}</td>
            <td>{{$khachhang->socmnd}}</td>
            <td>{{$khachhang->tendangnhap}}</td>
            <td>{{$khachhang->matkhau}}</td>
            <td>{{$khachhang->ngaytao}}</td>
            <td>
                <a href="khachhang/<?= $khachhang->id?>/update">
                    <button type="button" class="btn btn-primary btn-sm">Sửa</button>
                </a>
            </td>
            <td>
                <a onclick="return confirm('Xác nhận xóa?')" href="khachhang/<?= $khachhang->id?>/delete">
                    <button type="button" class="btn btn-danger btn-sm">Xóa</button>
                </a>
            </td>
        </tr>
        <?php endforeach ?>
    </table>
    {!! $khachhangList->links() !!}
</div>


@endsection