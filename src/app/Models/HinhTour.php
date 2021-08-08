<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HinhTour extends Model
{
    //

    protected $hidden = ['t_id', 'created_at', 'updated_at'];
    public function tour()
    {
        return $this->belongsTo('App\Models\Tour', 't_id', 'id');
    }
}
