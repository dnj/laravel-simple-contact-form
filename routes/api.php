<?php

use dnj\SimpleContactForm\Http\Controllers\ContactController;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Support\Facades\Route;

Route::middleware(['api', SubstituteBindings::class])->prefix('contacts')->name('contacts.')->group(function () {
    Route::get('/{contact}', [ContactController::class, 'index'])->name('index');
    Route::post('', [ContactController::class, 'store'])->name('store');
    Route::put('/{contact}', [ContactController::class, 'update'])->middleware('auth')->name('update');
    Route::delete('/{contact}', [ContactController::class, 'delete'])->middleware('auth')->name('destroy');
});
