<?php

namespace App\Apis\OpenDota;

use App\Apis\BaseClient;
use Syntax\SteamApi\Facades\SteamApi;

class Client extends BaseClient
{
    protected $url = 'https://api.opendota.com/api/';

    protected function getSteamId($id)
    {
        $id = SteamApi::convertId($id, 3);

        preg_match('/\[U\:\d\:(\d+)\]/', $id, $matches);

        return isset($matches[1]) ? $matches[1] : null;
    }

    protected function getUrl()
    {
        if (! isset($this->section)) {
            throw new \InvalidArgumentException('The section property needs to be set on ' . get_called_class());
        }

        return $this->url . $this->section;
    }
}
