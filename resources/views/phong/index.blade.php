<?php //dd($_SESSION)?>

@extends('layout/backend')

@section('content')

<div align="center">
    <h2>Danh sách Phòng</h2>
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
            <input type="text" name="txt_keyword" class="form-control" value="<?= isset($_GET['txt_keyword']) ? $_GET['txt_keyword']: ''?>" placeholder="Tìm kiếm theo Tên phòng, tên loại phòng">
            <span class="input-group-btn">
                <button type="submit" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
    </form>
    <!-- /.search form -->

    <a href="{{route('phong-add')}}">
        <button type="button" class="btn btn-primary btn-sm">Thêm mới</button>
    </a>
    <form action="{{ route('phong-updatetrangthai') }}" method="post">
        <table class="table table-bordered">
            <tr>
                <th>Id</th>
                <th>Tên phòng</th>
                <th>Loại phòng</th>
                <th>Trạng thái</th>
                <th colspan="3" align="center">Thao tác</th>
            </tr>
            <?php foreach ($phongList as $phong): ?>
            <tr>
                <!--<td>
                    <?php
//                    if ($phong->trangthaiphong == 0){
//                        echo '<input type="checkbox" name="cb_phongList[]"
//                        value="'.$phong->id_phong.'">';
//                    }
                    ?>
                </td>
                -->
                <td>{{$phong->id_phong}}</td>
                <td>{{$phong->tenphong}}</td>
                <td>{{$phong->tenloaiphong}}</td>
                <td>
                    <?php
                    if ($phong->trangthaiphong == 1){
                        echo "Có khách";
                    }else if ($phong->trangthaiphong == 0){
                        echo "Không có khách";
                    }else{
                        echo '';
                    }
                    ?>
                </td>
                <td>
                    <a href="phong/<?= $phong->id_phong?>/update">
                        <button type="button" class="btn btn-primary btn-sm">Sửa</button>
                    </a>
                </td>
                <td>
                    <a onclick="return confirm('Xác nhận xóa?')" href="phong/<?= $phong->id_phong?>/delete">
                        <button type="button" class="btn btn-danger btn-sm">Xóa</button>
                    </a>
                </td>

                <?php
                if ($phong->trangthaiphong == 1){
//                    echo "Có khách";
                    echo '<td><a href="dichvu_phong/'.$phong->id_phong.'/add"><button type="button" class="btn btn-primary btn-sm">Đặt dịch vụ</button></a></td>';
                }else if ($phong->trangthaiphong == 0){
                }
                ?>
            </tr>
            <?php endforeach ?>
        </table>
        <?php
//        if (count($phongKhongCoKhachList) > 0 ){
//            echo '<p align="left">
//                <input type="hidden" name="_token" value="'.csrf_token().'" />
//                <input type="submit" class="btn btn-primary btn-sm" value="Giao cho khách">
//                </p>';
//        }
        ?>
    </form>

    {!!$phongList->render()!!}
{{--    {!!$phongList->links()!!}--}}
</div>


@endsection