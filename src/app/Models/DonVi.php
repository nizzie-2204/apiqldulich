<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DonVi extends Model
{
    use SoftDeletes;

    //
    protected $guarded = [];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function user()
    {
        return $this->hasMany('App\User', 'dv_id', 'id');
    }

    public function tour()
    {
        return $this->hasMany('App\Tour', 'dv_id', 'id');
    }

    public function giaidoan()
    {
        return $this->hasMany('App\Models\GiaiDoanHoTro', 'dv_id', 'id');
    }
}
