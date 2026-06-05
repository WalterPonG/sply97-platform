@php
$status = \App\Services\MissionService::getStatus(Auth::user(), $mission);
@endphp

<div class="
    bg-gray-800 p-4 rounded-xl border transition-all duration-300

```
@if($status === 'locked')
    border-gray-700 opacity-40 grayscale

@elseif($status === 'available')
    border-blue-600

@elseif($status === 'claimable')
    border-yellow-500 shadow-lg shadow-yellow-500/20

@elseif($status === 'claimed')
    border-green-600 opacity-75

@endif
```

">

```
{{-- TÍTULO --}}
<div class="font-bold text-white text-lg">
    {{ $mission->title }}
</div>

{{-- ESTADO --}}
<div class="mt-2 text-sm">

    @if($status === 'locked')

        <span class="text-gray-500">
            🔒 Bloqueada
        </span>

    @elseif($status === 'available')

        <span class="text-blue-400">
            🎯 Disponible
        </span>

    @elseif($status === 'claimable')

        <span class="text-yellow-400 font-semibold">
            🎁 Recompensa lista
        </span>

    @elseif($status === 'claimed')

        <span class="text-green-400">
            ✔ Completada
        </span>

    @endif

</div>

{{-- DESCRIPCIÓN --}}
<div class="text-gray-400 text-sm mt-2">
    {{ $mission->description }}
</div>

{{-- RECOMPENSAS --}}
<div class="mt-3 text-blue-400 text-sm">
    ⚡ {{ $mission->xp_reward }} XP · 💰 {{ $mission->points_reward }} puntos
</div>

{{-- ACCIONES --}}
<div class="mt-4">

    @if($status === 'locked')

        <span class="bg-gray-900 text-gray-400 px-3 py-1 rounded text-sm">
            🔒 No disponible
        </span>

    @elseif($status === 'available')

        <form method="POST"
              action="/misiones/{{ $mission->id }}/complete"
              onsubmit="showComplete(event)">
            @csrf

            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-500 px-3 py-1 rounded text-white text-sm transition">
                🎯 Completar
            </button>
        </form>

    @elseif($status === 'claimable')

        <form method="POST"
              action="/misiones/{{ $mission->id }}/claim"
              onsubmit="showReward({{ $mission->xp_reward }}, {{ $mission->points_reward }})">
            @csrf

            <button
                type="submit"
                class="bg-yellow-500 hover:bg-yellow-400 animate-pulse px-3 py-1 rounded text-black font-semibold text-sm transition">
                🎁 Reclamar recompensa
            </button>
        </form>

    @elseif($status === 'claimed')

        <span class="bg-green-900 text-green-300 px-3 py-1 rounded text-sm">
            ✔ Recompensa obtenida
        </span>

    @endif

</div>
```

</div>
