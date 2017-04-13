<?php

namespace App\Apis\OpenDota\Models;

use Jenssegers\Model\Model;

/**
 * Class Mmr
 *
 * @package App\Apis\OpenDota\Models
 *
 * @property integer $estimate
 * @property integer $stdDev
 * @property integer $n
 */
class Mmr extends Model
{
    public function __construct($attributes = [])
    {
        parent::__construct((array)$attributes);
    }
}
