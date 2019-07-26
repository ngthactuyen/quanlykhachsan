

@extends('layout/backend')

@section('content')
    <div align="center">
        <h2>Danh sách Nhân viên</h2>
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
        <a href="{{route('nhanvien-add')}}">
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
                <th>Phân quyền</th>
                <th>Ngày tạo</th>
                <th colspan="2" align="center">Thao tác</th>
            </tr>
            <?php foreach ($nhanvienList as $nhanvien): ?>
            <tr>
                <td>{{$nhanvien->id}}</td>
                <td>{{$nhanvien->hoten}}</td>
                <td>
                    <?php
                    if ($nhanvien->gioitinh == 1){
                        echo "Nam";
                    }else if ($nhanvien->gioitinh == 0){
                        echo "Nữ";
                    }else{
                        echo '';
                    }
                    ?>
                </td>
                <td>{{$nhanvien->diachi}}</td>
                <td>{{$nhanvien->email}}</td>
                <td>{{$nhanvien->sdt}}</td>
                <td>{{$nhanvien->socmnd}}</td>
                <td>{{$nhanvien->tendangnhap}}</td>
                <td>{{$nhanvien->matkhau}}</td>
                <td>
                    <?php
                    if ($nhanvien->phanquyen == 1){
                        echo "Admin";
                    }else if ($nhanvien->phanquyen == 0){
                        echo "Nhân viên";
                    }else{
                        echo '';
                    }
                    ?>
                </td>
                <td>{{$nhanvien->ngaytao}}</td>
                <td>
                    <a href="nhanvien/<?= $nhanvien->id?>/update">
                        <button type="button" class="btn btn-primary btn-sm">Sửa</button>
                    </a>
                </td>
                <td>
                    <a onclick="return confirm('Xác nhận xóa?')" href="nhanvien/<?= $nhanvien->id?>/delete">
                            <button type="button" class="btn btn-danger btn-sm">Xóa</button>
                    </a>
                </td>
            </tr>
            <?php endforeach ?>
        </table>
        {!! $nhanvienList->render() !!}
    </div>



@endsection



