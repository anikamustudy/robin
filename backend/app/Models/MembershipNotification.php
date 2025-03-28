<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipNotification extends Model
{

    use HasFactory;

    protected $table = 'membership_notifications';

    protected $fillable = [
        'membership_request_id',
        'user_id',
        'type',
        'message',
        'sent_at',
    ];



    public function membershipRequest()
    {
        return $this->belongsTo(MembershipRequest::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
