<?php

namespace App\Providers\Socialite;

use GuzzleHttp\ClientInterface;
use SocialiteProviders\Twitch\Provider;

class TwitchProvider extends Provider
{
    public function getAccessTokenResponse($code)
    {
        return [
            'access_token' => $this->getAccessToken($code),
        ];
    }

    /**
     * Get the access token for the given code.
     *
     * @param  string $code
     *
     * @return string
     */
    public function getAccessToken($code)
    {
        $postKey = (version_compare(ClientInterface::VERSION, '6') === 1) ? 'form_params' : 'body';

        $response = $this->getHttpClient()->post($this->getTokenUrl(), [
            'headers' => ['Accept' => 'application/json'],
            $postKey  => $this->getTokenFields($code),
        ]);

        return $this->parseAccessToken((array)json_decode($response->getBody()->getContents()));
    }
}
