<div class="bg-gray-800 rounded-xl p-6 border border-gray-700">

    <div class="grid grid-cols-3 gap-2 text-center">

        <div class="bg-gray-900 p-3 rounded">
            <div class="text-yellow-400 font-bold">
                {{ Auth::user()->points }}
            </div>
            <div class="text-xs text-gray-400">Points</div>
        </div>

        <div class="bg-gray-900 p-3 rounded">
            <div class="text-blue-400 font-bold">
                {{ Auth::user()->xp }}
            </div>
            <div class="text-xs text-gray-400">XP</div>
        </div>

        <div class="bg-gray-900 p-3 rounded">
            <div class="text-green-400 font-bold">
                Lv {{ Auth::user()->level }}
            </div>
            <div class="text-xs text-gray-400">Level</div>
        </div>

    </div>

    @php
        $currentXp = Auth::user()->xp % 100;
        $percent = ($currentXp / 100) * 100;
    @endphp

    <div class="mt-4">
        <div class="h-2 bg-gray-700 rounded-full overflow-hidden">
            <div class="h-full bg-blue-500 transition-all" style="width: {{ $percent }}%"></div>
        </div>
        <div class="text-xs text-gray-400 mt-1 text-right">
            {{ $currentXp }}/100 XP
        </div>
    </div>

</div>
