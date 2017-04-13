<?php

namespace App\Providers\Socialite;

use SocialiteProviders\Manager\SocialiteWasCalled;

class TwitchExtend
{
    /**
     * Register the provider.
     *
     * @param \SocialiteProviders\Manager\SocialiteWasCalled $socialiteWasCalled
     */
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite(
            'twitch', __NAMESPACE__.'\TwitchProvider'
        );
    }
}
