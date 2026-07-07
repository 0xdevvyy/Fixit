<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
     Route::get('/dashboard', DashboardController::class)->name('dashboard');
     Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');


});

require __DIR__.'/settings.php';
