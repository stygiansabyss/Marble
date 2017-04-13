<?php

namespace App\Services\Subscriptions\Listeners;

use App\Apis\Twitch\Models\User;
use JumpGate\Users\Events\UserLoggedIn;
use Zarlach\TwitchApi\Services\TwitchApiService;

class UpdateStatus
{
    /**
     * @var string|null
     */
    private $subscribed = null;

    /**
     * @var \Zarlach\TwitchApi\Services\TwitchApiService
     */
    private $twitch;

    /**
     * @param \Zarlach\TwitchApi\Services\TwitchApiService $twitch
     */
    public function __construct(TwitchApiService $twitch)
    {
        $this->twitch = $twitch;
    }

    /**
     * Entry point to handle updating a user's subscription status.
     *
     * @param \JumpGate\Users\Events\UserLoggedIn $event
     */
    public function handle(UserLoggedIn $event)
    {
        $twitchUser = new User($event->socialUser->user);

        $this->checkForActiveSubscription($twitchUser);

        if (! is_null($this->subscribed)) {
            return auth()->user()->setSubscribed(1);
        }

        return auth()->user()->setSubscribed(0);
    }

    /**
     * Check the Twitch API for a valid subscription.
     * Twitch throw errors when not subscribed.
     *
     * @param \App\Apis\Twitch\Models\User $twitchUser
     */
    private function checkForActiveSubscription(User $twitchUser)
    {
        $channel = config('site.twitch.id');
        $token   = auth()->user()->getProvider('twitch')->token;

        try {
            $subscription = $this->twitch->subscribedToChannel(
                $channel,
                $twitchUser->id,
                $token
            );

            $this->subscribed = $subscription['created_at'];
        } catch (\Exception $exception) {
            $this->subscribed = null;
        }
    }

    /**
     * Determine a user's current subscription status.
     *
     * @return \App\Services\Subscriptions\Models\History
     */
    private function setStatus()
    {
        // Get any existing subscription
        $subscription = auth()->user()->subscriptions->last();

        // If they don't have an entry, create the first one.
        if (is_null($subscription)) {
            return $this->createNewHistory();
        }

        // If the user is no longer a subscriber, mark it and remove their benefits.
        if (is_null($this->subscribed) && ! is_null($subscription->subscribed_on) && is_null($subscription->unsubscribed_on)) {
            return $this->unsubscribed($subscription);
        }

        // If the user is currently subscribed, but were not before, set the date they subscribed on.
        if ($this->subscribed && is_null($subscription->subscribed_on)) {
            return $this->subscribed($subscription);
        }

        // If the user has subscribed, then unsubscribed but subscribed again, create a new record.
        if (! is_null($subscription->subscribed_on) && ! is_null($subscription->unsubscribed_on) && $this->subscribed) {
            return $this->createNewHistory();
        }
    }

    /**
     * Create a new subscription entry for a user.
     *
     * @return \App\Services\Subscriptions\Models\History
     */
    private function createNewHistory()
    {
        if (! is_null($this->subscribed)) {
            auth()->user()->setSubscribed(1);
        }

        return $this->subscriptions->create([
            'user_id'         => auth()->id(),
            'subscribed_on'   => $this->subscribed,
            'unsubscribed_on' => null,
        ]);
    }

    /**
     * Mark a user as subscribed to Twitch.
     *
     * @param \App\Services\Subscriptions\Models\History $subscription
     *
     * @return \App\Services\Subscriptions\Models\History
     */
    private function subscribed($subscription)
    {
        auth()->user()->setSubscribed(1);

        $subscription->subscribe($this->subscribed);

        // todo - add this back in when members are in
        //event(new SubscriptionWasCreated($user));

        return $subscription;
    }

    /**
     * Mark a user as unsubscribed from Twitch.
     *
     * @param \App\Services\Subscriptions\Models\History $subscription
     *
     * @return \App\Services\Subscriptions\Models\History
     */
    private function unsubscribed($subscription)
    {
        auth()->user()->setSubscribed(0);

        $subscription->unSubscribe();

        // todo - add this back in when members are in
        //event(new SubscriptionWasCancelled($user));

        return $subscription;
    }
}
