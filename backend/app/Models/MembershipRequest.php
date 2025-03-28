<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipRequest extends Model
{
    use HasFactory;

    protected $table = 'membership_requests';


    protected $fillable =[
        'email',
        'name',
        'role',
        'bank_id',
        'branch_id',
        'valuer_id',
        'status',
        'reason',
        'temp_password',
        'requested_at',
        'reviewed_at',
        'reviewed_by',
    ];

    protected $casts = [
        'role' => 'string',
        'status' => 'string',
        'requested_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

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

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function notifications()
    {
        return $this->hasMany(MembershipNotification::class);
    }


}
