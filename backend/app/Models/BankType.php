<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;

class BankType extends Model
{
    use HasFactory;

    protected $table = 'bank_types';

    protected $fillable = [
        'name',
        'created_by',
        'slug',
        'description',
    ];
    public static function boot()
    {
        parent::boot();

        static::creating(function ($bankType) {
            $bankType->slug = Str::slug($bankType->name);
        });

        static::updating(function ($bankType) {
            $bankType->slug = Str::slug($bankType->name);
        });
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function banks()
    {
        return $this->hasMany(Bank::class);
    }
}
