<?php

use dnj\SimpleContactForm\Http\Controllers\ContactController;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Support\Facades\Route;

Route::middleware(['api', SubstituteBindings::class])->name('contacts.')->group(function () {
    Route::get('index', [ContactController::class, 'index'])->name('index');
    Route::post('store', [ContactController::class, 'store'])->name('store');
    Route::put('update/{contact}', [ContactController::class, 'update'])->middleware('auth')->name('update');
    Route::delete('delete/{contact}', [ContactController::class, 'delete'])->middleware('auth')->name('delete');
});
