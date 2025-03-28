<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankStaff extends Model
{
    protected $table = 'bank_staff';
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
