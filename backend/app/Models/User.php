<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable,HasApiTokens;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status'
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => 'string',
            'status' => 'string',
        ];
    }


    public function bank(){
        return $this->hasOne(Bank::class);
    }

    public function valuer(){
        return $this->hasOne(Valuer::class);
    }
    public function bankStaff()
    {
        return $this->hasOne(BankStaff::class);
    }

    public function valuerStaff()
    {
        return $this->hasOne(ValuerStaff::class);
    }

    public function reviewedRequests()
    {
        return $this->hasMany(MembershipRequest::class, 'reviewed_by');
    }

    public function notifications()
    {
        return $this->hasMany(MembershipNotification::class);
    }
}
