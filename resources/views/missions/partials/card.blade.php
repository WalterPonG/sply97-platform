@php
    $canComplete = \App\Services\MissionService::canComplete(Auth::user(), $mission);
@endphp

<div class="bg-gray-800 p-4 rounded-xl border border-gray-700">

    <div class="font-bold text-white text-lg">
        {{ $mission->title }}
    </div>

    <div class="text-gray-400 text-sm mt-1">
        {{ $mission->description }}
    </div>

    <div class="mt-2 text-blue-400 text-sm">
        ⚡ {{ $mission->xp_reward }} XP · 💰 {{ $mission->points_reward }} puntos
    </div>

    <div class="mt-4">

        {{-- COMPLETADA --}}
        @if(isset($completed) && $completed)

            <span class="bg-green-900 text-green-300 px-3 py-1 rounded text-sm">
                ✔ Completada
            </span>

        {{-- RECLAMABLE --}}
        @elseif($mission->completed && !$mission->claimed)

            <form method="POST" action="/misiones/{{ $mission->id }}/claim">
                @csrf
                <button class="bg-green-600 px-3 py-1 rounded text-white text-sm">
                    🎁 Reclamar recompensa
                </button>
            </form>

        {{-- PENDIENTE --}}
        @elseif($canComplete && !$mission->completed)

            <form method="POST" action="/misiones/{{ $mission->id }}/complete">
                @csrf
                <button class="bg-blue-600 px-3 py-1 rounded text-white text-sm">
                    ✔ Completar
                </button>
            </form>

        {{-- BLOQUEADA --}}
        @else

            <span class="bg-gray-900 text-gray-400 px-3 py-1 rounded text-sm">
                🔒 No disponible
            </span>

        @endif

    </div>

</div>
