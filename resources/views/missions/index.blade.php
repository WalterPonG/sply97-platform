<x-app-layout>
<div class="max-w-7xl mx-auto px-6 py-8">

    <h1 class="text-white text-2xl font-bold mb-6">
        🎮 Misiones
    </h1>

    @foreach($progress as $groupName => $data)

        <div class="bg-gray-800 p-4 rounded-xl mb-6">

            {{-- HEADER GRUPO --}}
            <h2 class="text-white font-bold text-lg mb-2">
                📦 {{ ucfirst($groupName) }}
            </h2>

            {{-- PROGRESS BAR --}}
            <div class="w-full bg-gray-700 rounded h-3 mb-2">
                <div class="bg-green-500 h-3 rounded"
                     style="width: {{ $data['percent'] }}%">
                </div>
            </div>

            <p class="text-sm text-gray-400 mb-4">
                {{ $data['completed'] }} / {{ $data['total'] }} completadas
            </p>

            {{-- MISIONES --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                @foreach($data['missions'] as $mission)
                    @include('missions.partials.card', ['mission' => $mission])
                @endforeach

            </div>

        </div>

    @endforeach

</div>
</x-app-layout>
