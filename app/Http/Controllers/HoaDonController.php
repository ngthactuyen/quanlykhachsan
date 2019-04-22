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
//        for ($i = 0; $i < count($phongList); $i++){
//            DB::table('tbl_datphong_phong')
//                ->where('phong_id', '=', $phongList[$i])
//                ->where('trangthaidatphong_phong', '=', 1)
//                ->update([
//                    'hoadon_id' => $hoadon_id
//                ]);
//        }

        //Chọn ra những dịch vụ đã đặt ở các phòng trong $phongList chưa có hoadon_id để update hoadon_id
        $dichvu_phongListWithPhong_id = [];
        for ($i = 0; $i < count($phongList); $i++){
            $temp_dichvu_phong = DB::table('tbl_dichvu_phong')
                ->where('phong_id', '=', $phongList[$i])
                ->get()->toArray();
            $dichvu_phongListWithPhong_id[] = $temp_dichvu_phong;
        }
        dd($dichvu_phongListWithPhong_id);
        $getDichVu_PhongListByHoaDon_Id = DB::table('tbl_dichvu_phong')
            ->where('hoadon_id','=', $hoadon_id)
            ->get()->toArray();
//        dd($getDichVu_PhongListByHoaDon_Id);

        //lấy ra id_datphong có trangthaidatphong = 1(đã đến nhận phòng) và soCMND = soCMND trong hóa đơn cần thanh toán
        // lấy số cmnd
        $temp_socmnd = DB::table('tbl_hoadon')
            ->where('id_hoadon','=', $hoadon_id)
            ->get()->toArray();
        $socmnd = $temp_socmnd[0]->socmnd;
        //lấy id_datphong
        $temp_id_datphong = DB::table('tbl_datphong')
            ->where('socmnd', '=', $socmnd)
            ->where('trangthaidatphong', '=', 1)
            ->get()->toArray();
//        dd($temp_id_datphong);
        $id_datphong = $temp_id_datphong[0]->id_datphong;
        $tiendatcoc = $temp_id_datphong[0]->tiendatcoc;

        //update ngaytraphong ở tbl_datphong có id_datphong = $id_datphong bằng ngày tạo hóa đơn
//        $getHoaDonById = DB::table('tbl_hoadon')
//            ->where('id_hoadon', '=', $hoadon_id)
//            ->get()->toArray();
//
//        DB::table('tbl_datphong')
//            ->where('id_datphong', '=', $id_datphong)
//            ->update([
//                'ngaytraphong' => $getHoaDonById[0]->ngaytao
//            ]);

        //lấy ra danh sách phòng cần thanh toán
        for ($i = 0; $i < count($getDichVu_PhongListByHoaDon_Id); $i++){
            $temp = 0;
            for ($j = $i; $j < count($getDichVu_PhongListByHoaDon_Id); $j++){
                if ($getDichVu_PhongListByHoaDon_Id[$i]->phong_id == $getDichVu_PhongListByHoaDon_Id[$j]->phong_id){
                    $temp++;
                }
            }
            if ($temp == 1){
                $danhsachphongtinhtongtien[] = $getDichVu_PhongListByHoaDon_Id[$i]->phong_id;
            }
        }
//        dd($danhsachphongtinhtongtien);

        for ($i = 0;$i < count($danhsachphongtinhtongtien); $i++){
            //lấy thông tin các phòng thanh toán
            $phong['phong_id'] = $danhsachphongtinhtongtien[$i];
            $getPhong_LoaiPhongByPhong_id = DB::table('tbl_phong')
                ->join('tbl_loaiphong', 'tbl_phong.loaiphong_id', '=', 'tbl_loaiphong.id_loaiphong')
                ->where('id_phong', '=', $phong['phong_id'])
                ->get()->toArray();
            $phong['tenphong'] = $getPhong_LoaiPhongByPhong_id[0]->tenphong;
            $phong['tenloaiphong'] = $getPhong_LoaiPhongByPhong_id[0]->tenloaiphong;
            $phong['giaphong'] = $getPhong_LoaiPhongByPhong_id[0]->giaphong;

            //lấy thông tin dịch vụ các phòng thanh toán
            //lấy thông tin dịch vụ từng phòng
            $getDichVuByPhong_Id = DB::table('tbl_dichvu_phong')
                ->join('tbl_dichvu', 'tbl_dichvu_phong.dichvu_id', '=', 'tbl_dichvu.id_dichvu')
                ->where('phong_id', '=', $phong['phong_id'])
                ->get()->toArray();
//            dd($getDichVuByPhong_Id);

            for ($j = 0; $j < count($getDichVuByPhong_Id); $j++){
                $dichvu[$j]['dichvu_id'] = $getDichVuByPhong_Id[$j]->dichvu_id;
                $dichvu[$j]['tendichvu'] = $getDichVuByPhong_Id[$j]->tendichvu;
                $dichvu[$j]['soluong'] = $getDichVuByPhong_Id[$j]->soluong;
                $dichvu[$j]['giadichvu'] = $getDichVuByPhong_Id[$j]->giadichvu;
                $phong['tiendichvu'] = $dichvu;
            }
//            dd($phong);

            $tinhtongtien[$i] = $phong;
        }
        dd($tinhtongtien);

        return view();


    }

    public function delete($id){
        DB::table('tbl_dichvu_phong')
            ->where('hoadon_id', '=', $id)
            ->delete();
        HoaDon::find($id)->delete();

        $_SESSION['nhanvien_success_message'] = 'Xóa thành công';
        return redirect()->action('HoaDonController@index');
    }
}
