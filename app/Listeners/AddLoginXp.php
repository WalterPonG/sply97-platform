<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Login;
use App\Services\XpService;

class AddLoginXp
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
	 $user = $event->user;

        if ($user->canReceiveDailyLoginXp()) {

            XpService::addXp($user, 10);

            $user->markLoginXp();
        }

    }
}
