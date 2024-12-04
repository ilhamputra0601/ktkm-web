<?php

use app\Filament\Resources\Auth\Logout;
use Illuminate\Support\Facades\Route;

Route::post('/logout', [Logout::class, 'logout'])->name('logout');

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/reel',function () {
    return view('kataReels');
})->name('kataReels');
