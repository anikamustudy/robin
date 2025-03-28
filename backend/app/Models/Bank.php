<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{

    use HasFactory;

    protected $table = 'banks';

    protected $fillable = [
        'bank_type_id',
        'user_id',
        'bank_name',
        'bank_address',
        'bank_contact_number'
    ];


    public function bankType()
    {
        return $this->belongsTo(BankType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function staff()
    {
        return $this->hasMany(BankStaff::class);
    }

    public function valuers()
    {
        return $this->belongsToMany(Valuer::class, 'bank_valuer')->withPivot('branch_id');
    }
    public function membershipRequests()
    {
        return $this->hasMany(MembershipRequest::class);
    }
}
