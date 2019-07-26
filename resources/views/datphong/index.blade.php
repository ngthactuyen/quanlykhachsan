@extends('layout/backend')

@section('content')
<div align="center">
    <h2>Danh sách Đặt phòng</h2>
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
            <input type="text" name="txt_keyword" class="form-control" value="<?= isset($_GET['txt_keyword']) ? $_GET['txt_keyword']: ''?>" placeholder="Tìm kiếm theo Tên khách hàng, số CMND, số ĐT, ngày nhận phòng, ngày trả phòng, ghi chú">
            <span class="input-group-btn">
                <button type="submit" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
    </form>
    <!-- /.search form -->

    <a href="{{route('datphong-add')}}">
        <button type="button" class="btn btn-primary btn-sm">Thêm mới</button>
    </a>

    <table class="table table-bordered">
        <tr>
            <th>Id</th>
            <th>Tên khách hàng</th>
            <th>Số CMND</th>
            <th>Số ĐT</th>
            <th>Ngày nhận phòng</th>
            <th>Ngày trả phòng</th>
            <th>Ghi chú</th>
            <th>Tiền đặt cọc</th>
            <th>Id khách hàng</th>
            <th>Trạng thái</th>
            <th colspan="3" align="center">Thao tác</th>
        </tr>

        <?php
        for ($i = 0; $i < count($datphongList); $i++){
            if ($datphongList[$i]->trangthaidatphong == -1){
                $trangthaidatphong = 'Chưa chọn phòng';
                $btnChonphong = '<a href="datphong_phong/'.$datphongList[$i]->id_datphong.'/add">
                    <button type="button" class="btn btn-primary btn-sm">'.'Chọn phòng'.'</button>
                    </a>';
            }else if ($datphongList[$i]->trangthaidatphong == 0){
                $trangthaidatphong = '<a href="datphong/'.$datphongList[$i]->id_datphong.'/updatetrangthai">
                    <button type="button" class="btn btn-success btn-sm">'.'Khách đến'.'</button>
                </a>';
                $btnChonphong = '<a href="datphong_phong/'.$datphongList[$i]->id_datphong.'/add">
                    <button type="button" class="btn btn-primary btn-sm">'.'Chọn thêm phòng'.'</button>
                    </a>';
            }else if ($datphongList[$i]->trangthaidatphong == 1){
                $trangthaidatphong = 'Đã nhận phòng';
                $btnChonphong = '<a href="datphong_phong/'.$datphongList[$i]->id_datphong.'/add">
                    <button type="button" class="btn btn-primary btn-sm">'.'Chọn thêm phòng'.'</button>
                    </a>';
            }else if ($datphongList[$i]->trangthaidatphong == 2){
                $trangthaidatphong = 'Đã trả phòng';
                $btnChonphong = '';
            }
            echo '<tr>
                        <td>'.$datphongList[$i]->id_datphong.'</td>
                        <td>'.$datphongList[$i]->tenkh.'</td>
                        <td>'.$datphongList[$i]->socmnd.'</td>
                        <td>'.$datphongList[$i]->sdt.'</td>
                        <td>'.$datphongList[$i]->ngaynhan_lythuyet.'</td>
                        <td>'.$datphongList[$i]->ngaytra_lythuyet.'</td>
                        <td>'.$datphongList[$i]->ghichu.'</td>
                        <td>'.number_format($datphongList[$i]->tiendatcoc).' VNĐ</td>
                        <td>'.$datphongList[$i]->khachhang_id.'</td>
                        <td>'.$trangthaidatphong.'</td>
                        <td>
                            <a href="datphong/'.$datphongList[$i]->id_datphong.'/update">
                                <button type="button" class="btn btn-primary btn-sm">Sửa</button>
                            </a>
                        </td>
                        <td>
                            <a onclick="return confirm(\'Xác nhận xóa?\')" href="datphong/'.$datphongList[$i]->id_datphong.'/delete">
                                <button type="button" class="btn btn-danger btn-sm">Xóa</button>
                            </a>
                        </td>
                        <td>
                            '.$btnChonphong.'
                        </td>
                    </tr>';
        }
        ?>

    </table>
    {!! $datphongList->links() !!}


</div>


@endsection