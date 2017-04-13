<?php

namespace App\Apis\OpenDota;

use App\Apis\OpenDota\Models\Player;

class Players extends Client
{
    protected $section = 'players';

    public function getPlayer($steamId)
    {
        $steamId = $this->getSteamId($steamId);

        $response = $this->get($this->getUrl() .'/'. $steamId);

        return new Player(json_decode($response->getBody()->getContents()));
    }
}
