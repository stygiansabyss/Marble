<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use JumpGate\Users\Models\User as BaseUser;
use JumpGate\Users\Traits\HasSocials;

class User extends BaseUser
{
    use Notifiable;

    use HasSocials;

    /**
     * Check if the user is currently subscribed to twitch.
     *
     * @return bool
     */
    public function isSubscribed()
    {
        return $this->subscribed_flag === 1;
    }

    public function setSubscribed($value)
    {
        $this->subscribed_flag = $value;
        $this->save();
    }
}
