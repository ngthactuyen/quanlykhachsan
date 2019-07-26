<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DatPhong extends Model
{
    protected $table = 'tbl_datphong';
    protected $primaryKey = 'id_datphong';
    public $timestamps = false;
}
