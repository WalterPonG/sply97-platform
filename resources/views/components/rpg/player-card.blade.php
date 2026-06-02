<div class="bg-gray-800 rounded-xl p-6 border border-gray-700 shadow-lg">

    <div class="flex items-center gap-4">

        <div class="w-16 h-16 rounded-full overflow-hidden bg-gray-700">
            @if(Auth::user()->avatar)
                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center text-white">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            @endif
        </div>

        <div>
            <div class="text-white font-bold">
                {{ Auth::user()->name }}
            </div>

            <div class="text-gray-400 text-sm">
                {{ Auth::user()->clash_tag ?? 'Sin tag' }}
            </div>
        </div>

    </div>

</div>
