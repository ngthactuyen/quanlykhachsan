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
    <a href="{{route('dichvu_phong-list')}}">
        <button type="button" class="btn btn-primary btn-sm">Chi tiết</button>
    </a>
    <hr>
    <table class="table-bordered">
        <tr>
            <th style="width: 200px;padding: 10px;">Các dịch vụ chưa giao</th>
            <th style="width: 200px;padding: 10px;">Tên dịch vụ</th>
            <th style="width: 200px;padding: 10px;">Số lượng</th>
        </tr>
        <?php
        for ($i = 0; $i< count($dichvu_chuagiaoList); $i++){
            echo '<tr>
                        <td></td>
                        <td style="padding: 10px;">'.$dichvu_chuagiaoList[$i]->tendichvu.'</td>
                        <td style="padding: 10px;">'.$dichvu_soluongList[$i].'</td>
                    </tr>';
        }
        ?>
    </table>
    {{--{!! $dichvu_chuagiaoList->render() !!}--}}
</div>


@endsection