<?php
use Illuminate\Support\Facades\DB;
//$getDatPhongById['id_datphong'];
//$datphong_phong->tenphong;

$DanhSachdatphong_phong = DB::table('tbl_datphong_phong')->select('phong_id');
dd($DanhSachdatphong_phong);
