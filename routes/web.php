<?php

use Illuminate\Support\Facades\Route;
//use App\Http\Livewire\Input;
//use App\Http\Livewire\Confirm;
//use App\Http\Livewire\Complete;

use App\Http\Livewire\SimpleForm\Input as SimpleFormInput;
use App\Http\Livewire\SimpleForm\Confirm as SimpleFormConfirm;
use App\Http\Livewire\SimpleForm\Complete as SimpleFormComplete;

use App\Http\Livewire\OrderForm\Input as OrderFormInput;
use App\Http\Livewire\OrderForm\Confirm as OrderFormConfirm;

//Route::get('/', Input::class)->name('home');
//Route::get('/confirm', Confirm::class)->name('confirm');
//Route::get('/complete', Complete::class)->name('complete');

// SimpleForm
Route::get('/simpleform/', SimpleFormInput::class)->name('simple-form-input');
Route::get('/simpleform/confirm', SimpleFormConfirm::class)->name('simple-form-confirm');
Route::get('/simpleform/complete', SimpleFormComplete::class)->name('simple-form-complete');

// OrderForm
Route::get('/orderform/', OrderFormInput::class)->name('order-form-input');
Route::get('/orderform/confirm', OrderFormConfirm::class)->name('order-form-confirm');

