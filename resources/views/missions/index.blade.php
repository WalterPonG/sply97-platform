<x-app-layout>

<div class="mb-6">
    <h1 class="text-3xl font-bold tracking-wide">
        ⚔️ Misiones
    </h1>
    <p class="text-gray-300 text-sm">
        Completa objetivos y reclama recompensas
    </p>
</div>

<div class="space-y-8">

@foreach($progress as $groupName => $data)

    <div class="relative">

        <!-- HEADER ESTILO SUPER CELL -->
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-xl font-bold text-yellow-300 drop-shadow">
                {{ strtoupper($groupName) }}
            </h2>

            <div class="text-sm text-gray-300">
                {{ $data['completed'] }}/{{ $data['total'] }}
            </div>
        </div>

        <!-- PROGRESS BAR -->
        <div class="h-3 w-full bg-black/50 rounded-full overflow-hidden border border-yellow-500/30">
            <div class="h-full bg-gradient-to-r from-yellow-400 to-orange-500"
                 style="width: {{ $data['percent'] }}%">
            </div>
        </div>

        <!-- MISSIONS GRID -->
        <div class="grid md:grid-cols-2 gap-4 mt-4">

            @foreach($data['missions'] as $mission)
                @include('missions.partials.card', ['mission' => $mission])
            @endforeach

        </div>

    </div>

@endforeach

</div>

</x-app-layout>
