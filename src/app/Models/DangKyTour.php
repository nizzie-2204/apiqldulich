<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DangKyTour extends Model
{
    //
    protected $guarded = [];

    protected $hidden = [
        'deteled_at', 'created_at', 'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'nv_id', 'id');
    }


    public function tour()
    {
        return $this->belongsTo('App\Models\Tour', 't_id', 'id');
    }
}
