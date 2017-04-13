<?php

namespace App\Apis;

use GuzzleHttp\Client;

abstract class BaseClient extends Client
{
    /**
     * Make sure the url is set and assign it as the base.
     *
     * @param array $config
     *
     * @throws \Exception
     */
    public function __construct(array $config = [])
    {
        if (! isset($this->url)) {
            throw new \Exception('Please set the url property on ' . get_called_class() . '.');
        }

        parent::__construct(array_merge(['base_uri' => $this->url], $config));
    }
}
