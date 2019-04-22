<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KhachHang extends Model
{
    protected $table = 'tbl_khachhang';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
