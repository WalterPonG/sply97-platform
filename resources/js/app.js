

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

window.showXP = function(amount) {
    const el = document.createElement('div');
    el.innerText = `+${amount} XP`;

    el.className = `
        fixed bottom-20 right-6
        bg-blue-500 text-white px-4 py-2 rounded-lg
        shadow-lg animate-bounce
        z-50
    `;

    document.body.appendChild(el);

    setTimeout(() => el.remove(), 1200);
};

window.showReward = function(xp, points) {
    showXP(xp);

    const el = document.createElement('div');
    el.innerHTML = `
        🎉 Recompensa obtenida<br>
        +${xp} XP<br>
        +${points} monedas
    `;

    el.className = `
        fixed inset-0 flex items-center justify-center
        text-white text-xl font-bold
        bg-black/60 z-50
    `;

    document.body.appendChild(el);

    setTimeout(() => el.remove(), 1200);
};
window.showComplete = function () {
    const popup = document.getElementById('rewardPopup');

    popup.innerHTML = `<div class="text-yellow-400">✔ Misión completada</div>`;
    popup.classList.remove('hidden');

    setTimeout(() => popup.classList.add('hidden'), 1200);
};

window.bigReward = function (xp, points) {
    const screen = document.createElement('div');

    screen.className = `
        fixed inset-0 bg-black/80 flex items-center justify-center text-center z-50
    `;

    screen.innerHTML = `
        <div class="bg-gray-900 p-8 rounded-xl">
            <h1 class="text-green-400 text-2xl font-bold">RECOMPENSA</h1>
            <p class="text-white mt-2">+${xp} XP</p>
            <p class="text-blue-400">+${points} puntos</p>
        </div>
    `;

    document.body.appendChild(screen);

    setTimeout(() => screen.remove(), 2500);
};

function addFeed(message, type = 'info') {
    const feed = document.getElementById('eventFeed');

    const el = document.createElement('div');

    const color = {
        success: 'text-green-400',
        xp: 'text-purple-400',
        level: 'text-yellow-400',
        info: 'text-gray-300',
    }[type];

    el.className = `bg-gray-900 p-2 rounded text-sm ${color} mb-2 animate-pulse`;

    el.innerText = message;

    feed.prepend(el);

    setTimeout(() => {
        el.remove();
    }, 4000);
}


