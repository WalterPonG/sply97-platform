<?php

namespace App\Services;

use App\Models\User;
// Este servicio controla automáticamente la xp y puntos del usuario
class XpService
{
	public static function addXp(User $user, int $amount): void
	{
		$user->xp = ($user->xp ?? 0) + $amount;
		$user->save();
	}

	public static function addPoints(User $user, int $amount) :void
	{
		$user->points = ($user->points ?? 0 ) + $amount;
		$user->save();
	}

   /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
}
