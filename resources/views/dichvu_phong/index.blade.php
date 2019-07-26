<?php
//    dd($dichvu_phongList);
?>

@extends('layout/backend')

@section('content')
<div align="center">
    <h2>Danh sách Đặt dịch vụ</h2>
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
            <input type="text" name="txt_keyword" class="form-control"
                   value="<?= isset($_GET['txt_keyword']) ? $_GET['txt_keyword']: ''?>" placeholder="Tìm kiếm theo Tên phòng, tên dịch vụ">
            <span class="input-group-btn">
                <button type="submit" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
    </form>
    <!-- /.search form -->

    <a href="{{route('dichvu_phong-statistic')}}">
        <button type="button" class="btn btn-primary btn-sm">Thống kê dịch vụ chưa giao</button>
    </a>
    <form action="{{ route('dichvu_phong-updatetrangthai') }}" method="post">
        <table class="table table-bordered">
            <tr>
                <td></td>
                <th>Tên phòng</th>
                <th>Tên dịch vụ</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Ghi chú</th>
                <th>Id Hóa đơn</th>
                <th>Trạng thái</th>
                <th colspan="2" align="center">Thao tác</th>
            </tr>
            <?php foreach ($dichvu_phongList as $dichvu_phong): ?>
            <tr>
                <?php
                if ($dichvu_phong->trangthaidichvu_phong == 0){
                    echo '<td><input type="checkbox" name="cb_dichvu_phongList[]"
                        value="'.$dichvu_phong->id_dichvu_phong.'"></td>';
                }else{
                    echo '<td></td>';
                }
                ?>
                <td>{{$dichvu_phong->tenphong}}</td>
                <td>{{$dichvu_phong->tendichvu}}</td>
                <td>{{number_format($dichvu_phong->giadichvu)}} VNĐ</td>
                <td>{{$dichvu_phong->soluong}}</td>
                <td>{{$dichvu_phong->ghichu}}</td>
                <td>{{ (isset($dichvu_phong->hoadon_id)) ? $dichvu_phong->hoadon_id : 'Chưa có' }}</td>
                <td>
                    <?= ($dichvu_phong->trangthaidichvu_phong == 1) ? 'Đã giao cho khách': 'Chưa giao cho khách'?>
                </td>
                <td>
                    <a href="dichvu_phong/<?= $dichvu_phong->id_dichvu_phong?>/update">
                        <button type="button" class="btn btn-primary btn-sm">Sửa</button>
                    </a>
                </td>
                <td>
                    <a onclick="return confirm('Xác nhận xóa?')" href="dichvu_phong/<?= $dichvu_phong->id_dichvu_phong?>/delete">
                        <button type="button" class="btn btn-danger btn-sm">Xóa</button>
                    </a>
                </td>
<!--                --><?php
//                if ($dichvu_phong->trangthaidichvu_phong == 0){
//                    echo '<td><a><button type="button" class="btn btn-primary btn-sm">Đã giao cho khách</button></a></td>';
//                }
//                ?>
            </tr>
            <?php endforeach ?>
        </table>
        <?php
        if (count($dichvu_phongchuagiaoList) > 0 ){
            echo '<p align="left">
                <input type="hidden" name="_token" value="'.csrf_token().'" />
                <input type="submit" class="btn btn-primary btn-sm" value="Giao cho khách">
                </p>';
        }
        ?>
    </form>

    {!! $dichvu_phongList->render() !!}
</div>


@endsection