<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\LoaiPhong;
use Illuminate\Http\Request;

class LoaiPhongController extends Controller
{
    public function index(){
//        $loaiphongList = \App\LoaiPhong::all()->toArray();
        $keyword = isset($_GET['txt_keyword']) ? $_GET['txt_keyword'] : '';
        $loaiphongList = DB::table('tbl_loaiphong')
            ->where('tenloaiphong', 'like', "%$keyword%")
            ->orWhere('giaphong', '=', "$keyword")
            ->orWhere('mota', 'like', "%$keyword%")
            ->paginate(4);
        return view('loaiphong/index', ['loaiphongList' => $loaiphongList]);
    }

    public function add(){
        return view('loaiphong/add');
    }

    public function addsave(){
        $tenloaiphong = $_POST['txt_tenloaiphong'];
        $giaphong = $_POST['txt_giaphong'];
        $mota = $_POST['txt_mota'];

        $loaiphong = new LoaiPhong();
        $loaiphong->tenloaiphong = $tenloaiphong;
        $loaiphong->giaphong = $giaphong;
        $loaiphong->mota = $mota;

        $loaiphong->save();
        $_SESSION['nhanvien_success_message'] = 'Thêm mới thành công';
        return redirect(route('loaiphong-list'));
    }

    public function update($id){
        $loaiphong = new LoaiPhong();
        $getLoaiPhongById = $loaiphong->find($id)->toArray();
        return view('loaiphong/update')->with('getLoaiPhongById', $getLoaiPhongById);
    }

    public function updatesave(){
        $id = $_POST['txt_id'];
        $tenloaiphong = $_POST['txt_tenloaiphong'];
        $giaphong = $_POST['txt_giaphong'];
        $mota = $_POST['txt_mota'];

        $loaiphong = new LoaiPhong();
        $getLoaiPhongById = $loaiphong->find($id);
        $getLoaiPhongById->tenloaiphong = $tenloaiphong;
        $getLoaiPhongById->giaphong = $giaphong;
        $getLoaiPhongById->mota = $mota;

        $getLoaiPhongById->save();
        $_SESSION['nhanvien_success_message'] = 'Sửa thành công';

        return redirect(route('loaiphong-list'));
    }

    public function delete($id){
        LoaiPhong::find($id)->delete();
        $_SESSION['nhanvien_success_message'] = 'Xóa thành công';

        return redirect()->action('LoaiPhongController@index');
    }
}
