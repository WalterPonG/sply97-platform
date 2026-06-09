@php
$status = \App\Services\MissionService::getStatus(Auth::user(), $mission);
@endphp

<div class="
    relative z-10 p-4 rounded-2xl border backdrop-blur-md
    transition transform hover:scale-[1.02]

    @if($status === 'locked')
        opacity-40 grayscale border-gray-600
    @elseif($status === 'available')
        border-blue-500 bg-blue-500/10
    @elseif($status === 'claimable')
        border-yellow-400 bg-yellow-500/10 shadow-lg shadow-yellow-500/20
    @elseif($status === 'claimed')
        border-green-500 bg-green-500/10 opacity-70
    @endif
">

    <!-- ICONO ESTILO LOOT -->
    <div class="absolute -top-3 -right-3 text-2xl">
        @if($status === 'locked') 🔒
        @elseif($status === 'available') ⚔️
        @elseif($status === 'claimable') 🎁
        @elseif($status === 'claimed') ✔
        @endif
    </div>

    <!-- TITLE -->
    <div class="text-lg font-bold">
        {{ $mission->title }}
    </div>

    <!-- DESC -->
    <div class="text-sm text-gray-300 mt-1">
        {{ $mission->description }}
    </div>

    <!-- REWARDS -->
    <div class="mt-3 flex gap-3 text-sm">
        <div class="bg-black/40 px-2 py-1 rounded">
            ⚡ {{ $mission->xp_reward }} XP
        </div>
        <div class="bg-black/40 px-2 py-1 rounded">
            💰 {{ $mission->points_reward }}
        </div>
    </div>

    <!-- ACTION -->
    <div class="mt-4">

        @if($status === 'available')

            <form method="POST" action="/misiones/{{ $mission->id }}/complete">
                @csrf
                <button class="w-full bg-blue-600 hover:bg-blue-500 py-2 rounded-xl font-bold">
                    ⚔️ Completar
                </button>
            </form>

        @elseif($status === 'claimable')

            <form method="POST"
                  action="/misiones/{{ $mission->id }}/claim"
                  onsubmit="showReward({{ $mission->xp_reward }}, {{ $mission->points_reward }})">
                @csrf
                <button class="w-full bg-yellow-500 hover:bg-yellow-400 py-2 rounded-xl font-bold text-black animate-pulse">
                    🎁 Reclamar
                </button>
            </form>

        @elseif($status === 'claimed')

            <div class="text-center text-green-300 font-bold">
                ✔ Reclamado
            </div>

        @else

            <div class="text-center text-gray-400">
                🔒 Bloqueado
            </div>

        @endif

    </div>

</div>
