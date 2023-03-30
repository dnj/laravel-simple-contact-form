<?php

use dnj\SimpleContactForm\Http\Controllers\ContactController;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Support\Facades\Route;

Route::middleware(['api', SubstituteBindings::class])->group(function () {
    Route::post('contact-form', [ContactController::class, 'store'])->name('contact-form.store');
    Route::middleware('auth')->group(function () {
        Route::get('contact-form', [ContactController::class, 'index'])->name('contact-form.index');
        Route::get('contact-form/{formId}', [ContactController::class, 'show'])->name('contact-form.show');
        Route::put('contact-form/{formId}', [ContactController::class, 'update'])->name('contact-form.update');
        Route::delete('contact-form/{formId}', [ContactController::class, 'delete'])->name('contact-form.destroy');
    });
});
