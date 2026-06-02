<div class="bg-gray-800 rounded-xl p-6 border border-gray-700 text-center">

    <div class="text-2xl">
        🔥
    </div>

    <div class="text-white font-bold text-lg">
        {{ Auth::user()->login_streak ?? 0 }} días
    </div>

    <div class="text-gray-400 text-sm">
        Racha diaria
    </div>

</div>
