<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ValuerStaff extends Model
{
    protected $table = 'valuer_staff';
    public function valuer()
    {
        return $this->belongsTo(Valuer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
