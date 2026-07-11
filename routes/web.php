<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TicketAttachmentController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
     Route::get('/dashboard', DashboardController::class)->name('dashboard');
     Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
     Route::get('/tickets/create', [TicketController::class,'create'])->name('tickets.create');
     Route::post('/tickets/store', [TicketController::class, 'store'])->name('tickets.store');
     Route::get('/tickets/{ticket}/show', [TicketController::class, 'show'])->name('tickets.show');

     Route::post('/tickets/{ticket}/attachment', [TicketAttachmentController::class, 'store'])->name('tickets.attachment.store');


});

require __DIR__.'/settings.php';
