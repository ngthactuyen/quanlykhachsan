<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\NhanVien;
use Illuminate\Http\Request;

class NhanVienController extends Controller
{
//    public function index(){
//        if (isset($_SESSION['tenNhanVien'])){
//            $nhanvienList = \App\NhanVien::all()->toArray();
////            dd($nhanvienList);
//            return view('nhanvien/index', ['nhanvienList' => $nhanvienList]);
//
//        }else{
//            $_SESSION['err_message'] = 'Bạn cần đăng nhập trước khi truy cập hệ thống!';
//            return redirect(route('nhanvien-login'));
//        }
//    }

    public function index(){
        if (isset($_SESSION['tenNhanVien'])){
//            $nhanvienList = \App\NhanVien::all()->toArray();
            $keyword = isset($_GET['txt_keyword']) ? $_GET['txt_keyword'] : '';
            $nhanvienList = DB::table('tbl_nhanvien')
                ->where('hoten', 'like', "%$keyword%")
                ->orWhere('diachi', 'like', "%$keyword%")
                ->orWhere('email', 'like', "%$keyword%")
                ->orWhere('sdt', 'like', "$keyword")
                ->orWhere('socmnd', 'like', "$keyword")
                ->orderBy('hoten')
                ->paginate(4);
//            dd($nhanvienList);
            return view('nhanvien/index', ['nhanvienList' => $nhanvienList]);

        }else{
            $_SESSION['err_message'] = 'Bạn cần đăng nhập trước khi truy cập hệ thống!';
            return redirect(route('nhanvien-login'));
        }
    }

    public function delete($id){
//        $id = $_POST['txt_id'];
//        $nhanvien = NhanVien::find($id);
//        $nhanvien->delete();
//        return redirect(route('nhanvien-list'));
        NhanVien::find($id)->delete();
        $_SESSION['nhanvien_success_message'] = 'Xóa thành công';

        return redirect()->action('NhanVienController@index');
    }

    public function add(){
        return view('nhanvien/add');
    }

    public function addsave(){
        $hoten = $_POST['txt_hoten'];
        $gioitinh = $_POST['rd_gioitinh'];
        $diachi = $_POST['txt_diachi'];
        $email = $_POST['txt_email'];
        $sdt = $_POST['txt_sdt'];
        $socmnd = $_POST['txt_socmnd'];
        $tendangnhap = $_POST['txt_tendangnhap'];
        $matkhau = $_POST['txt_matkhau'];
        $phanquyen = $_POST['sl_phanquyen'];

        $nhanvien = new NhanVien();
        $nhanvien->hoten = $hoten;
        $nhanvien->gioitinh = $gioitinh;
        $nhanvien->diachi = $diachi;
        $nhanvien->email = $email;
        $nhanvien->sdt = $sdt;
        $nhanvien->socmnd = $socmnd;
        $nhanvien->tendangnhap = $tendangnhap;
        $nhanvien->matkhau = $matkhau;
        $nhanvien->phanquyen = $phanquyen;

        $nhanvien->save();
        $_SESSION['nhanvien_success_message'] = 'Thêm mới thành công';

        return redirect(route('nhanvien-list'));
    }

    public function update($id){
//        $id = $_POST['txt_id'];
//        $nhanvien = NhanVien::find($id);

        $nhanvien = new NhanVien();
        $getNhanVienById = $nhanvien->find($id)->toArray();
        return view('nhanvien/update')->with('getNhanVienById', $getNhanVienById);
    }

    public function updatesave(){
        $id = $_POST['txt_id'];
        $hoten = $_POST['txt_hoten'];
        $gioitinh = $_POST['rd_gioitinh'];
        $diachi = $_POST['txt_diachi'];
        $email = $_POST['txt_email'];
        $sdt = $_POST['txt_sdt'];
        $socmnd = $_POST['txt_socmnd'];
        $tendangnhap = $_POST['txt_tendangnhap'];
        $matkhau = $_POST['txt_matkhau'];
        $phanquyen = $_POST['sl_phanquyen'];

        $nhanvien = new NhanVien();
        $getNhanVienById = $nhanvien->find($id);
        $getNhanVienById->hoten = $hoten;
        $getNhanVienById->gioitinh = $gioitinh;
        $getNhanVienById->diachi = $diachi;
        $getNhanVienById->email = $email;
        $getNhanVienById->sdt = $sdt;
        $getNhanVienById->socmnd = $socmnd;
        $getNhanVienById->tendangnhap = $tendangnhap;
        $getNhanVienById->matkhau = $matkhau;
        $getNhanVienById->phanquyen = $phanquyen;

        $getNhanVienById->save();
        $_SESSION['nhanvien_success_message'] = 'Sửa thành công';

        return redirect(route('nhanvien-list'));
    }

    public function login(){
        if (isset($_SESSION['tenNhanVien'])){
            return redirect(route('phong-list'));
        }else{
            return view('nhanvien/login');
        }
    }

    public function logout(){
        unset($_SESSION['tenNhanVien']);
        return view('nhanvien/login');
    }

    public function authenticate(){
        $tendangnhap = @$_POST['txt_tendangnhap'];
        $matkhau = @$_POST['txt_matkhau'];
        $nhanvien = new NhanVien();
        $getNhanVienByTendangnhap = $nhanvien->where('tendangnhap', 'like', $tendangnhap)->get()->toArray();
        if (!$getNhanVienByTendangnhap){
            $_SESSION['err_message'] = 'Tên tài khoản sai hoặc không tồn tại!';
            return redirect(route('nhanvien-login'));
        }elseif ($getNhanVienByTendangnhap[0]['matkhau'] != $matkhau){
            $_SESSION['err_message'] = 'Mật khẩu đăng nhập sai!';
            return redirect(route('nhanvien-login'));
        }else{
            $_SESSION['nhanvien_success_message'] = 'Đăng nhập thành công';
            $_SESSION['tenNhanVien'] = $getNhanVienByTendangnhap[0]['hoten'];
            $_SESSION['idNhanVien'] = $getNhanVienByTendangnhap[0]['id'];
            $_SESSION['phanquyen'] = $getNhanVienByTendangnhap[0]['phanquyen'];
            return redirect(route('phong-list'));
//            return view('layout/backend');
        }
//        var_dump($getNhanVienByTendangnhap);
//        echo "<br>";
//        var_dump($_POST);
//        echo "<br>";
//        var_dump($_SESSION);
    }

}
