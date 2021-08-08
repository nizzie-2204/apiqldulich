<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tour extends Model
{
    //
    use SoftDeletes;

    protected $guarded = ['id'];
    protected $hidden = ['dv_id', 'created_at', 'updated_at', 'deleted_at'];

    public function hinhtour()
    {
        return $this->hasMany('App\Models\HinhTour', 't_id', 'id');
    }

    public function donvi()
    {
        return $this->belongsTo('App\Models\DonVi', 'dv_id', 'id');
    }

    public function dangkytour()
    {
        return $this->hasMany('App\Models\DangKyTour', 't_id', 'id');
    }
}
