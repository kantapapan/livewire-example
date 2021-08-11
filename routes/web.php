<?php

use Illuminate\Support\Facades\Route;

use App\Http\Livewire\SimpleForm\Input as SimpleFormInput;
use App\Http\Livewire\SimpleForm\Confirm as SimpleFormConfirm;
use App\Http\Livewire\SimpleForm\Complete as SimpleFormComplete;

use App\Http\Livewire\OrderForm\Input as OrderFormInput;
use App\Http\Livewire\OrderForm\Confirm as OrderFormConfirm;

use App\Http\Livewire\MultiStepForm\Input as MultiStepFormInput;
use App\Http\Livewire\MultiStepForm\Input2 as MultiStepFormInput2;
use App\Http\Livewire\MultiStepForm\Confirm as MultiStepFormConfirm;
use App\Http\Livewire\MultiStepForm\Complete as MultiStepFormComplete;

// SimpleForm
Route::get('/simpleform/', SimpleFormInput::class)->name('simple-form-input');
Route::get('/simpleform/confirm', SimpleFormConfirm::class)->name('simple-form-confirm');
Route::get('/simpleform/complete', SimpleFormComplete::class)->name('simple-form-complete');

// OrderForm
Route::get('/orderform/', OrderFormInput::class)->name('order-form-input');
Route::get('/orderform/confirm', OrderFormConfirm::class)->name('order-form-confirm');

// MultiStepForm
Route::get('/multistepform/', MultiStepFormInput::class)->name('multi-step-form-input');
Route::get('/multistepform/input2', MultiStepFormInput2::class)->name('multi-step-form-input2');
Route::get('/multistepform/confirm', MultiStepFormConfirm::class)->name('multi-step-form-confirm');
Route::get('/multistepform/complete', MultiStepFormComplete::class)->name('multi-step-form-complete');

