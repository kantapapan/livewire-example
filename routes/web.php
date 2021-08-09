<?php

use Illuminate\Support\Facades\Route;
//use App\Http\Livewire\Input;
//use App\Http\Livewire\Confirm;
//use App\Http\Livewire\Complete;

use App\Http\Livewire\SimpleForm\Input;
use App\Http\Livewire\SimpleForm\Confirm;
use App\Http\Livewire\SimpleForm\Complete;

//Route::get('/', Input::class)->name('home');
//Route::get('/confirm', Confirm::class)->name('confirm');
//Route::get('/complete', Complete::class)->name('complete');

// SimpleForm
Route::get('/simpleform/', Input::class)->name('simple-form-input');
Route::get('/simpleform/confirm', Confirm::class)->name('simple-form-confirm');
Route::get('/simpleform/complete', Complete::class)->name('simple-form-complete');
