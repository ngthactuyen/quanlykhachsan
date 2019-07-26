<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HoaDon extends Model
{
    protected $table = 'tbl_hoadon';
    protected $primaryKey = 'id_hoadon';
    public $timestamps = false;
}
