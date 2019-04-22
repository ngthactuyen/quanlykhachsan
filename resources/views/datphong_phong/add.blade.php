@extends('layout/backend')

@section('content')

<div >
    <h2>Chọn phòng</h2>

    <?php
    echo '<h3>Ngày nhận phòng: '.$getDatPhongById[0]->ngaynhan_lythuyet.'</h3>'.
        '<h3>Ngày trả phòng: '.$getDatPhongById[0]->ngaytra_lythuyet.'</h3>
        <hr>';

    if (isset($_SESSION['err_message'])){
        echo "<p style='color: red'>".$_SESSION['err_message']."</p>";
        unset($_SESSION['err_message']);
    }
    ?>
    <form action="{{route('datphong_phong-addsave')}}" method="post" name="myForm" onsubmit="return validateForm()">
        <table class="table table-bordered">
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
            <input type="hidden" name="txt_datphong_id" value="{{ $getDatPhongById[0]->id_datphong  }}">
            <input type="hidden" name="txt_getDatPhongById_ngaynhan_lythuyet" value="{{ $getDatPhongById[0]->ngaynhan_lythuyet }}">
            <input type="hidden" name="txt_getDatPhongById_ngaytra_lythuyet" value="{{ $getDatPhongById[0]->ngaytra_lythuyet }}">

            <?php
            $a = 0;
            foreach ($loaiphongList as $loaiphong):
            ?>
            <tr>
                <th style="width: 250px; ">Loại phòng: {{ $loaiphong->tenloaiphong }}</th>
                <th style="width: 300px; ">Mô tả: {{ $loaiphong->mota }}</th>
                <th>Giá:
                    <input type="text" name="txt_giadatphong_phongList[]" id="giadatphong_phong" placeholder="{{ number_format($loaiphong->giaphong) }} VNĐ/ngày">
                </th>
            </tr>

            <?php
                    $i = $a;
//                    for ($i; $i< count($phong_loaiphongList); $i++){
//                        echo '<tr>';
                        if (count($phong_loaiphongList[$i]) == 0){
                            echo '<tr><td>Đã hết phòng</td></tr>';
                        }else{
//                            echo '<tr><td>';
                            for ($j = 0; $j< count($phong_loaiphongList[$i]); $j++){

                                for ($k = 0; $k< count($phong_loaiphongList[$i][$j]); $k++){
                                    echo '
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="cb_phongList['.$i.'][]" value="'.$phong_loaiphongList[$i][$j][$k]->id_phong.'">'.$phong_loaiphongList[$i][$j][$k]->tenphong.'
                                        </td>
                                    </tr>';
                                }

                            }
//                            echo '</td></tr>';
                        }
//                        echo '</tr>';
//                    }
                    $a++;
                ?>
            <?php endforeach;?>
            <tr>
                <td colspan="2" >
                    <input class="btn btn-primary btn-sm" type="submit" value="Chọn">
                </td>
            </tr>
        </table>
    </form>
</div>



@endsection