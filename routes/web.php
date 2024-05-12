<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');


Route::get('dashboard/{channel}', function (App\Models\Channel $channel) {
    return view('chat', ['channel' => $channel]);
})
    ->middleware(['auth'])
    ->name('dashboard.chat');

require __DIR__ . '/auth.php';
