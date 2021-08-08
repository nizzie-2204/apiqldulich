<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NhanVienNhanHoTroTour extends Model
{
    //

    public function giaidoan()
    {
        return $this->belongsTo('App\Models\GiaiDoanHoTro', 'gd_id', 'id');
    }
    public function nhanvien()
    {
        return $this->belongsTo('App\Models\User', 'nv_id', 'id');
    }
}
