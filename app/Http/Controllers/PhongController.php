<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Phong;
use Illuminate\Http\Request;

class PhongController extends Controller
{
    public function index(){
//        $phongList = DB::table('tbl_loaiphong')->join('tbl_phong', 'tbl_loaiphong.id', '=', 'tbl_phong.loaiphong_id')->get()->toArray();
        $keyword = isset($_GET['txt_keyword']) ? $_GET['txt_keyword'] : '';
        $phongList = DB::table('tbl_loaiphong')
            ->join('tbl_phong', 'tbl_loaiphong.id_loaiphong', '=', 'tbl_phong.loaiphong_id')
            ->where('tenphong', 'like', "%$keyword%")
            ->orWhere('tenloaiphong', 'like', "%$keyword%")
            ->orderBy('trangthaiphong', 'desc')
            ->orderBy('tenphong')
//            ->simplePaginate(6);
            ->paginate(10);
//        dd($phongList);

        $phongKhongCoKhachList = DB::table('tbl_phong')
            ->where('trangthaiphong', '=', 0)
            ->get()->toArray();
//        dd($phongKhongCoKhachList);

        return view('phong/index', ['phongList' => $phongList])
            ->with('phongKhongCoKhachList', $phongKhongCoKhachList);
    }

    public function add(){
        $loaiphongList = \App\LoaiPhong::all()->toArray();
        return view('phong/add', ['loaiphongList' => $loaiphongList]);
    }

    public function addsave(){
        $tenphong = $_POST['txt_tenphong'];
//        $trangthaiphong = $_POST['rd_trangthaiphong'];
        $loaiphong_id = $_POST['sl_loaiphong_id'];

        $phong = new Phong();
        $phong->tenphong = $tenphong;
//        $phong->trangthaiphong = $trangthaiphong;
        $phong->loaiphong_id = $loaiphong_id;

        $phong->save();
        $_SESSION['nhanvien_success_message'] = 'Thêm mới thành công';

        return redirect(route('phong-list'));
    }

    public function update($id){
        $phong = new Phong();
        $getPhongById = $phong->find($id)->toArray();
        $loaiphongList = \App\LoaiPhong::all()->toArray();
        return view('phong/update')->with('getPhongById', $getPhongById)->with('loaiphongList', $loaiphongList);
    }

    public function updatesave(){
        $id = $_POST['txt_id'];
        $tenphong = $_POST['txt_tenphong'];
        $trangthaiphong = $_POST['rd_trangthaiphong'];
        $loaiphong_id = $_POST['sl_loaiphong'];

        $phong = new Phong();
        $getPhongById = $phong->find($id);
        $getPhongById->tenphong = $tenphong;
        $getPhongById->trangthaiphong = $trangthaiphong;
        $getPhongById->loaiphong_id = $loaiphong_id;

        $getPhongById->save();
        $_SESSION['nhanvien_success_message'] = 'Sửa thành công';

        return redirect(route('phong-list'));
    }

    public function delete($id){
        Phong::find($id)->delete();
        $_SESSION['nhanvien_success_message'] = 'Xóa thành công';

        return redirect()->action('PhongController@index');
    }

    public function updatetrangthai(){
        $phongList = $_POST['cb_phongList'];
        for ($i = 0; $i < count($phongList); $i++){
            DB::table('tbl_phong')
                ->where('id_phong', '=', $phongList[$i])
                ->update([
                    'trangthaiphong' => 1
                ]);
        }
        $_SESSION['nhanvien_success_message'] = 'Đã giao phòng cho khách';
        return redirect(route('phong-list'));
    }

}
