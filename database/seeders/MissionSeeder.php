<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mission;

class MissionSeeder extends Seeder
{
    public function run(): void
    {
        Mission::create([
            'title' => 'Inicia sesión',
            'description' => 'Entra al sistema diario',
            'xp_reward' => 10,
            'points_reward' => 5,
            'type' => 'daily',
        ]);

        Mission::create([
            'title' => 'Revisa tu perfil',
            'description' => 'Visita tu página de perfil',
            'xp_reward' => 20,
            'points_reward' => 10,
            'type' => 'one_time'
        ]);
    }
}
