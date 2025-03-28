<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Valuer extends Model
{
    protected $table = 'valuers';
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function staff()
    {
        return $this->hasMany(ValuerStaff::class);
    }

    public function banks()
    {
        return $this->belongsToMany(Bank::class, 'bank_valuer')->withPivot('branch_id');
    }

    public function membershipRequests()
    {
        return $this->hasMany(MembershipRequest::class);
    }


}
