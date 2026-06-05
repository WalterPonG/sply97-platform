<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\XpService;
use App\Services\MissionService;
use Carbon\Carbon;

class DailyActivityMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user) {

            $today = now()->toDateString();
            $last = $user->last_login_date?->toDateString();

            // 🔥 DEBUG (temporal)
/*            dd([
                'today' => $today,
                'last_login_date' => $last,
                'streak_before' => $user->login_streak,
            ]);
*/
            // =========================
            // LÓGICA REAL (NO SE EJECUTA HASTA QUITAR DD)
            // =========================
	    if($last === $today) {
		return $next($request);
	    }

            if (!$last) {
                $user->login_streak = 1;
            } elseif (Carbon::parse($last)->addDay()->toDateString() === $today) {
                $user->login_streak++;
            } else {
                $user->login_streak = 1;
            }

            $user->last_login_date = now();

            $xpBase = 10;
            $bonus = min($user->login_streak * 2, 50);

            XpService::addXp(
                $user,
                $xpBase + $bonus
            );

            MissionService::completeDailyLoginMission($user);

            $user->save();
        }

        return $next($request);
    }
}
