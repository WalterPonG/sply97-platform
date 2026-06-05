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
    \App\Services\MissionService::completeDailyLoginMission($user);
}

    $missions = MissionService::getUserMissions(auth()->user());

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
    return view('missions.index', compact('progress'));
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
