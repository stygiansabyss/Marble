<?php

namespace App\Apis\OpenDota\Models;

use Jenssegers\Model\Model;

/**
 * Class Player
 *
 * @package App\Apis\OpenDota\Models
 *
 * @property string $tracked_until
 * @property string $solo_competitive_rank
 * @property string $competitive_rank
 * @property object $profile
 *
 * @property \App\Apis\OpenDota\Models\Mmr $mmr_estimate
 */
class Player extends Model
{
    public function __construct($attributes = [])
    {
        parent::__construct((array)$attributes);
    }

    public function setMmrEstimateAttribute($value)
    {
        $this->attributes['mmr_estimate'] = new Mmr($value);
    }
}
