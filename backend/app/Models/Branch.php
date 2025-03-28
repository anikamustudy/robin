<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $table = 'branches';

    protected $fillable = [
        'bank_id',
        'branch_code',
        'branch_name',
        'branch_address',
        'branch_contact_number',
    ];


    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function staff()
    {
        return $this->hasMany(BankStaff::class);
    }
}
