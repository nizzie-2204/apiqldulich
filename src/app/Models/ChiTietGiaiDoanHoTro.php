<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiTietGiaiDoanHoTro extends Model
{
    //
    protected $fillable = ['ctgdhotro_tuthamnien', 'ctgdhotro_denthamnien', 'ctgdhotro_sotienhotro', 'ctgdhotro_diengiai', 'dv_id'];
    protected $hidden = [
        'created_at', 'updated_at', 'gd_id'
    ];

    public function giaidoan()
    {
        return $this->belongsTo('App\Models\GiaiDoanHoTro', 'gd_id', 'id');
    }
}
