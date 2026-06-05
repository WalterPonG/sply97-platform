<?php
namespace App\Services;

use App\Models\User;
use App\Models\Mission;
use App\Models\UserMission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MissionService
{

    public static function getUserMissions($user)
    {
        return Mission::query()->get()->map(function ($mission) use ($user) {

            $userMission = UserMission::firstOrCreate([
                'user_id' => $user->id,
                'mission_id' => $mission->id,
            ]);

            $mission->completed = $userMission->completed;
            $mission->claimed = $userMission->claimed;

            $mission->locked = $mission->available_at && now()->lt($mission->available_at);
		 // 🎮 status calculado
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

	// 👇 AQUÍ ES DONDE VA TU SORT
    return $missions->sortBy(function ($mission) {
        return match ($mission->status) {
            'locked' => 0,
            'available' => 1,
            'claimable' => 2,
            'claimed' => 3,
        };
    	});
    }
	public static function completeByCondition(User $user, string $conditionKey)
	{
    		$mission = Mission::where('condition_key', $conditionKey)->first();

    		if (!$mission) {
        		return false;
    		}

    		return self::completeMission($user, $mission->id);
	}

	public static function tryComplete($user, $mission)
	{
    	if (!self::canComplete($user, $mission)) {
        return false;
    }

    return self::completeMission($user, $mission->id);
}

	public static function completeMission(User $user, int $missionId)
{
    $mission = Mission::findOrFail($missionId);

    if (!self::canComplete($user, $mission)) {
        return false; //  no cumple requisitos
    }

    $userMission = UserMission::firstOrCreate([
        'user_id' => $user->id,
        'mission_id' => $missionId,
    ]);

    if ($userMission->completed) {
        return false;
    }

    $userMission->update([
        'completed' => true,
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

            if (!$userMission->completed || $userMission->claimed) {
                return false;
            }

            $mission = $userMission->mission;

            // sumar recompensas
            $user->points += $mission->points_reward;
	    $user->addXp($mission->xp_reward);
            $user->save();

            $userMission->update([
                'claimed' => true,
            ]);

            return true;
        });
    }



    public static function completeDailyLoginMission($user)
    {
    $mission = Mission::where('condition_key', 'login_daily')->first();

    if (!$mission) {
        return;
    }

    $userMission = UserMission::firstOrCreate([
        'user_id' => $user->id,
        'mission_id' => $mission->id,
    ]);

    $today = now()->toDateString();
    $last = optional($userMission->completed_at)->toDateString();

    // 🔥 YA HECHO HOY → no repetir
    if ($last === $today) {
        return;
    }

    $userMission->update([
        'completed' => true,
        'completed_at' => now(),
    ]);


   
    }

    public static function canComplete($user, $mission)
    {

	if(!$mission->condition_key){
		return false;
	}
	// bloqueos temporales por fecha
	if($mission->available_at && now()->lt($mission->available_at)){
		return false;
	}
    return match ($mission->condition_key) {

        'login_daily' => true, // lo controlas en login event

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
    $userMission = UserMission::firstOrCreate([
        'user_id' => $user->id,
        'mission_id' => $mission->id,
    ]);

    if ($userMission->claimed) return 'claimed';

    if ($userMission->completed) return 'claimable';

    if (!self::canComplete($user, $mission)) return 'available';

    return 'locked';
}
public static function isDailyCompleted($user, $mission)
{
    $userMission = UserMission::where('user_id', $user->id)
        ->where('mission_id', $mission->id)
        ->first();

    if (!$userMission || !$userMission->completed_at) {
        return false;
    }

    return $userMission->completed_at->isToday();
}
}
