<?php

namespace App\Http\Controllers;

use App\DatPhong;
use App\DatPhong_Phong;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DatPhong_PhongController extends Controller
{
    public function index(){
        $keyword = isset($_GET['txt_keyword']) ? $_GET['txt_keyword'] : '';
        $datphong_phongList = DB::table('tbl_datphong_phong')
            ->join('tbl_phong', 'tbl_datphong_phong.phong_id', '=', 'tbl_phong.id_phong')
            ->join('tbl_loaiphong', 'tbl_phong.loaiphong_id', '=', 'tbl_loaiphong.id_loaiphong')
            ->join('tbl_datphong', 'tbl_datphong_phong.datphong_id', '=', 'tbl_datphong.id_datphong')
            ->where('tenphong', 'like', "%$keyword%")
            ->orWhere('tenloaiphong', 'like', "%$keyword%")
            ->orWhere('ngaynhan_thucte', 'like', "%$keyword%")
            ->orWhere('ngaytra_thucte', 'like', "%$keyword%")
            ->orWhere('tenkh', 'like', "%$keyword%")
            ->orderBy('trangthaidatphong_phong')
            ->orderBy('ngaynhan_thucte')
            ->orderBy('id_datphong')
            ->orderBy('tenphong')
            ->paginate(20);

//        dd($datphong_phongList);
        return view('datphong_phong/index', ['datphong_phongList' => $datphong_phongList]);
    }

    public function add($id){
        //Lấy ra ngaynhan_lythuyet, ngaytra_lythuyet
        $getDatPhongById = DB::table('tbl_datphong')
            ->where('id_datphong', '=', $id)
            ->get()->toArray();

        //Lấy danh sách loại phòng
        $loaiphongList = DB::table('tbl_loaiphong')->get()->toArray();

        for ($i = 0; $i< count($loaiphongList); $i++){
            //Lấy ra danh sách các phòng theo từng loại phòng
            $phongListWithLoaiPhongId = DB::table('tbl_phong')
                ->where('loaiphong_id', '=', $loaiphongList[$i]->id_loaiphong)
                ->get()->toArray();
            $phongListWithOneLoaiPhong = [];
            //Chọn ra những phòng thỏa mãn $getDatPhongById->ngaynhanphong và $getDatPhongById->ngaytraphong lần lượt theo loại phòng
            foreach ($phongListWithLoaiPhongId as $phong){
                //Lấy ra danh sách đặt của từng phòng
                $phongListWithOneId = DB::table('tbl_datphong_phong')
//                    ->join('tbl_datphong', 'tbl_datphong_phong.datphong_id', '=', 'tbl_datphong.id_datphong')
                    ->where('phong_id', '=', $phong->id_phong)
                    ->get()->toArray();
                $phongWithId = DB::table('tbl_phong')
                    ->where('id_phong', '=', $phong->id_phong)
                    ->get()->toArray();

                //Kiểm tra ngày nhận, trả thỏa mãn thì thêm vào
                $flag = 1;
                $count1 = 0;
                foreach ($phongListWithOneId as $phongWithOneId){
                    if (strtotime($getDatPhongById[0]->ngaytra_lythuyet) <= strtotime($phongWithOneId->ngaynhan_thucte) ||
                        strtotime($phongWithOneId->ngaytra_thucte) <= strtotime($getDatPhongById[0]->ngaynhan_lythuyet) ){
                        $count1++;
                    }else {
                        $flag = 0;
                    }
                }
                $datphong_phongList = DB::table('tbl_datphong_phong')
                    ->get()->toArray();
                //nếu thỏa mãn đk ngày đặt, trả hoặc trong tbl_datphong_phong chưa có dữ liệu thì thêm vào mảng
                if (($count1 != 0 || count($datphong_phongList) == 0 || count($phongListWithOneId) == 0) && $flag == 1 ){
                    $phongListWithOneLoaiPhong[] = $phongWithId;
                }

            }
            $phong_loaiphongList[] = $phongListWithOneLoaiPhong;
        }
//        dd($phong_loaiphongList);
        return view('datphong_phong/add')
            ->with('getDatPhongById', $getDatPhongById)
            ->with('loaiphongList', $loaiphongList)
            ->with('phong_loaiphongList', $phong_loaiphongList);
    }

    public function addsave(){
//        dd($_POST);
        $datphong_id = $_POST['txt_datphong_id'];
        $ngaynhan_thucte = $_POST['txt_getDatPhongById_ngaynhan_lythuyet'];
        $ngaytra_thucte = $_POST['txt_getDatPhongById_ngaytra_lythuyet'];
        $giadatphong_phongList = $_POST['txt_giadatphong_phongList'];
        $phongList = $_POST['cb_phongList'];
//        var_dump($giadatphong_phongList);
//        dd($phongList);
//        dd(isset($phongList[0]));
//        dd($giadatphong_phongList);
//        dd(isset($giadatphong_phongList[0]));

        for ($i = 0; $i <= count($phongList); $i++){
            if (isset($phongList[$i]) == false)
                continue;
            for ($j = 0; $j < count($phongList[$i]); $j++){
                $datphong_phong = new DatPhong_Phong();
                $datphong_phong->datphong_id = $datphong_id;
                $datphong_phong->phong_id = $phongList[$i][$j];
                $datphong_phong->ngaynhan_thucte = $ngaynhan_thucte;
                $datphong_phong->ngaytra_thucte = $ngaytra_thucte;
                if ($giadatphong_phongList[$i] == ''){
                    $giadatphong_phongList[$i] = DB::table('tbl_phong')
                        ->join('tbl_loaiphong', 'tbl_phong.loaiphong_id', '=', 'tbl_loaiphong.id_loaiphong')
                        ->where('id_phong', '=', $phongList[$i][$j])
                        ->pluck('giaphong')->toArray()[0];
                }
                $datphong_phong->giadatphong_phong = $giadatphong_phongList[$i];
                $datphong_phong->save();
            }

        }
        DB::table('tbl_datphong')
            ->where('id_datphong', '=', $datphong_id)
            ->update([
                'trangthaidatphong' => 0
            ]);
        $_SESSION['nhanvien_success_message'] = 'Thêm mới thành công';
        return redirect(route('datphong_phong-list'));
    }


    //add-old-2
//    public function add($id){
//        $getDatPhongById = DB::table('tbl_datphong')
//            ->where('id_datphong', '=', $id)
//            ->get()->toArray();
//
////        $datphong_phongList = DB::table('tbl_datphong_phong')
////            ->rightJoin('tbl_phong', 'tbl_datphong_phong.phong_id', '=', 'tbl_phong.id_phong')
////            ->join('tbl_loaiphong', 'tbl_phong.loaiphong_id', '=', 'tbl_loaiphong.id_loaiphong')
////            ->leftJoin('tbl_datphong', 'tbl_datphong_phong.datphong_id', '=', 'tbl_datphong.id_datphong')
////            ->get()->toArray();
//
//        $loaiphongList = DB::table('tbl_loaiphong')->get()->toArray();
//
//        for ($i = 0; $i< count($loaiphongList); $i++){
//            //Lấy ra danh sách các phòng theo từng loại phòng
//            $phongListWithLoaiPhongId = DB::table('tbl_phong')
//                ->where('loaiphong_id', '=', $loaiphongList[$i]->id_loaiphong)
//                ->get()->toArray();
//            $phongListWithOneLoaiPhong = [];
//            //Chọn ra những phòng thỏa mãn $getDatPhongById->ngaynhanphong và $getDatPhongById->ngaytraphong lần lượt theo loại phòng
//            foreach ($phongListWithLoaiPhongId as $phong){
//                $phongListWithOneId = DB::table('tbl_datphong_phong')
//                    ->join('tbl_datphong', 'tbl_datphong_phong.datphong_id', '=', 'tbl_datphong.id_datphong')
//                    ->where('phong_id', '=', $phong->id_phong)
//                    ->get()->toArray();
//                $phongWithId = DB::table('tbl_phong')
//                    ->where('id_phong', '=', $phong->id_phong)
//                    ->get()->toArray();
//
//                $count1 = 0;
//                foreach ($phongListWithOneId as $phongWithOneId){
//                    if (strtotime($getDatPhongById[0]->ngaynhanphong) <= strtotime($phongWithOneId->ngaynhanphong) ||
//                        strtotime($getDatPhongById[0]->ngaytraphong) >= strtotime($phongWithOneId->ngaytraphong) ){
////                        if ()
//                        $count1++;
//                    }
//                    if ( strtotime($getDatPhongById[0]->ngaynhanphong) > strtotime($phongWithOneId->ngaytraphong) ||
//                        strtotime($getDatPhongById[0]->ngaytraphong) < strtotime($phongWithOneId->ngaynhanphong) ){
//                        $phongListWithOneLoaiPhong[] = $phongWithId;
////                        $count2++;
//                    }
//                }
//                if ($count1 == 0){
//                    $phongListWithOneLoaiPhong[] = $phongWithId;
//                }
//
////                foreach ($phongListWithOneId as $phongWithOneId){
////                    if ( strtotime($getDatPhongById[0]->ngaynhanphong) > strtotime($phongWithOneId->ngaytraphong) ||
////                        strtotime($getDatPhongById[0]->ngaytraphong) < strtotime($phongWithOneId->ngaynhanphong) ){
////                        $phongListWithOneLoaiPhong[] = $phongWithId;
//////                        $count2++;
////                    }
////                }
//
//            }
//            $phong_loaiphongList[] = $phongListWithOneLoaiPhong;
//        }
//        dd($phong_loaiphongList);
//        return view('datphong_phong/add')
//            ->with('getDatPhongById', $getDatPhongById)
//            ->with('loaiphongList', $loaiphongList)
//            ->with('phong_loaiphongList', $phong_loaiphongList);
//    }
//
//    public function addsave(){
//        dd($_POST);
//        $datphong_id = $_POST['txt_datphong_id'];
//        $ngaynhan_thucte = $_POST['txt_getDatPhongById_ngaynhan_lythuyet'];
//        $ngaytra_thucte = $_POST['txt_getDatPhongById_ngaytra_lythuyet'];
//        $phongList = $_POST['cb_phongList'];
//        for ($i = 0; $i < count($phongList); $i++){
//            $datphong_phong = new DatPhong_Phong();
//            $datphong_phong->datphong_id = $datphong_id;
//            $datphong_phong->phong_id = $phongList[$i];
//            $datphong_phong->save();
//        }
//        $_SESSION['nhanvien_success_message'] = 'Thêm mới thành công';
//        return redirect(route('datphong_phong-list'));
//    }



    // add-old-1
//    public function add($id){
//        $datphong = new DatPhong();
//        $getDatPhongById = $datphong->find($id)->toArray();
//
//        $datphong_phongList = DB::table('tbl_datphong_phong')
//            ->rightJoin('tbl_phong', 'tbl_datphong_phong.phong_id', '=', 'tbl_phong.id_phong')
//            ->join('tbl_loaiphong', 'tbl_phong.loaiphong_id', '=', 'tbl_loaiphong.id_loaiphong')
//            ->leftJoin('tbl_datphong', 'tbl_datphong_phong.datphong_id', '=', 'tbl_datphong.id_datphong')
//            ->orderBy('id_loaiphong', 'asc')
//            ->orderBy('id_phong', 'asc')
//            ->get()->toArray();
//
////        dd($datphong_phongList);
//
//        $phongList = DB::table('tbl_phong')
//            ->join('tbl_loaiphong', 'tbl_phong.loaiphong_id', '=', 'tbl_loaiphong.id_loaiphong')
//            ->get()->toArray();
//
//        return view('datphong_phong/add')
//            ->with('getDatPhongById', $getDatPhongById)
//            ->with('phongList', $phongList)
//            ->with('datphong_phongList', $datphong_phongList);
//    }

//    public function addsave(){
////        dd($_POST);
//        $datphong_id = $_POST['txt_datphong_id'];
//        $phong_id = $_POST['sl_phong_id'];
//        $getDatPhongById_ngaynhanphong = $_POST['txt_getDatPhongById_ngaynhanphong'];
//        $getDatPhongById_ngaytraphong = $_POST['txt_getDatPhongById_ngaytraphong'];
//        $phongListWithOneId = DB::table('tbl_datphong_phong')
//            ->join('tbl_datphong', 'tbl_datphong_phong.datphong_id', '=', 'tbl_datphong.id_datphong')
//            ->where('phong_id', '=', $phong_id)
//            ->get()->toArray();
////        dd($phongListWithOneId);
//        $count = 0;
//        foreach ($phongListWithOneId as $phongWithOneId){
//            if ($getDatPhongById_ngaynhanphong <= $phongWithOneId->ngaynhanphong ||
//                $getDatPhongById_ngaytraphong >= $phongWithOneId->ngaytraphong){
//                $count++;
//            }
//        }
//        if ($count == 0){
////            echo 'Success';
//            $datphong_phong = new DatPhong_Phong();
//            $datphong_phong->datphong_id = $datphong_id;
//            $datphong_phong->phong_id = $phong_id;
//            $datphong_phong->save();
//            $_SESSION['nhanvien_success_message'] = 'Thêm mới thành công';
//            return redirect(route('datphong_phong-list'));
//
//        }else{
//            $_SESSION['err_message'] = 'Phòng bạn chọn trong khoảng thời gian trên đã có người đặt trước, vui lòng chọn phòng khác!';
//            $datphong = new DatPhong();
//            $getDatPhongById = $datphong->find($datphong_id)->toArray();
//            $phongList = DB::table('tbl_phong')
//                ->join('tbl_loaiphong', 'tbl_phong.loaiphong_id', '=', 'tbl_loaiphong.id_loaiphong')
//                ->get()->toArray();
//            return view('datphong_phong/add')
//                ->with('getDatPhongById', $getDatPhongById)
//                ->with('phongList', $phongList);
//        }
//    }

    public function delete($id){
        $datphong_id = DB::table('tbl_datphong_phong')
            ->where('id_datphong_phong', '=', $id)
            ->pluck('datphong_id')->toArray();
        DatPhong_Phong::find($id)->delete();
        $_SESSION['nhanvien_success_message'] = 'Xóa thành công';
        $getDatphong_phongByDatphong_id = DB::table('tbl_datphong_phong')
            ->where('datphong_id', '=', $datphong_id[0])
            ->get()->toArray();
//        dd($getDatphong_phongByDatphong_id);
//        dd(count($getDatphong_phongByDatphong_id));
        if (count($getDatphong_phongByDatphong_id) == 0){
            DB::table('tbl_datphong')
                ->where('id_datphong', '=', $datphong_id)
                ->update([
                    'trangthaidatphong' => -1
                ]);
        }
        return redirect()->action('DatPhong_PhongController@index');
    }

    public function update($id){
        $datphong_phong = new DatPhong_Phong();
        $getDatPhong_PhongById = $datphong_phong->find($id)->toArray();
//        dd($getDatPhong_PhongById);
        $getDatPhongById = DB::table('tbl_datphong_phong')
            ->join('tbl_datphong', 'tbl_datphong_phong.datphong_id', '=', 'tbl_datphong.id_datphong')
            ->where('datphong_id', '=', $getDatPhong_PhongById['datphong_id'])
            ->get()->toArray();
//        dd($getDatPhongById);
        $phongList = DB::table('tbl_phong')
            ->join('tbl_loaiphong', 'tbl_phong.loaiphong_id', '=', 'tbl_loaiphong.id_loaiphong')
            ->get()->toArray();
//        dd($getDatPhong_PhongById);
        return view('datphong_phong/update')
            ->with('getDatPhongById', $getDatPhongById)
            ->with('getDatPhong_PhongById', $getDatPhong_PhongById)
            ->with('phongList', $phongList);
    }

    public function updatesave(){
//        dd($_POST);
        $id_datphong_phong = $_POST['txt_id_datphong_phong'];
        $datphong_id = $_POST['txt_datphong_id'];
        $phong_id = $_POST['sl_phong_id'];
        $getDatPhongById_ngaynhanphong = $_POST['txt_getDatPhongById_ngaynhanphong'];
        $getDatPhongById_ngaytraphong = $_POST['txt_getDatPhongById_ngaytraphong'];
        $phongListWithOneId = DB::table('tbl_datphong_phong')
            ->join('tbl_datphong', 'tbl_datphong_phong.datphong_id', '=', 'tbl_datphong.id_datphong')
            ->where('phong_id', '=', $phong_id)
            ->get()->toArray();
//        dd($phongListWithOneId);
        $count = 0;
        foreach ($phongListWithOneId as $phongWithOneId){
               if ($getDatPhongById_ngaynhanphong <= $phongWithOneId->ngaynhanphong || $getDatPhongById_ngaytraphong >= $phongWithOneId->ngaytraphong){
                $count++;
            }
        }
        if ($count == 0){
//            echo 'Success';
            $datphong_phong = new DatPhong_Phong();
            $getDatPhong_PhongById =$datphong_phong->find($id_datphong_phong);
            $getDatPhong_PhongById->phong_id = $phong_id;
            $getDatPhong_PhongById->save();
            $_SESSION['nhanvien_success_message'] = 'Đổi phòng thành công';
            return redirect(route('datphong_phong-list'));

        }else{
            $_SESSION['err_message'] = 'Phòng bạn chọn trong khoảng thời gian trên đã có người đặt trước, vui lòng chọn phòng khác!';
            $getDatPhongById = DB::table('tbl_datphong_phong')
                ->join('tbl_datphong', 'tbl_datphong_phong.datphong_id', '=', 'tbl_datphong.id_datphong')
                ->where('datphong_id', '=', $datphong_id)
                ->get()->toArray();
            $datphong_phong = new DatPhong_Phong();
            $getDatPhong_PhongById = $datphong_phong->find($id_datphong_phong)->toArray();
            $phongList = DB::table('tbl_phong')
                ->join('tbl_loaiphong', 'tbl_phong.loaiphong_id', '=', 'tbl_loaiphong.id_loaiphong')
                ->get()->toArray();
            return view('datphong_phong/update')
                ->with('getDatPhongById', $getDatPhongById)
                ->with('getDatPhong_PhongById', $getDatPhong_PhongById)
                ->with('phongList', $phongList);
        }
    }
}
