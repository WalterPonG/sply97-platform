<?php

use App\Http\Controllers\ProfileController; // cargamos interfaz perfil
use App\Models\User; // cargo usuario
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MissionController;
Route::get('/', function () {
    return redirect('/login');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/misiones', [MissionController::class, 'index']);
    Route::post('/misiones/{id}/complete', [MissionController::class, 'complete']);
    Route::post('/misiones/{id}/claim', [MissionController::class, 'claim']);


  Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
/*
    Route::get('/profile/{user}', function (\App\Models\User $user) {
        return view('profile.show', compact('user'));
    });
*/
    Route::get('/leaderboard', function () {
        return view('leaderboard');
    });

    Route::get('/clans', function () {
        return view('clans');
    });

    Route::get('/wars', function () {
        return view('wars');
    });


});


require __DIR__.'/auth.php';
