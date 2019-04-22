<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\DatPhong;
use Illuminate\Http\Request;

class DatPhongController extends Controller
{
    public function index(){
//        $datphongList = \App\DatPhong::all()->toArray();
        //->orWhere('gia', '=', "$keyword")->orWhere('mota', 'like', "%$keyword%")
        $keyword = isset($_GET['txt_keyword']) ? $_GET['txt_keyword'] : '';
        $datphongList = DB::table('tbl_datphong')
            ->where('tenkh', 'like', "%$keyword%")
            ->orWhere('socmnd', 'like', "$keyword")
            ->orWhere('sdt', 'like', "$keyword")
            ->orWhere('ngaynhan_lythuyet', 'like', "$keyword")
            ->orWhere('ngaytra_lythuyet', 'like', "$keyword")
            ->orWhere('ghichu', 'like', "%$keyword%")
            ->orderBy('trangthaidatphong')
            ->orderBy('ngaynhan_lythuyet')
//            ->get()->toArray();
            ->paginate(6);
//        dd(count($datphongList));
        if (count($datphongList) == 0){
            return view('datphong/index', ['datphongList' => $datphongList]);
        }else{
            foreach ($datphongList as $datphong){
                $countTrangthaidatphong = DB::table('tbl_datphong_phong')
                    ->where('datphong_id', '=', $datphong->id_datphong)
                    ->count();
                $trangthaidatphongList[] = $countTrangthaidatphong;
            }
//        dd($trangthaidatphongList);
//            dd(count($trangthaidatphongList));
//            dd($trangthaidatphongList);

            return view('datphong/index', ['datphongList' => $datphongList])
                ->with('trangthaidatphongList', $trangthaidatphongList);
        }

    }

    public function add(){
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $temp_ngayhienthoi = getdate();
//        dd($temp_ngayhienthoi);

        //tách chuỗi ngày tháng hiện thời
        $ngayhienthoi['nam'] = $temp_ngayhienthoi['year'];
        $ngayhienthoi['thang'] = $temp_ngayhienthoi['mon'];
        $ngayhienthoi['ngay'] = $temp_ngayhienthoi['mday'];
        $ngayhienthoi['gio'] = $temp_ngayhienthoi['hours'];
        $ngayhienthoi['phut'] = $temp_ngayhienthoi['minutes'];
//        dd($ngayhienthoi);

        return view('datphong/add')
            ->with('ngayhienthoi', $ngayhienthoi);
    }

    public function addsave(){
//        dd($_POST);
        $tenkh = $_POST['txt_tenkh'];
        $socmnd = $_POST['txt_socmnd'];
        $sdt = $_POST['txt_sdt'];
        $ngaynhan_lythuyet = $_POST['txt_ngaynhan_lythuyet'];
        $ngaytra_lythuyet = $_POST['txt_ngaytra_lythuyet'];
        $ghichu = $_POST['txt_ghichu'];
        $tiendatcoc = $_POST['txt_tiendatcoc'];

        if ($ngaytra_lythuyet >= $ngaynhan_lythuyet){
            $datphong = new DatPhong();
            $datphong->tenkh = $tenkh;
            $datphong->socmnd = $socmnd;
            $datphong->sdt = $sdt;
            $datphong->ngaynhan_lythuyet = $ngaynhan_lythuyet;
            $datphong->ngaytra_lythuyet = $ngaytra_lythuyet;
            $datphong->ghichu = $ghichu;
            if ($tiendatcoc != ''){
                $datphong->tiendatcoc = $tiendatcoc;
            }
            $datphong->save();
            $_SESSION['nhanvien_success_message'] = 'Thêm mới thành công';

            return redirect(route('datphong-list'));
        }else{
            $_SESSION['err_message'] = 'Ngày trả phòng không hợp lệ, vui lòng nhập lại ngày trả phòng lớn hơn ngày nhận phòng!';
            return view('datphong/add');
        }

    }

    public function update($id){
        $datphong = new DatPhong();
        $getDatPhongById = $datphong->find($id)->toArray();
//        dd($getDatPhongById['ngaynhan_lythuyet']);
        //tách chuỗi ngày tháng nhận phòng
        $temp1_ngaynhan_lythuyet = explode('-',$getDatPhongById['ngaynhan_lythuyet']);
        $ngaynhan_lythuyet['nam'] = $temp1_ngaynhan_lythuyet[0];
        $ngaynhan_lythuyet['thang'] = $temp1_ngaynhan_lythuyet[1];
        $temp2_ngaynhan_lythuyet = explode(' ', $temp1_ngaynhan_lythuyet[2]);
        $ngaynhan_lythuyet['ngay'] = $temp2_ngaynhan_lythuyet[0];
        $temp3_ngaynhan_lythuyet = explode(':', $temp2_ngaynhan_lythuyet[1]);
        $ngaynhan_lythuyet['gio'] = $temp3_ngaynhan_lythuyet[0];
        $ngaynhan_lythuyet['phut'] = $temp3_ngaynhan_lythuyet[1];
//        dd($ngaynhan_lythuyet);

        $temp1_ngaytra_lythuyet = explode('-',$getDatPhongById['ngaytra_lythuyet']);
        $ngaytra_lythuyet['nam'] = $temp1_ngaytra_lythuyet[0];
        $ngaytra_lythuyet['thang'] = $temp1_ngaytra_lythuyet[1];
        $temp2_ngaytra_lythuyet = explode(' ', $temp1_ngaytra_lythuyet[2]);
        $ngaytra_lythuyet['ngay'] = $temp2_ngaytra_lythuyet[0];
        $temp3_ngaytra_lythuyet = explode(':', $temp2_ngaytra_lythuyet [1]);
        $ngaytra_lythuyet['gio'] = $temp3_ngaytra_lythuyet[0];
        $ngaytra_lythuyet['phut'] = $temp3_ngaytra_lythuyet[1];
//        dd($ngaytra_lythuyet);

        return view('datphong/update')
            ->with('getDatPhongById', $getDatPhongById)
            ->with('ngaynhan_lythuyet', $ngaynhan_lythuyet)
            ->with('ngaytra_lythuyet', $ngaytra_lythuyet);
    }

    public function updatesave(){
//        dd($_POST);
        $id = $_POST['txt_id'];
        $tenkh = $_POST['txt_tenkh'];
        $socmnd = $_POST['txt_socmnd'];
        $sdt = $_POST['txt_sdt'];
        $ngaynhanphong = $_POST['txt_ngaynhan_lythuyet'];
        $ngaytraphong = $_POST['txt_ngaytra_lythuyet'];
        $ghichu = $_POST['txt_ghichu'];
        $tiendatcoc = $_POST['txt_tiendatcoc'];
        $trangthaidatphong = $_POST['rd_trangthaidatphong'];

        if ($ngaytraphong >= $ngaynhanphong){
        $datphong = new DatPhong();
        $getDatPhongById = $datphong->find($id);
        $getDatPhongById->tenkh = $tenkh;
        $getDatPhongById->socmnd = $socmnd;
        $getDatPhongById->sdt = $sdt;
        $getDatPhongById->ngaynhan_lythuyet = $ngaynhanphong;
        $getDatPhongById->ngaytra_lythuyet = $ngaytraphong;
        $getDatPhongById->ghichu = $ghichu;
        $getDatPhongById->tiendatcoc = $tiendatcoc;
        $getDatPhongById->trangthaidatphong = $trangthaidatphong;

        $getDatPhongById->save();
        $_SESSION['nhanvien_success_message'] = 'Sửa thành công';

        return redirect(route('datphong-list'));
        }else{
            $datphong = new DatPhong();
            $getDatPhongById = $datphong->find($id)->toArray();
            $_SESSION['err_message'] = 'Ngày trả phòng không hợp lệ, vui lòng nhập lại ngày trả phòng lớn hơn ngày nhận phòng!';
            return view('datphong/update')->with('getDatPhongById', $getDatPhongById);
        }
    }

    public function delete($id){
        DB::table('tbl_datphong_phong')
            ->where('datphong_id', '=', $id)
            ->delete();
        DatPhong::find($id)->delete();

        $_SESSION['nhanvien_success_message'] = 'Xóa thành công';
        return redirect()->action('DatPhongController@index');
    }

    public function updatetrangthai($id){
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $ngaynhanphong = date('Y-m-d H:i');

        //update trangthaidatphong trong tbl_datphong
        DB::table('tbl_datphong')
            ->where('id_datphong', '=', $id)
            ->update([
               'trangthaidatphong' => 1,
//                'ngaynhanphong' => $ngaynhanphong
            ]);

        ////update trangthaidatphong_phong trong tbl_datphong_phong có datphong_id = id_datphong
        DB::table('tbl_datphong_phong')
            ->where('datphong_id', '=', $id)
            ->update([
                'trangthaidatphong_phong' => 1,
//                'ngaynhanphong' => $ngaynhanphong
            ]);

        //update trangthaiphong(tbl_phong) của các phòng có trong datphong_phong
        $datphong_phongListWithDatphong_id = DB::table('tbl_datphong_phong')
            ->where('datphong_id', '=', $id)
            ->get()->toArray();
        for ($i = 0; $i< count($datphong_phongListWithDatphong_id); $i++){
            DB::table('tbl_phong')
                ->where('id_phong', '=', $datphong_phongListWithDatphong_id[$i]->phong_id)
                ->update([
                    'trangthaiphong' => 1
                ]);
        }
        $_SESSION['nhanvien_success_message'] = 'Cập nhật thành công';
        return redirect(route('datphong-list'));
    }

}
