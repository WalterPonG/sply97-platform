<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MissionService;
use Illuminate\Support\Facades\Auth;

class MissionController extends Controller
{
    public function index()
    {
$user = auth()->user();

if ($user) {
	MissionService::completeByCondition($user, 'login_daily');
}

    $missions = MissionService::getUserMissions(auth()->user());
$activeMissions = $missions->where('status', 'available');

$completedMissions = $missions->where('status', 'claimed');
$claimableMissions = $missions->where('status', 'claimable');
$lockedMissions = $missions->where('status', 'locked');


    $grouped = $missions->groupBy('group');

    $progress = $grouped->map(function ($missions) {

        $total = $missions->count();
        $completed = $missions->where('claimed', true)->count();

        return [
            'total' => $total,
            'completed' => $completed,
            'percent' => $total > 0 ? ($completed / $total) * 100 : 0,
            'missions' => $missions,
        ];
    });
    return view('missions.index', [
    'missions' => $missions,
    'activeMissions' => $activeMissions,
    'completedMissions' => $completedMissions,
    'claimableMissions' => $claimableMissions,
    'lockedMissions' => $lockedMissions,
    'progress' => $progress,
    ]);
    }

    public function complete($id)
    {
        MissionService::completeMission(Auth::user(), $id);

        return redirect('/misiones');
    }

    public function claim($id)
    {
        MissionService::claimMission(Auth::user(), $id);

	        return redirect('/misiones');
    }

}
