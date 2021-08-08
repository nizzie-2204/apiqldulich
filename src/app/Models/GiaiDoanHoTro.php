<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GiaiDoanHoTro extends Model
{
    //
    protected $guarded = [];
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function chitiet()
    {
        return $this->hasMany('App\Models\ChiTietGiaiDoanHoTro', 'gd_id', 'id');
    }

    public function nhanviennhan()
    {
        return $this->hasMany('App\Models\NhanVienNhanHoTroTour', 'gd_id', 'id');
    }

    public function donvi()
    {
        return $this->belongsTo('App\Models\DonVi', 'dv_id', 'id');
    }
}
