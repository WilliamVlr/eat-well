<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    protected $table = 'user_activities';

    protected $fillable = [
        'userId', 'name', 'role', 'url', 'method', 'ip_address', 'accessed_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'userId');
    }
}
