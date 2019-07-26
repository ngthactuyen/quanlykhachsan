<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class NhanVien extends Model
{
    protected $table = 'tbl_nhanvien';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function findByTendangnhap($tendangnhap){
        $result = DB::select("select * from $this->table where tendangnhap like '$tendangnhap'");
        return $result;
    }
}
