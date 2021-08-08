<?php

namespace App;

use App\LoaiTaiKhoan as AppLoaiTaiKhoan;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['username', 'id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',  'dv_id', 'deleted_at', 'created_at', 'updated_at',
    ];

    public function donvi()
    {
        return $this->belongsTo('App\Models\DonVi', 'dv_id', 'id');
    }

    public function loaitaikhoan()
    {
        return $this->belongsTo('App\Models\LoaiTaiKhoan', 'ltk_id', 'id');
    }

    public function dangkytour()
    {
        return $this->hasMany('App\Models\DangKyTour', 'nv_id', 'id');
    }

    public function nhanhotro()
    {
        return $this->hasMany('App\Models\NhanVienNhanHoTroTour', 'nv_id', 'id');
    }
}
