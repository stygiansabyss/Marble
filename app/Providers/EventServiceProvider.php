<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            // add your listeners (aka providers) here
            // 'App\Providers\Socialite\TwitchExtend@handle',
            'SocialiteProviders\Twitch\TwitchExtendSocialite@handle',
        ],

        \JumpGate\Users\Events\UserLoggedIn::class            => [
            \App\Services\Subscriptions\Listeners\UpdateStatus::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
