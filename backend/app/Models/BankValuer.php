<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankValuer extends Model
{
    protected $table = 'bank_valuers';

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function valuer()
    {
        return $this->belongsTo(Valuer::class);
    }
}
