<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoaiPhong extends Model
{
    protected $table = 'tbl_loaiphong';
    protected $primaryKey = 'id_loaiphong';
    public $timestamps = false;
}
