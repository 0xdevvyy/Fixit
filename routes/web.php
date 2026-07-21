<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TicketAcceptController;
use App\Http\Controllers\TicketAttachmentController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
     Route::get('/dashboard', DashboardController::class)->name('dashboard');
     Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');

     //will group this
     Route::get('/tickets/create', [TicketController::class,'create'])->name('tickets.create');
     Route::post('/tickets/store', [TicketController::class, 'store'])->name('tickets.store');
     Route::get('/tickets/{ticket}/show', [TicketController::class, 'show'])->name('tickets.show');
     Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
     Route::patch('/tickets/{ticket}/update', [TicketController::class, 'update'])->name('tickets.update');

     Route::delete('/tickets/{ticket}/delete', [TicketController::class, 'destroy'])->name('tickets.delete');

     Route::post('/tickets/{ticket}/attachment', [TicketAttachmentController::class, 'store'])->name('tickets.attachment.store');
     Route::patch('/tickets/{ticket}/accept',TicketAcceptController::class)->name('ticket.accept');


});

require __DIR__.'/settings.php';
