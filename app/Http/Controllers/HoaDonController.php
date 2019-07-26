<?php

namespace App\Http\Controllers;

use App\HoaDon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HoaDonController extends Controller
{
    public function index(){
        $keyword = isset($_GET['txt_keyword']) ? $_GET['txt_keyword'] : '';
        $hoadonList = DB::table('tbl_hoadon')
            ->where('tenkh', 'like', "%$keyword%")
            ->orWhere('socmnd', '=', "$keyword")
            ->orWhere('sdt', 'like', "%$keyword%")
            ->orderBy('ngaytao', 'desc')
            ->paginate(4);
        return view('hoadon/index', ['hoadonList' => $hoadonList]);
    }

    public function add(){
        return view('hoadon/add');
    }

    public function chonphongthanhtoan(){
//        dd($_POST);
        $tenkh = $_POST['txt_tenkh'];
        $socmnd = $_POST['txt_socmnd'];
        $sdt = $_POST['txt_sdt'];
        $nguoilap_id = $_POST['txt_nguoilap_id'];
        $ngaytao = $_POST['txt_ngaytao'];
        $khachhangList = DB::table('tbl_khachhang')
            ->where('socmnd', 'like', $socmnd)
            ->get()->toArray();
        if (count($khachhangList) == 1){
            $khachhang_id = $khachhangList[0]->id;
        }
        //lưu hóa đơn mới với tổng tiền = 0
        $hoadon = new HoaDon();
        $hoadon->tenkh = $tenkh;
        $hoadon->socmnd = $socmnd;
        $hoadon->sdt = $sdt;
        if (isset($khachhang_id)){
            $hoadon->khachhang_id = $khachhang_id;
        }
        $hoadon->nguoilap_id = $nguoilap_id;
        $hoadon->ngaytao = $ngaytao;
        $hoadon->save();
        $id_hoadon = $hoadon->id_hoadon;

        //Lấy ra danh sách phòng đang có khách để chọn thanh toán
        $phongList = DB::table('tbl_phong')
            ->join('tbl_loaiphong', 'tbl_phong.loaiphong_id', '=', 'tbl_loaiphong.id_loaiphong')
            ->where('trangthaiphong','=', 1)
            ->orderBy('tenphong')
            ->get()->toArray();
        return view('hoadon/chonphongthanhtoan')
            ->with('phongList', $phongList)
            ->with('id_hoadon', $id_hoadon);
    }

    public function tinhtongtien(){
//        dd($_POST);
        $phongList = $_POST['cb_phongList'];
        $hoadon_id = $_POST['txt_hoadon_id'];
//        dd($phongList);


        //Chọn ra các hàng trong tbl_datphong_phong có phong_id trong $phongList và trangthaidatphong_phong = 1(đã nhận phòng)
//        sau đó update hoadon_id
        //Update các phòng sang trangthai = 0(không có khách)
        //Chọn ra những dịch vụ đã đặt ở các phòng trong $phongList chưa có hoadon_id để update hoadon_id
//        $dichvu_phongListWithPhong_id = [];
        for ($i = 0; $i < count($phongList); $i++){
            DB::table('tbl_datphong_phong')
                ->where('phong_id', '=', $phongList[$i])
                ->where('trangthaidatphong_phong', '=', 1)
                ->update([
                    'hoadon_id' => $hoadon_id,
                    'trangthaidatphong_phong' => 2
                ]);

            DB::table('tbl_phong')
                ->where('id_phong', '=', $phongList[$i])
                ->update([
                    'trangthaiphong' => 0
                ]);

            $temp_dichvu_phong = DB::table('tbl_dichvu_phong')
                ->where('phong_id', '=', $phongList[$i])
                ->get()->toArray();
            //Kiểm tra nếu dichvu_phong nào chưa có hoadon_id thì update hoadon_id
            for ($j = 0; $j < count($temp_dichvu_phong); $j++){
                if ($temp_dichvu_phong[$j]->hoadon_id == null){
                    DB::table('tbl_dichvu_phong')
                        ->where('id_dichvu_phong', '=', $temp_dichvu_phong[$j]->id_dichvu_phong)
                        ->update([
                            'hoadon_id' => $hoadon_id
                        ]);
                    $dichvu_phongListWithPhong_id[] = $temp_dichvu_phong[$j];
                }
            }
        }
//        die();
//        dd($dichvu_phongListWithPhong_id);

//        $getDatPhong_PhongListByHoaDon_Id = DB::table('tbl_datphong_phong')
//            ->where('hoadon_id','=', $hoadon_id)
//            ->get()->toArray();
////        dd($getDatPhong_PhongListByHoaDon_Id);
//
//        $getDichVu_PhongListByHoaDon_Id = DB::table('tbl_dichvu_phong')
//            ->where('hoadon_id','=', $hoadon_id)
//            ->get()->toArray();
////        dd($getDichVu_PhongListByHoaDon_Id);
        $tongtien = 0;
        for ($i = 0; $i < count($phongList); $i++){
            //Lấy thông tin từng phòng cần thanh toán đưa vào $phong[]
            $phong = [];
            $temp_phong = DB::table('tbl_datphong_phong')
                ->join('tbl_phong', 'tbl_datphong_phong.phong_id', '=', 'tbl_phong.id_phong')
                ->where('hoadon_id','=', $hoadon_id)
                ->where('phong_id', '=', $phongList[$i])
                ->get()->first();
//            dd($temp_phong);
            $phong['phong'] = $temp_phong;
            $phong['tienphong'] = $temp_phong->giadatphong_phong / 86400 * (strtotime($temp_phong->ngaytra_thucte) - strtotime($temp_phong->ngaynhan_thucte));
            $tongtien += $phong['tienphong'];
            $temp_dichvu = DB::table('tbl_dichvu_phong')
                ->join('tbl_dichvu', 'tbl_dichvu_phong.dichvu_id', '=', 'tbl_dichvu.id_dichvu')
                ->where('hoadon_id','=', $hoadon_id)
                ->where('phong_id', '=', $phongList[$i])
                ->get()->toArray();
//            dd($temp_dichvu);
            $tiendichvu = 0;
            for ($j = 0; $j < count($temp_dichvu); $j++){
                $phong['dichvu'][] = $temp_dichvu[$j];
                $tiendichvu += $temp_dichvu[$j]->giadichvu * $temp_dichvu[$j]->soluong;
            }
            $phong['tiendichvu'] = $tiendichvu;
            $tongtien += $tiendichvu;
//            dd($phong);

            $danhsachphongtinhtongtien[] = $phong;
        }
//        dd($danhsachphongtinhtongtien, $tongtien);

        //Lấy ra tiền đặt cọc
        $tiendatcoc = DB::table('tbl_datphong_phong')
            ->join('tbl_datphong', 'tbl_datphong_phong.datphong_id', '=', 'tbl_datphong.id_datphong')
            ->where('hoadon_id','=', $hoadon_id)
            ->get()->first()->tiendatcoc;
//        dd($danhsachphongtinhtongtien, $tongtien, $tiendatcoc);

        return view('hoadon/tinhtongtien')
            ->with('danhsachphongtinhtongtien',$danhsachphongtinhtongtien)
            ->with('tongtien', $tongtien)
            ->with('tiendatcoc', $tiendatcoc)
            ->with('id_hoadon', $hoadon_id);
    }

    public function thanhtoan(){
        DB::table('tbl_hoadon')
            ->where('id_hoadon', '=', $_POST['txt_id_hoadon'])
            ->update([
                'tongtien' => $_POST['txt_tongtienthanhtoan']
            ]);
        return redirect(route('hoadon-list'));
    }

    public function delete($id){
        DB::table('tbl_dichvu_phong')
            ->where('hoadon_id', '=', $id)
            ->delete();
        DB::table('tbl_datphong_phong')
            ->where('hoadon_id', '=', $id)
            ->delete();
        HoaDon::find($id)->delete();

        $_SESSION['nhanvien_success_message'] = 'Xóa thành công';
        return redirect()->action('HoaDonController@index');
    }
}
