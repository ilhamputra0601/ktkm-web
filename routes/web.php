<?php

use Illuminate\Support\Facades\Route;
use app\Filament\Resources\Auth\Logout;
use App\Http\Controllers\ReelController;
use App\Livewire\Components\Reels\Card\ShowCard;

Route::post('/logout', [Logout::class, 'logout'])->name('logout');

Route::get('/', function () {
    return view('home');
})->name('home');


Route::resource('/reel', ReelController::class);
Route::get('/reel/{reel:slug}',ShowCard::class)->name('reel.show');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');
