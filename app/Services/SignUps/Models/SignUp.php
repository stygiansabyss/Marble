<?php

namespace App\Services\SignUps\Models;

use App\Models\BaseModel;
use App\Models\User;

class SignUp extends BaseModel
{
    const WEEKLY = 'weekly';

    protected $table = 'sign_ups';

    public function newSignUp($mmr)
    {
        return $this->create([
            'user_id' => auth()->id(),
            'mmr'     => $mmr,
            'type'    => self::WEEKLY,
        ]);
    }

    public function scopeWeekly($query)
    {
        return $query->where('type', self::WEEKLY);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
