<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('contact.index');
});
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'create'])->name('contact.create');

Route::fallback(function () {
    return redirect()->route('contact.index');
});
