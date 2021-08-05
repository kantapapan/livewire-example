<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Input;
use App\Http\Livewire\Confirm;
use App\Http\Livewire\Complete;

Route::get('/', Input::class)->name('home');
Route::get('/confirm', Confirm::class)->name('confirm');
Route::get('/complete', Complete::class)->name('complete');
