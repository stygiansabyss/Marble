<?php

namespace App\Apis\Twitch\Models;

use Jenssegers\Model\Model;

/**
 * Class User
 *
 * @property string  $id
 * @property string  $type
 * @property string  $name
 * @property string  $created_at
 * @property string  $updated_at
 * @property array   $links
 * @property string  $logo
 * @property string  $display_name
 * @property string  $email
 * @property boolean $partnered
 * @property string  $bio
 * @property array   $notifications
 *
 * @property string  $token
 * @property boolean $subscribed
 */
class User extends Model
{
    public function __construct(array $attributes = [])
    {
        if (isset($attributes['_id'])) {
            $attributes['id'] = $attributes['_id'];
            unset($attributes['_id']);
        }

        parent::__construct($attributes);
    }

    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    public function setSubscribed($subscribed)
    {
        $this->subscribed = $subscribed;

        return $this;
    }
}
