<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceItemController;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::view('profile/edit', 'profile')
    ->middleware(['auth'])
    ->name('profile.edit');

// Invoice Management Routes - Protected by Auth
Route::middleware(['auth', 'verified'])->group(function () {
    // Clients
    Route::resource('clients', ClientController::class);
    
    // Projects
    Route::resource('projects', ProjectController::class);
    
    // Invoices
    Route::resource('invoices', InvoiceController::class);
    Route::get('invoices/{invoice}/pdf', [InvoiceController::class, 'downloadPdf'])->name('invoices.pdf');
    
    // Invoice Items
    Route::resource('invoices.invoice-items', InvoiceItemController::class)
        ->except(['index']);
    
    // Invoice Items Index (separate route)
    Route::get('invoices/{invoice}/invoice-items', [InvoiceItemController::class, 'index'])
        ->name('invoice-items.index');
});

require __DIR__.'/auth.php';
