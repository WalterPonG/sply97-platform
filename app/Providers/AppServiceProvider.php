<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use App\Services\XpService;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {

	Event::listen(Login::class, function ($event) {

    	$user = $event->user;

    	$today = now()->startOfDay();
    	$last = $user->last_login_date?->startOfDay();

    // SI ES PRIMER LOGIN O NO ES AYER → RESET O INICIO
    		if (!$last) {
        		$user->login_streak = 1;
    		} elseif ($last->diffInDays($today) === 1) {
        		// continuidad
        		$user->login_streak += 1;
    		} elseif ($last->diffInDays($today) > 1) {
        		// rompió racha
        		$user->login_streak = 1;
    		}

    		$user->last_login_date = now();

    		// XP base
    		$xpBase = 10;

    		// BONUS POR STREAK
    		$bonus = min($user->login_streak * 2, 50); // cap 50 XP bonus

    	\App\Services\XpService::addXp($user, $xpBase + $bonus);

    	$user->save();
	});

    }
}
