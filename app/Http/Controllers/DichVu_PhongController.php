<?php

namespace App\Http\Controllers;

use App\DichVu;
use App\DichVu_Phong;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DichVu_PhongController extends Controller
{
    public function index(){
        $keyword = isset($_GET['txt_keyword']) ? $_GET['txt_keyword'] : '';
        $dichvu_phongList = DB::table('tbl_dichvu_phong')
            ->join('tbl_phong', 'tbl_dichvu_phong.phong_id', '=', 'tbl_phong.id_phong')
            ->join('tbl_dichvu', 'tbl_dichvu_phong.dichvu_id', '=', 'tbl_dichvu.id_dichvu')
            ->where('tenphong', 'like', "%$keyword%")
            ->orWhere('tendichvu', 'like', "%$keyword%")
//            ->orderBy('trangthaidichvu_phong')
            ->orderBy('hoadon_id')
            ->orderBy('tenphong', 'asc')
            ->paginate(6);
//        ->get()->toArray();

        //danh sách dịch vụ chưa giao
        $dichvu_phongchuagiaoList = DB::table('tbl_dichvu_phong')
            ->where('trangthaidichvu_phong', '=', 0)
            ->get()->toArray();

        return view('dichvu_phong/index', ['dichvu_phongList' => $dichvu_phongList])
            ->with('dichvu_phongchuagiaoList', $dichvu_phongchuagiaoList);
    }

    public function add($id){
        $getPhongById = DB::table('tbl_phong')
            ->where('id_phong', '=', $id)
            ->get()->toArray();
//        dd($getPhongById);

        $dichvuList = DB::table('tbl_dichvu')
            ->orderBy('tendichvu')
            ->get()->toArray();
//        dd($dichvuList);

        return view('dichvu_phong/add')
            ->with('getPhongById', $getPhongById)
            ->with('dichvuList', $dichvuList);
    }

    public function addsave(){
//        dd($_POST);
        $phong_id = $_POST['txt_phong_id'];
        $dichvu_id = $_POST['sl_dichvu_id'];

        //nếu không set giá thì sẽ lấy giá từ bảng tbl_dichvu
        if (!$_POST['txt_giadichvu']){
//            echo 'chưa set giá';
            $getDichVuById = DB::table('tbl_dichvu')
                ->where('id_dichvu', '=', $dichvu_id)
                ->get()->toArray();
//            dd($getDichVuById);
            $giadichvu = $getDichVuById[0]->gia;
        }else{
//            echo 'Đã set giá';
            $giadichvu = $_POST['txt_giadichvu'];
        }
        $soluong = $_POST['txt_soluong'];
        $ghichu = $_POST['txt_ghichu'];

        //nếu đặt dịch vụ, phòng, giá, ghi chú trùng với dữ liệu đã có thì sẽ cộng thêm số lượng
        $dichvu_phong = DB::table('tbl_dichvu_phong')
            ->where('trangthaidichvu_phong', '=', 0)
            ->where('phong_id', '=', $phong_id)
            ->where('dichvu_id', '=', $dichvu_id)
            ->where('giadichvu', '=', $giadichvu)
            ->where('ghichu', '=', $ghichu)
            ->get()->toArray();
//        dd($dichvu_phong);

        if (count($dichvu_phong) == 1){
            DB::table('tbl_dichvu_phong')
                ->where('id_dichvu_phong', '=', $dichvu_phong[0]->id_dichvu_phong)
                ->update([
                    'soluong' => $dichvu_phong[0]->soluong + $soluong
                ]);
        }elseif (count($dichvu_phong) == 0){
            $dichvu_phong = new DichVu_Phong();
            $dichvu_phong->phong_id = $phong_id;
            $dichvu_phong->dichvu_id = $dichvu_id;
            $dichvu_phong->giadichvu = $giadichvu;
            $dichvu_phong->soluong = $soluong;
            $dichvu_phong->ghichu = $ghichu;
            $dichvu_phong->save();
        }

        $_SESSION['nhanvien_success_message'] = 'Đặt dịch vụ thành công';

        return redirect(route('dichvu_phong-list'));
    }

    public function update($id){
        $dichvu_phong = new DichVu_Phong();
        $getDichVu_PhongById = $dichvu_phong->find($id)->toArray();
//        dd($getDichVu_PhongById);

        $dichvuList = DB::table('tbl_dichvu')
            ->orderBy('tendichvu')
            ->get()->toArray();

        return view('dichvu_phong/update')
            ->with('getDichVu_PhongById', $getDichVu_PhongById)
            ->with('dichvuList', $dichvuList);
    }

    public function updatesave(){
//        dd($_POST);
        $id_dichvu_phong = $_POST['txt_id_dichvu_phong'];
        $phong_id = $_POST['txt_phong_id'];
        $dichvu_id = $_POST['sl_dichvu_id'];

        //nếu không set giá thì sẽ lấy giá từ bảng tbl_dichvu
        if ($_POST['txt_giadichvu'] == ''){
//            echo 'chưa set giá';
            $getDichVuById = DB::table('tbl_dichvu')
                ->where('id_dichvu', '=', $dichvu_id)
                ->get()->toArray();
//            dd($getDichVuById);
            $giadichvu = $getDichVuById[0]->gia;
        }else{
//            echo 'Đã set giá';
            $giadichvu = $_POST['txt_giadichvu'];
        }
        $soluong = $_POST['txt_soluong'];
        $ghichu = $_POST['txt_ghichu'];
        $trangthaidichvu_phong = $_POST['rd_trangthaidichvu_phong'];

        //nếu đặt dịch vụ, phòng, giá, ghi chú, trạng thái trùng với dữ liệu đã có thì sẽ cộng thêm số lượng
        if ($trangthaidichvu_phong == 0){// nếu dịch vụ chưa giao
            DB::table('tbl_dichvu_phong')
                ->where('id_dichvu_phong', '=', $id_dichvu_phong)
                ->update([
                    'phong_id' => $phong_id,
                    'dichvu_id' => $dichvu_id,
                    'giadichvu' => $giadichvu,
                    'soluong' => $soluong,
                    'ghichu' => $ghichu
                ]);
            $dichvu_phong = DB::table('tbl_dichvu_phong')
                ->where('phong_id', '=', $phong_id)
                ->where('dichvu_id', '=', $dichvu_id)
                ->where('giadichvu', '=', $giadichvu)
                ->where('ghichu', '=', $ghichu)
                ->where('trangthaidichvu_phong', '=', $trangthaidichvu_phong)
                ->get()->toArray();
//            dd($dichvu_phong);
            if (count($dichvu_phong) == 2) {// nếu có 2 dichvu_phong thì xóa dichvu_phong vừa sửa,
                DB::table('tbl_dichvu_phong')
                    ->where('id_dichvu_phong', '=', $id_dichvu_phong)
                    ->delete();
                // sau đó cộng soluong của dichvu_phong còn lại thêm soluong của dichvu_phong vừa sửa
                $dichvu_phong = DB::table('tbl_dichvu_phong')
                    ->where('phong_id', '=', $phong_id)
                    ->where('dichvu_id', '=', $dichvu_id)
                    ->where('giadichvu', '=', $giadichvu)
                    ->where('ghichu', '=', $ghichu)
                    ->where('trangthaidichvu_phong', '=', $trangthaidichvu_phong)
                    ->get()->toArray();
//                dd($dichvu_phong);
                DB::table('tbl_dichvu_phong')
                    ->where('id_dichvu_phong', '=', $dichvu_phong[0]->id_dichvu_phong)
                    ->update([
                        'soluong' => $dichvu_phong[0]->soluong + $soluong
                    ]);
            }
        }else if ($trangthaidichvu_phong == 1){//nếu dịch vụ đã giao
            DB::table('tbl_dichvu_phong')
                ->where('id_dichvu_phong', '=', $id_dichvu_phong)
                ->update([
                    'phong_id' => $phong_id,
                    'dichvu_id' => $dichvu_id,
                    'giadichvu' => $giadichvu,
                    'soluong' => $soluong,
                    'ghichu' => $ghichu
                ]);
            $dichvu_phong = DB::table('tbl_dichvu_phong')
                ->where('phong_id', '=', $phong_id)
                ->where('dichvu_id', '=', $dichvu_id)
                ->where('giadichvu', '=', $giadichvu)
                ->where('trangthaidichvu_phong', '=', $trangthaidichvu_phong)
                ->get()->toArray();
//            dd($dichvu_phong);

            if (count($dichvu_phong) == 2) {// nếu có 2 dichvu_phong thì xóa dichvu_phong vừa sửa,
                DB::table('tbl_dichvu_phong')
                    ->where('id_dichvu_phong', '=', $id_dichvu_phong)
                    ->delete();
                // sau đó cộng soluong của dichvu_phong còn lại thêm soluong của dichvu_phong vừa sửa
                $dichvu_phong = DB::table('tbl_dichvu_phong')
                    ->where('phong_id', '=', $phong_id)
                    ->where('dichvu_id', '=', $dichvu_id)
                    ->where('giadichvu', '=', $giadichvu)
                    ->where('trangthaidichvu_phong', '=', $trangthaidichvu_phong)
                    ->get()->toArray();
//                dd($dichvu_phong);
                DB::table('tbl_dichvu_phong')
                    ->where('id_dichvu_phong', '=', $dichvu_phong[0]->id_dichvu_phong)
                    ->update([
                        'soluong' => $dichvu_phong[0]->soluong + $soluong,
                        'ghichu' => ''
                    ]);
            }
        }

        $_SESSION['nhanvien_success_message'] = 'Sửa đặt dịch vụ thành công';

        return redirect(route('dichvu_phong-list'));
    }

    public function delete($id){
        DichVu_Phong::find($id)->delete();
        $_SESSION['nhanvien_success_message'] = 'Xóa thành công';

        return redirect()->action('DichVu_PhongController@index');
    }

    public function statistic(){
        //Kiểm tra xem có dịch vụ chưa giao không
        $demDichvuchuagiao = DB::table('tbl_dichvu_phong')
            ->where('trangthaidichvu_phong','=', 0)
            ->count();
//        dd($demDichvuchuagiao);
        if ($demDichvuchuagiao == 0){
            $_SESSION['nhanvien_success_message'] = 'Tất cả các dịch vụ đã được giao cho khách';
            return redirect(route('dichvu_phong-list'));
        }
        // thống kê số lượng từng dịch vụ đã đặt nhưng chưa giao
        $dichvuList = DB::table('tbl_dichvu')
            ->get()->toArray();
//        dd(count($dichvuList));
//        dd($dichvuList);
        foreach ($dichvuList as $dichvu){
            // đếm số lượng từng dịch vụ chưa giao
            $dichvu_soluong = DB::table('tbl_dichvu_phong')
                ->join('tbl_dichvu', 'tbl_dichvu_phong.dichvu_id', '=', 'tbl_dichvu.id_dichvu')
                ->where('trangthaidichvu_phong', '=', 0)
                ->where('id_dichvu', '=', $dichvu->id_dichvu)
                ->sum('soluong');
            if ($dichvu_soluong != 0){
                $dichvu_soluongList[] = $dichvu_soluong;
                $dichvu_chuagiaoList[] = $dichvu;
            }
        }
//        dd($dichvu_soluongList);
//        dd($dichvu_chuagiaoList);
        return view('dichvu_phong/statistic')
            ->with('dichvu_chuagiaoList', $dichvu_chuagiaoList)
            ->with('dichvu_soluongList', $dichvu_soluongList);
    }

    public function updatetrangthai(){
        $dichvu_phongcangiaoList = $_POST['cb_dichvu_phongList'];// trả về mảng 1 chiều các id_dichvu_phong
//        dd($dichvu_phongcangiaoList);

        for ($i = 0; $i< count($dichvu_phongcangiaoList); $i++){
            $dichvu_phongcangiao = DB::table('tbl_dichvu_phong')
                ->where('id_dichvu_phong', '=', $dichvu_phongcangiaoList[$i])
                ->get()->toArray();
//            dd($dichvu_phongcangiao);

            //nếu dịch vụ đã giao, phòng, giá trùng với dữ liệu đã có thì xóa dịch vụ cần giao rồi cộng thêm số lượng
            $dichvu_phongdagiao = DB::table('tbl_dichvu_phong')// trả về 1 dichvu_phong có trangthai = 1, có phong_id, dichvu_id, gia đã có trong csdl trùng với dịch vụ cần giao
                ->where('trangthaidichvu_phong', '=', 1)
                ->where('phong_id', '=', $dichvu_phongcangiao[0]->phong_id)
                ->where('dichvu_id', '=', $dichvu_phongcangiao[0]->dichvu_id)
                ->where('giadichvu', '=', $dichvu_phongcangiao[0]->giadichvu)
                ->get()->toArray();
//            dd($dichvu_phongdagiao);

            if (count($dichvu_phongdagiao) == 1){
                //nếu dịch vụ đã giao, phòng, giá trùng với dữ liệu đã có thì xóa dịch vụ cần giao rồi cộng thêm số lượng
                DB::table('tbl_dichvu_phong')
                    ->where('id_dichvu_phong', '=', $dichvu_phongcangiaoList[$i])
                    ->delete();

                DB::table('tbl_dichvu_phong')
                    ->where('id_dichvu_phong', '=', $dichvu_phongdagiao[0]->id_dichvu_phong)
                    ->update([
                        'soluong' => $dichvu_phongdagiao[0]->soluong + $dichvu_phongcangiao[0]->soluong
                    ]);
            }elseif (count($dichvu_phongdagiao) == 0){
                DB::table('tbl_dichvu_phong')
                ->where('id_dichvu_phong', '=', $dichvu_phongcangiaoList[$i])
                ->update([
                    'trangthaidichvu_phong' => 1
                ]);
            }
        }
        return redirect(route('dichvu_phong-list'));
    }

}
