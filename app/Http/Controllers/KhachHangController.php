<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\KhachHang;
use Illuminate\Http\Request;

class KhachHangController extends Controller
{
    public function index(){
//        $khachhangList = \App\KhachHang::all()->toArray();
        $keyword = isset($_GET['txt_keyword']) ? $_GET['txt_keyword'] : '';
        $khachhangList = DB::table('tbl_khachhang')->where('hoten', 'like', "%$keyword%")->orWhere('diachi', 'like', "%$keyword%")->orWhere('email', 'like', "%$keyword%")->orWhere('sdt', 'like', "$keyword")->orWhere('socmnd', 'like', "$keyword")->paginate(4);
        return view('khachhang/index', ['khachhangList' => $khachhangList]);

    }

    public function add(){
        return view('khachhang/add');
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

        $khachhang = new KhachHang();
        $khachhang->hoten = $hoten;
        $khachhang->gioitinh = $gioitinh;
        $khachhang->diachi = $diachi;
        $khachhang->email = $email;
        $khachhang->sdt = $sdt;
        $khachhang->socmnd = $socmnd;
        $khachhang->tendangnhap = $tendangnhap;
        $khachhang->matkhau = $matkhau;

        $khachhang->save();
        $_SESSION['nhanvien_success_message'] = 'Thêm mới thành công';

        return redirect(route('khachhang-list'));
    }

    public function update($id){
        $khachhang = new KhachHang();
        $getKhachHangById = $khachhang->find($id)->toArray();
        return view('khachhang/update')->with('getKhachHangById', $getKhachHangById);
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

        $khachhang = new KhachHang();
        $getKhachHangById = $khachhang->find($id);
        $getKhachHangById->hoten = $hoten;
        $getKhachHangById->gioitinh = $gioitinh;
        $getKhachHangById->diachi = $diachi;
        $getKhachHangById->email = $email;
        $getKhachHangById->sdt = $sdt;
        $getKhachHangById->socmnd = $socmnd;
        $getKhachHangById->tendangnhap = $tendangnhap;
        $getKhachHangById->matkhau = $matkhau;

        $getKhachHangById->save();
        $_SESSION['nhanvien_success_message'] = 'Sửa thành công';

        return redirect(route('khachhang-list'));
    }

    public function delete($id){
        KhachHang::find($id)->delete();
        $_SESSION['nhanvien_success_message'] = 'Xóa thành công';
        return redirect()->action('KhachHangController@index');
    }

    public function login(){
        return view('khachhang/login');
    }

    public function logout(){
        unset($_SESSION['tenKhachHang']);
        return view('khachhang/login');
    }

    public function authenticate(){
        $tendangnhap = @$_POST['txt_tendangnhap'];
        $matkhau = @$_POST['txt_matkhau'];
        $khachhang = new KhachHang();
        $getKhachHangByTendangnhap = $khachhang->where('tendangnhap', 'like', $tendangnhap)->get()->toArray();
        if (!$getKhachHangByTendangnhap){
            $_SESSION['err_message'] = 'Tên tài khoản sai hoặc không tồn tại!';
            return redirect(route('khachhang-login'));
        }elseif ($getKhachHangByTendangnhap[0]['matkhau'] != $matkhau){
            $_SESSION['err_message'] = 'Mật khẩu đăng nhập sai!';
            return redirect(route('khachhang-login'));
        }else{
            $_SESSION['khachhang_success_message'] = 'Đăng nhập thành công';
            $_SESSION['tenKhachHang'] = $getKhachHangByTendangnhap[0]['hoten'];
            $_SESSION['idKhachHang'] = $getKhachHangByTendangnhap[0]['id'];

        }
        var_dump($getKhachHangByTendangnhap);
        echo "<br>";
        var_dump($_POST);
        echo "<br>";
        var_dump($_SESSION);
    }
}
