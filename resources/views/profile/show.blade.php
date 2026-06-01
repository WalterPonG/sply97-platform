<div class="max-w-3xl mx-auto bg-gray-900 p-6 rounded-xl text-white">

    <h1 class="text-3xl font-bold mb-4">
        {{ $user->name }}
    </h1>

    <p>⭐ Level: {{ $user->level() }}</p>
    <p>💰 Points: {{ $user->points }}</p>
    <p>⚡ XP: {{ $user->xp }}</p>

</div>
