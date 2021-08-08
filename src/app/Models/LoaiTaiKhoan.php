<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoaiTaiKhoan extends Model
{
    //
    public function user()
    {
        return $this->hasMany('App\User', 'ltk_id', 'id');
    }
}
