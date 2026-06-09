<?php
namespace App\Services;

use App\Models\User;
use App\Models\Mission;
use App\Models\UserMission;
use Illuminate\Support\Facades\DB;

class MissionService
{
    public static function getUserMissions($user)
    {
        $missions = Mission::query()->get()->map(function ($mission) use ($user) {

            $userMission = UserMission::firstOrCreate([
                'user_id' => $user->id,
                'mission_id' => $mission->id,
            ]);

            // 🔥 DAILY = por fecha
            if ($mission->type === 'daily') {

                $mission->completed =
                    $userMission->completed_at &&
                    $userMission->completed_at->isToday();

                $mission->claimed =
                    $userMission->claimed_at &&
                    $userMission->claimed_at->isToday();

            } else {

                // 🔥 ONE TIME = permanente
                $mission->completed = (bool) $userMission->completed_at;
                $mission->claimed = (bool) $userMission->claimed_at;
            }

            $mission->locked =
                $mission->available_at &&
                now()->lt($mission->available_at);

            if ($mission->locked) {
                $mission->status = 'locked';
            } elseif ($mission->claimed) {
                $mission->status = 'claimed';
            } elseif ($mission->completed) {
                $mission->status = 'claimable';
            } else {
                $mission->status = 'available';
            }

            return $mission;
        });

        return $missions->sortBy(function ($mission) {
            return match ($mission->status) {
                'locked' => 0,
                'available' => 1,
                'claimable' => 2,
                'claimed' => 3,
            };
        });
    }

public static function completeMission(User $user, int $missionId)
{
    $mission = Mission::findOrFail($missionId);

    if (!self::canComplete($user, $mission)) {
        return false;
    }

    $userMission = UserMission::firstOrCreate([
        'user_id' => $user->id,
        'mission_id' => $missionId,
    ]);

    // DAILY = una vez por día
    if ($mission->type === 'daily') {

        if (
            $userMission->completed_at &&
            $userMission->completed_at->isToday()
        ) {
            return false;
        }

    } else {

        // ONE TIME = una sola vez
        if ($userMission->completed_at) {
            return false;
        }
    }

    $userMission->update([
        'completed_at' => now(),
    ]);

    return true;
    }

    public static function claimMission(User $user, int $missionId)
    {
        return DB::transaction(function () use ($user, $missionId) {

            $userMission = UserMission::where('user_id', $user->id)
                ->where('mission_id', $missionId)
                ->firstOrFail();

            // 🔥 REGLA LIMPIA
            if (!$userMission->completed_at || $userMission->claimed_at) {
                return false;
            }

            $mission = $userMission->mission;

            $user->points += $mission->points_reward;
            $user->addXp($mission->xp_reward);
            $user->save();

            $userMission->update([
                'claimed_at' => now(),
            ]);

            return true;
        });
    }

    public static function completeByCondition(User $user, string $conditionKey)
    {
        $mission = Mission::where('condition_key', $conditionKey)->first();

        if (!$mission) return false;

        return self::completeMission($user, $mission->id);
    }

    public static function canComplete($user, $mission)
    {
        if (!$mission->condition_key) return false;

        if ($mission->available_at && now()->lt($mission->available_at)) {
            return false;
        }

        return match ($mission->condition_key) {

            'login_daily' => true,

            'upload_avatar' => !empty($user->avatar),

            'set_clash_tag' => !empty($user->clash_tag),

            'profile_complete' => (
                !empty($user->name) &&
                !empty($user->email) &&
                !empty($user->avatar) &&
                !empty($user->clash_tag)
            ),

            default => false,
        };
    }

    public static function getStatus($user, $mission)
    {
        $missions = self::getUserMissions($user);

        $current = $missions->firstWhere('id', $mission->id);

        return $current?->status ?? 'locked';
    }

    public static function isDailyCompleted($user, $mission)
    {
        $userMission = UserMission::where('user_id', $user->id)
            ->where('mission_id', $mission->id)
            ->first();

        return $userMission?->completed_at?->isToday() ?? false;
    }
}
