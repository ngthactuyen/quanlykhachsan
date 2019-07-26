<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::get('nhanvien', 'NhanVienController@index')->name('nhanvien-list');
Route::get('nhanvien/add', 'NhanVienController@add')->name('nhanvien-add');
Route::post('nhanvien/add', 'NhanVienController@addsave')->name('nhanvien-addsave');
Route::get('nhanvien/{id}/update', 'NhanVienController@update')->name('nhanvien-update');
Route::post('nhanvien/update', 'NhanVienController@updatesave')->name('nhanvien-updatesave');
//Route::post('nhanvien/delete', 'NhanVienController@delete')->name('nhanvien-delete');
Route::get('nhanvien/{id}/delete', 'NhanVienController@delete')->name('nhanvien-delete');
Route::get('nhanvien/login', 'NhanVienController@login')->name('nhanvien-login');
Route::post('nhanvien/login', 'NhanVienController@authenticate')->name('nhanvien-authenticate');
Route::get('nhanvien/logout', 'NhanVienController@logout')->name('nhanvien-logout');


Route::get('khachhang', 'KhachHangController@index')->name('khachhang-list');
Route::get('khachhang/add', 'KhachHangController@add')->name('khachhang-add');
Route::post('khachhang/add', 'KhachHangController@addsave')->name('khachhang-addsave');
Route::get('khachhang/{id}/update', 'KhachHangController@update')->name('khachhang-update');
Route::post('khachhang/update', 'KhachHangController@updatesave')->name('khachhang-updatesave');
Route::get('khachhang/{id}/delete', 'KhachHangController@delete')->name('khachhang-delete');
Route::get('khachhang/login', 'KhachHangController@login')->name('khachhang-login');
Route::post('khachhang/login', 'KhachHangController@authenticate')->name('khachhang-authenticate');
Route::get('khachhang/logout', 'KhachHangController@logout')->name('khachhang-logout');


Route::get('dichvu', 'DichVuController@index')->name('dichvu-list');
Route::get('dichvu/add', 'DichVuController@add')->name('dichvu-add');
Route::post('dichvu/add', 'DichVuController@addsave')->name('dichvu-addsave');
Route::get('dichvu/{id}/update', 'DichVuController@update')->name('dichvu-update');
Route::post('dichvu/update', 'DichVuController@updatesave')->name('dichvu-updatesave');
Route::get('dichvu/{id}/delete', 'DichVuController@delete')->name('dichvu-delete');


Route::get('loaiphong', 'LoaiPhongController@index')->name('loaiphong-list');
Route::get('loaiphong/add', 'LoaiPhongController@add')->name('loaiphong-add');
Route::post('loaiphong/add', 'LoaiPhongController@addsave')->name('loaiphong-addsave');
Route::get('loaiphong/{id}/update', 'LoaiPhongController@update')->name('loaiphong-update');
Route::post('loaiphong/update', 'LoaiPhongController@updatesave')->name('loaiphong-updatesave');
Route::get('loaiphong/{id}/delete', 'LoaiPhongController@delete')->name('loaiphong-delete');


Route::get('phong', 'PhongController@index')->name('phong-list');
Route::get('phong/add', 'PhongController@add')->name('phong-add');
Route::post('phong/add', 'PhongController@addsave')->name('phong-addsave');
Route::get('phong/{id}/update', 'PhongController@update')->name('phong-update');
Route::post('phong/update', 'PhongController@updatesave')->name('phong-updatesave');
Route::get('phong/{id}/delete', 'PhongController@delete')->name('phong-delete');
Route::post('phong/updatetrangthai', 'PhongController@updatetrangthai')->name('phong-updatetrangthai');


Route::get('datphong', 'DatPhongController@index')->name('datphong-list');
Route::get('datphong/add', 'DatPhongController@add')->name('datphong-add');
Route::post('datphong/add', 'DatPhongController@addsave')->name('datphong-addsave');
Route::get('datphong/{id}/update', 'DatPhongController@update')->name('datphong-update');
Route::post('datphong/update', 'DatPhongController@updatesave')->name('datphong-updatesave');
Route::get('datphong/{id}/delete', 'DatPhongController@delete')->name('datphong-delete');
Route::get('datphong/{id}/updatetrangthai', 'DatPhongController@updatetrangthai')->name('datphong-updatetrangthai');


Route::get('datphong_phong', 'DatPhong_PhongController@index')->name('datphong_phong-list');
Route::get('datphong_phong/{id}/add', 'DatPhong_PhongController@add')->name('datphong_phong-add');
Route::post('datphong_phong/add', 'DatPhong_PhongController@addsave')->name('datphong_phong-addsave');
Route::get('datphong_phong/{id}/update', 'DatPhong_PhongController@update')->name('datphong_phong-update');
Route::post('datphong_phong/update', 'DatPhong_PhongController@updatesave')->name('datphong_phong-updatesave');
Route::get('datphong_phong/{id}/delete', 'DatPhong_PhongController@delete')->name('datphong_phong-delete');


Route::get('dichvu_phong', 'DichVu_PhongController@index')->name('dichvu_phong-list');
Route::get('dichvu_phong/{id}/add', 'DichVu_PhongController@add')->name('dichvu_phong-add');
Route::post('dichvu_phong/add', 'DichVu_PhongController@addsave')->name('dichvu_phong-addsave');
Route::get('dichvu_phong/{id}/update', 'DichVu_PhongController@update')->name('dichvu_phong-update');
Route::post('dichvu_phong/update', 'DichVu_PhongController@updatesave')->name('dichvu_phong-updatesave');
Route::get('dichvu_phong/{id}/delete', 'DichVu_PhongController@delete')->name('dichvu_phong-delete');
Route::get('dichvu_phong/statistic', 'DichVu_PhongController@statistic')->name('dichvu_phong-statistic');
Route::post('dichvu_phong/updatetrangthai', 'DichVu_PhongController@updatetrangthai')->name('dichvu_phong-updatetrangthai');


Route::get('hoadon', 'HoaDonController@index')->name('hoadon-list');
Route::get('hoadon/add', 'HoaDonController@add')->name('hoadon-add');
Route::post('hoadon/chonphongthanhtoan', 'HoaDonController@chonphongthanhtoan')->name('hoadon-chonphongthanhtoan');
Route::post('hoadon/tinhtongtien', 'HoaDonController@tinhtongtien')->name('hoadon-tinhtongtien');
Route::post('hoadon/thanhtoan', 'HoaDonController@thanhtoan')->name('hoadon-thanhtoan');
Route::get('hoadon/{id}/delete', 'HoaDonController@delete')->name('hoadon-delete');

