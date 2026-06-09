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

        // 🔥 evitar doble ejecución el mismo día
        if ($last === $today) {
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

        // 🎯 SISTEMA NUEVO DE MISIÓN
        MissionService::completeByCondition($user, 'login_daily');

        $user->save();
    }

    return $next($request);
}
}
