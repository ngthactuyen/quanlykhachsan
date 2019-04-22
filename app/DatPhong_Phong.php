<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DatPhong_Phong extends Model
{
    protected $table = 'tbl_datphong_phong';
    protected $primaryKey = 'id_datphong_phong';
    public $timestamps = false;
}
